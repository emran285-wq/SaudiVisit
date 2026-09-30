<?php
/** Article editor: content, SEO panel, workflow actions, sources, taxonomy.
 *  Workflow: draft → in_review → fact_review → approved → published → archived.
 *  Writers cannot publish; writers can only edit their own drafts. */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';

$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$locale = DEFAULT_LOCALE;

$article = null;
$loc = null;
if ($articleId) {
    $article = q('SELECT * FROM articles WHERE id = ?', [$articleId])->fetch();
    if (!$article) {
        http_response_code(404);
        exit('Article not found');
    }
    $loc = q("SELECT * FROM article_localizations WHERE article_id = ? AND locale = ?", [$articleId, $locale])->fetch();
    if ($loc && !can_edit_article($user, $article)) {
        http_response_code(403);
        exit('Forbidden: writers can only edit their own drafts.');
    }
}

$allDestinations = get_destinations($locale);
$allTopics = q('SELECT * FROM topics WHERE locale = ?', [$locale])->fetchAll();
$allAuthors = q('SELECT * FROM authors ORDER BY name')->fetchAll();
$selectedDests = $articleId ? array_column(q('SELECT destination_id FROM article_destination WHERE article_id = ?', [$articleId])->fetchAll(), 'destination_id') : [];
$selectedTopics = $articleId ? array_column(q('SELECT topic_id FROM article_topic WHERE article_id = ?', [$articleId])->fetchAll(), 'topic_id') : [];
$sources = $loc ? get_article_sources((int)$loc['id']) : [];

