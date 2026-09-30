<?php
/** Dashboard: review-due list, missing sources, publication schedule (PRD P11). */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';

$reviewDue = q(
    "SELECT al.*, a.owner_id FROM article_localizations al JOIN articles a ON a.id = al.article_id
     WHERE al.state = 'published' AND al.review_due_at IS NOT NULL AND al.review_due_at < UTC_TIMESTAMP()
     ORDER BY al.review_due_at LIMIT 20"
)->fetchAll();

$pendingReview = q(
    "SELECT al.*, a.owner_id FROM article_localizations al JOIN articles a ON a.id = al.article_id
     WHERE al.state IN ('in_review','fact_review','approved','scheduled')
     ORDER BY al.updated_at DESC LIMIT 20"
)->fetchAll();

$missingSources = q(
    "SELECT al.id, al.title, al.slug FROM article_localizations al
     LEFT JOIN sources s ON s.localization_id = al.id
     WHERE al.state IN ('in_review','fact_review','approved','published')
       AND al.content_type IN ('policy','practical')
     GROUP BY al.id HAVING COUNT(s.id) = 0 LIMIT 20"
)->fetchAll();

admin_header('Dashboard');
flash_show();
?>
<h1>Dashboard</h1>

<section>
    <h2>Awaiting editorial action (<?= count($pendingReview) ?>)</h2>
    <?php if (!$pendingReview): ?><p>Nothing in the review queue.</p><?php else: ?>
    <table>
        <thead><tr><th>Title</th><th>State</th><th>Scheduled</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($pendingReview as $a): ?>
            <tr>
                <td><?= e($a['title']) ?></td>
                <td><span class="state state-<?= e($a['state']) ?>"><?= e($a['state']) ?></span></td>
                <td><?= e($a['scheduled_at'] ?? '—') ?></td>
                <td><a href="<?= BASE_PATH ?>/admin/article-edit.php?id=<?= (int)$a['article_id'] ?>">Open</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>

<section>
    <h2>Review overdue (<?= count($reviewDue) ?>)</h2>
    <?php if (!$reviewDue): ?><p>No published content is overdue for review.</p><?php else: ?>
    <table>
        <thead><tr><th>Title</th><th>Due</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($reviewDue as $a): ?>
            <tr>
                <td><?= e($a['title']) ?></td>
                <td><?= e(fmt_date($a['review_due_at'])) ?></td>
                <td><a href="<?= BASE_PATH ?>/admin/article-edit.php?id=<?= (int)$a['article_id'] ?>">Review</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</section>

<section>
    <h2>Time-sensitive articles missing sources (<?= count($missingSources) ?>)</h2>
    <?php if (!$missingSources): ?><p>All policy/practical content has sources.</p><?php else: ?>
    <ul>
        <?php foreach ($missingSources as $a): ?>
            <li><?= e($a['title']) ?> — needs at least one source before publication.</li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</section>

<p><a class="btn" href="<?= BASE_PATH ?>/admin/article-edit.php">+ New article</a></p>
<?php admin_footer(); ?>
