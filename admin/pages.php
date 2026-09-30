<?php
/** Trust page editor (About, Editorial Policy, etc.). */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';
require_role($user, 'admin', 'editor');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    q('UPDATE pages SET title = ?, body = ?, is_indexable = ? WHERE id = ?', [
        trim((string)$_POST['title']),
        sanitize_html((string)$_POST['body']),
        isset($_POST['is_indexable']) ? 1 : 0,
        (int)$_POST['id'],
    ]);
    audit((int)$user['id'], 'save', 'page', (int)$_POST['id']);
    flash('Page saved.');
    redirect(BASE_PATH . '/admin/pages.php?edit=' . (int)$_POST['id']);
}

$editId = (int)($_GET['edit'] ?? 0);
$pages = q('SELECT * FROM pages WHERE locale = ? ORDER BY slug', [DEFAULT_LOCALE])->fetchAll();
$editing = $editId ? q('SELECT * FROM pages WHERE id = ?', [$editId])->fetch() : null;

admin_header('Pages');
flash_show();
?>
<h1>Trust pages</h1>
<ul>
    <?php foreach ($pages as $p): ?>
        <li><a href="?edit=<?= (int)$p['id'] ?>"><?= e($p['title']) ?></a> <small>(/<?= e($p['slug']) ?>/)</small></li>
    <?php endforeach; ?>
</ul>

<?php if ($editing): ?>
    <h2>Edit: <?= e($editing['title']) ?></h2>
    <form method="post" class="admin-form">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="id" value="<?= (int)$editing['id'] ?>">
        <label>Title <input type="text" name="title" value="<?= e($editing['title']) ?>" required></label>
        <label>Body (HTML) <textarea name="body" rows="12"><?= e($editing['body'] ?? '') ?></textarea></label>
        <label><input type="checkbox" name="is_indexable" <?= $editing['is_indexable'] ? 'checked' : '' ?>> Indexable</label>
        <button class="btn" type="submit">Save</button>
    </form>
<?php endif; ?>
<?php admin_footer(); ?>