/* ---------- POST handling ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = (string)($_POST['action'] ?? 'save');

    if ($action === 'create') {
        $title = trim((string)$_POST['title']);
        if ($title === '') {
            flash('Title is required.');
            redirect(BASE_PATH . '/admin/article-edit.php');
        }
        db()->beginTransaction();
        q('INSERT INTO articles (owner_id, primary_author_id) VALUES (?, ?)', [$user['id'], $allAuthors[0]['id'] ?? null]);
        $newId = (int)db()->lastInsertId();
        q(
            "INSERT INTO article_localizations (article_id, locale, slug, title) VALUES (?, ?, ?, ?)",
            [$newId, $locale, slugify($title) . '-' . $newId, $title]
        );
        audit((int)$user['id'], 'create', 'article', $newId);
        db()->commit();
        redirect(BASE_PATH . '/admin/article-edit.php?id=' . $newId);
    }

    if (!$article || !$loc) {
        http_response_code(400);
        exit('Bad request');
    }

    $locId = (int)$loc['id'];

    // Workflow transitions (role-gated)
    if (in_array($action, ['submit_review', 'fact_check', 'approve', 'publish', 'unpublish', 'reject'], true)) {
        $from = $loc['state'];
        $allowed = [
            'submit_review' => ['from' => ['draft'], 'to' => 'in_review', 'roles' => ['admin', 'editor', 'writer']],
            'fact_check'    => ['from' => ['in_review'], 'to' => 'fact_review', 'roles' => ['admin', 'editor', 'reviewer']],
            'approve'       => ['from' => ['fact_review', 'in_review'], 'to' => 'approved', 'roles' => ['admin', 'editor']],
            'publish'       => ['from' => ['approved', 'published'], 'to' => 'published', 'roles' => ['admin', 'editor']],
            'unpublish'     => ['from' => ['published'], 'to' => 'archived', 'roles' => ['admin', 'editor']],
            'reject'        => ['from' => ['in_review', 'fact_review', 'approved'], 'to' => 'draft', 'roles' => ['admin', 'editor', 'reviewer']],
        ];
        $rule = $allowed[$action];
        if (!in_array($user['role'], $rule['roles'], true) || !in_array($from, $rule['from'], true)) {
            http_response_code(403);
            exit("Transition $action not allowed from state $from for role {$user['role']}.");
        }
        if ($action === 'publish') {
            // Publishing validation per PRD: title, slug, author, body, excerpt, taxonomy, metadata
            $problems = [];
            foreach (['title' => 'title', 'excerpt' => 'excerpt', 'body' => 'body', 'meta_description' => 'meta description'] as $f => $label) {
                if (trim((string)$loc[$f]) === '') { $problems[] = "Missing $label."; }
            }
            if (!$article['primary_author_id']) { $problems[] = 'Missing author.'; }
            if (!$selectedDests && !$selectedTopics) { $problems[] = 'Assign at least one destination or topic.'; }
            if ($problems) {
                flash('Cannot publish: ' . implode(' ', $problems));
                redirect(BASE_PATH . '/admin/article-edit.php?id=' . $articleId);
            }
        }
        $now = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $fields = 'state = ?';
        $params = [$rule['to']];
        if ($action === 'publish') {
            $fields .= ', published_at = COALESCE(published_at, ?), reviewed_at = ?';
            $sla = $loc['content_type'] === 'policy' ? REVIEW_SLA_POLICY : (in_array($loc['content_type'], ['practical'], true) ? REVIEW_SLA_TRANSPORT : REVIEW_SLA_EVERGREEN);
            $fields .= ', review_due_at = DATE_ADD(?, INTERVAL ' . (int)$sla . ' DAY), reviewer_id = ?';
            $params[] = $now; $params[] = $now; $params[] = $now; $params[] = $user['id'];
        }
        if ($action === 'fact_check') {
            $fields .= ', reviewed_at = ?, reviewer_id = ?';
            $params[] = $now; $params[] = $user['id'];
        }
        $params[] = $locId;
        q("UPDATE article_localizations SET $fields WHERE id = ?", $params);
        audit((int)$user['id'], $action, 'article_localization', $locId, ['from' => $from, 'to' => $rule['to']]);
        flash("State changed: $from → {$rule['to']}.");
        redirect(BASE_PATH . '/admin/article-edit.php?id=' . $articleId);
    }

    // Save content
    if ($action === 'save') {
        $newSlug = slugify((string)$_POST['slug'] ?: (string)$_POST['title']);
        $oldSlug = $loc['slug'];

        // Revision snapshot before overwrite
        q('INSERT INTO revisions (localization_id, title, body, actor_id, review_notes) VALUES (?,?,?,?,?)',
          [$locId, $loc['title'], $loc['body'], $user['id'], (string)($_POST['review_notes'] ?? '')]);

        q(
            "UPDATE article_localizations SET
                title = ?, slug = ?, excerpt = ?, body = ?,
                seo_title = ?, meta_description = ?, content_type = ?,
                substantive_updated_at = IF(state = 'published', UTC_TIMESTAMP(), substantive_updated_at)
             WHERE id = ?",
            [
                trim((string)$_POST['title']),
                $newSlug,
                trim((string)$_POST['excerpt']),
                sanitize_html((string)$_POST['body']),
                trim((string)$_POST['seo_title']) ?: null,
                trim((string)$_POST['meta_description']) ?: null,
                in_array($_POST['content_type'] ?? '', ['guide','pillar','itinerary','practical','policy'], true) ? $_POST['content_type'] : 'guide',
                $locId,
            ]
        );

        q('UPDATE articles SET primary_author_id = ? WHERE id = ?', [(int)($_POST['author_id'] ?? 0) ?: null, $articleId]);

        // Taxonomy
        q('DELETE FROM article_destination WHERE article_id = ?', [$articleId]);
        foreach (array_map('intval', (array)($_POST['destinations'] ?? [])) as $dId) {
            q('INSERT IGNORE INTO article_destination (article_id, destination_id) VALUES (?, ?)', [$articleId, $dId]);
        }
        q('DELETE FROM article_topic WHERE article_id = ?', [$articleId]);
        foreach (array_map('intval', (array)($_POST['topics'] ?? [])) as $tId) {
            q('INSERT IGNORE INTO article_topic (article_id, topic_id) VALUES (?, ?)', [$articleId, $tId]);
        }

        // Sources: replace-all from textarea lines "URL | publisher | section"
        q('DELETE FROM sources WHERE localization_id = ?', [$locId]);
        foreach (preg_split('/\R/', (string)($_POST['sources'] ?? '')) ?: [] as $line) {
            $line = trim($line);
            if ($line === '') { continue; }
            [$sUrl, $sPub, $sSection] = array_pad(array_map('trim', explode('|', $line)), 3, null);
            if ($sUrl && filter_var($sUrl, FILTER_VALIDATE_URL) && in_array(parse_url($sUrl, PHP_URL_SCHEME), ['http', 'https'], true)) {
                q('INSERT INTO sources (localization_id, source_url, publisher, claim_section, checked_at, reviewer_id) VALUES (?,?,?,?,UTC_TIMESTAMP(),?)',
                  [$locId, $sUrl, $sPub, $sSection, $user['id']]);
            }
        }

        // Slug change on a published article → single-hop 301 redirect
        if ($newSlug !== $oldSlug && $loc['state'] === 'published') {
            q('INSERT INTO redirects (locale, old_path, new_path, http_status, created_by) VALUES (?,?,?,301,?)
               ON DUPLICATE KEY UPDATE new_path = VALUES(new_path)',
              [$locale, $locale . '/guides/' . $oldSlug, BASE_PATH . '/' . $locale . '/guides/' . $newSlug . '/', $user['id']]);
            audit((int)$user['id'], 'slug_redirect', 'article_localization', $locId, ['from' => $oldSlug, 'to' => $newSlug]);
        }

        audit((int)$user['id'], 'save', 'article_localization', $locId);
        flash('Saved.');
        redirect(BASE_PATH . '/admin/article-edit.php?id=' . $articleId);
    }
}

/* ---------- Render ---------- */
admin_header($article ? 'Edit: ' . ($loc['title'] ?? '') : 'New article');
flash_show();

