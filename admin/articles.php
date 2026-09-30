<?php
/** Article list with states. */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';

$articles = q(
    "SELECT al.*, a.owner_id, a.primary_author_id, au.name AS author_name
     FROM article_localizations al
     JOIN articles a ON a.id = al.article_id
     LEFT JOIN authors au ON au.id = a.primary_author_id
     ORDER BY al.updated_at DESC"
)->fetchAll();

admin_header('Articles');
flash_show();
?>
<h1>Articles</h1>
<p><a class="btn" href="<?= BASE_PATH ?>/admin/article-edit.php">+ New article</a></p>
<table>
    <thead><tr><th>Title</th><th>State</th><th>Author</th><th>Published</th><th>Review due</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($articles as $a): ?>
        <tr>
            <td><?= e($a['title']) ?><br><small>/<?= e($a['locale']) ?>/guides/<?= e($a['slug']) ?>/</small></td>
            <td><span class="state state-<?= e($a['state']) ?>"><?= e($a['state']) ?></span></td>
            <td><?= e($a['author_name'] ?? '—') ?></td>
            <td><?= e(fmt_date($a['published_at']) ?: '—') ?></td>
            <td><?= e(fmt_date($a['review_due_at']) ?: '—') ?></td>
            <td>
                <a href="<?= BASE_PATH ?>/admin/article-edit.php?id=<?= (int)$a['article_id'] ?>">Edit</a>
                <?php if ($a['state'] === 'published'): ?>
                    · <a href="<?= url($a['locale'], 'guides/' . $a['slug']) ?>" target="_blank" rel="noopener">View</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php admin_footer(); ?>