if (!$article): ?>
    <h1>New article</h1>
    <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="create">
        <label>Working title <input type="text" name="title" required maxlength="255"></label>
        <button class="btn" type="submit">Create draft</button>
    </form>
<?php else:
    $sourceLines = implode("\n", array_map(
        fn ($s) => trim(($s['source_url'] ?? '') . ' | ' . ($s['publisher'] ?? '') . ' | ' . ($s['claim_section'] ?? ''), ' |'),
        $sources
    ));
    ?>
    <h1>Edit article <span class="state state-<?= e($loc['state']) ?>"><?= e($loc['state']) ?></span></h1>
    <?php if ($loc['state'] === 'published'): ?>
        <p><a href="<?= url($locale, 'guides/' . $loc['slug']) ?>" target="_blank" rel="noopener">View live ↗</a></p>
    <?php endif; ?>

    <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save">

        <fieldset>
            <legend>Content</legend>
            <label>Title <input type="text" name="title" value="<?= e($loc['title']) ?>" required maxlength="255"></label>
            <label>Slug <input type="text" name="slug" value="<?= e($loc['slug']) ?>" required pattern="[a-z0-9-]+"> <small>Changing the slug of a published article creates a 301 redirect.</small></label>
            <label>Excerpt (opening answer) <textarea name="excerpt" rows="3"><?= e($loc['excerpt'] ?? '') ?></textarea></label>
            <label>Body (HTML — allowed: h2-h4, p, lists, a, blockquote, table, figure/img)
                <textarea name="body" rows="18"><?= e($loc['body'] ?? '') ?></textarea></label>
        </fieldset>

        <fieldset>
            <legend>SEO</legend>
            <label>SEO title <input type="text" name="seo_title" value="<?= e($loc['seo_title'] ?? '') ?>" maxlength="255"></label>
            <label>Meta description <textarea name="meta_description" rows="2" maxlength="320"><?= e($loc['meta_description'] ?? '') ?></textarea></label>
            <label>Content type
                <select name="content_type">
                    <?php foreach (['guide','pillar','itinerary','practical','policy'] as $ct): ?>
                        <option value="<?= $ct ?>" <?= $loc['content_type'] === $ct ? 'selected' : '' ?>><?= $ct ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </fieldset>

        <fieldset>
            <legend>Classification</legend>
            <label>Author
                <select name="author_id">
                    <?php foreach ($allAuthors as $au): ?>
                        <option value="<?= (int)$au['id'] ?>" <?= (int)$article['primary_author_id'] === (int)$au['id'] ? 'selected' : '' ?>><?= e($au['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <div class="checkbox-row"><strong>Destinations:</strong>
                <?php foreach ($allDestinations as $d): ?>
                    <label><input type="checkbox" name="destinations[]" value="<?= (int)$d['id'] ?>" <?= in_array($d['id'], $selectedDests) ? 'checked' : '' ?>> <?= e($d['title']) ?></label>
                <?php endforeach; ?>
            </div>
            <div class="checkbox-row"><strong>Topics:</strong>
                <?php foreach ($allTopics as $t): ?>
                    <label><input type="checkbox" name="topics[]" value="<?= (int)$t['id'] ?>" <?= in_array($t['id'], $selectedTopics) ? 'checked' : '' ?>> <?= e($t['title']) ?></label>
                <?php endforeach; ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Sources — one per line: URL | publisher | section</legend>
            <textarea name="sources" rows="5"><?= e($sourceLines) ?></textarea>
        </fieldset>

        <label>Review notes (saved to revision history) <input type="text" name="review_notes" maxlength="500"></label>

        <button class="btn" type="submit">Save</button>
    </form>

    <form method="post" class="workflow-actions">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <h2>Workflow</h2>
        <?php
        $buttons = [];
        if ($loc['state'] === 'draft') { $buttons['submit_review'] = 'Submit for review'; }
        if ($loc['state'] === 'in_review') {
            if (in_array($user['role'], ['admin','editor','reviewer'], true)) { $buttons['fact_check'] = 'Mark fact-checked'; $buttons['reject'] = 'Reject to draft'; }
            if (in_array($user['role'], ['admin','editor'], true)) { $buttons['approve'] = 'Approve'; }
        }
        if ($loc['state'] === 'fact_review') {
            if (in_array($user['role'], ['admin','editor'], true)) { $buttons['approve'] = 'Approve'; $buttons['reject'] = 'Reject to draft'; }
        }
        if ($loc['state'] === 'approved' && can_publish($user)) { $buttons['publish'] = 'Publish now'; $buttons['reject'] = 'Reject to draft'; }
        if ($loc['state'] === 'published' && can_publish($user)) { $buttons['publish'] = 'Republish (update)'; $buttons['unpublish'] = 'Archive (unpublish)'; }
        if (!$buttons) { echo '<p>No actions available for your role at this state.</p>'; }
        foreach ($buttons as $act => $label): ?>
            <button class="btn <?= $act === 'unpublish' || $act === 'reject' ? 'btn-danger' : '' ?>" name="action" value="<?= $act ?>" type="submit"><?= e($label) ?></button>
        <?php endforeach; ?>
    </form>

    <details>
        <summary>Revision history</summary>
        <?php $revs = q('SELECT r.*, u.name AS actor FROM revisions r LEFT JOIN users u ON u.id = r.actor_id WHERE localization_id = ? ORDER BY r.id DESC LIMIT 20', [(int)$loc['id']])->fetchAll(); ?>
        <ul>
            <?php foreach ($revs as $r): ?>
                <li><?= e($r['created_at']) ?> — <?= e($r['actor'] ?? 'system') ?> <?= $r['review_notes'] ? '· ' . e($r['review_notes']) : '' ?></li>
            <?php endforeach; ?>
        </ul>
    </details>
<?php endif; ?>

<?php admin_footer(); ?>
