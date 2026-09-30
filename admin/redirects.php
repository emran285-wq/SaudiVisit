<?php
/** Redirect manager (PRD: single-hop 301s; prevent loops). */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';
require_role($user, 'admin', 'editor');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $action = (string)($_POST['action'] ?? '');
    if ($action === 'add') {
        $old = trim((string)$_POST['old_path'], '/ ');
        $new = trim((string)$_POST['new_path']);
        $status = in_array((int)$_POST['http_status'], [301, 302, 410], true) ? (int)$_POST['http_status'] : 301;
        // Loop prevention: new target must not equal old path
        if ($old !== '' && rtrim($new, '/') !== rtrim(BASE_PATH . '/' . $old, '/')) {
            q('INSERT INTO redirects (locale, old_path, new_path, http_status, created_by) VALUES (?,?,?,?,?)
               ON DUPLICATE KEY UPDATE new_path = VALUES(new_path), http_status = VALUES(http_status)',
              [DEFAULT_LOCALE, $old, $new, $status, $user['id']]);
            audit((int)$user['id'], 'redirect_add', 'redirect', null, ['old' => $old, 'new' => $new]);
            flash('Redirect saved.');
        } else {
            flash('Invalid redirect (empty or points to itself).');
        }
    }
    if ($action === 'delete') {
        q('DELETE FROM redirects WHERE id = ?', [(int)$_POST['id']]);
        flash('Redirect deleted.');
    }
    redirect(BASE_PATH . '/admin/redirects.php');
}

$redirects = q('SELECT r.*, u.name AS creator FROM redirects r LEFT JOIN users u ON u.id = r.created_by ORDER BY r.id DESC')->fetchAll();

admin_header('Redirects');
flash_show();
?>
<h1>Redirects</h1>
<form method="post" class="admin-form inline-form">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="add">
    <label>Old path <input type="text" name="old_path" placeholder="en/guides/old-slug" required></label>
    <label>New URL <input type="text" name="new_path" placeholder="/saudivisit/en/guides/new-slug/" required></label>
    <label>Status
        <select name="http_status"><option>301</option><option>302</option><option>410</option></select>
    </label>
    <button class="btn" type="submit">Add</button>
</form>

<table>
    <thead><tr><th>Old path</th><th>New URL</th><th>Status</th><th>By</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($redirects as $r): ?>
        <tr>
            <td>/<?= e($r['old_path']) ?></td>
            <td><?= e($r['new_path']) ?></td>
            <td><?= (int)$r['http_status'] ?></td>
            <td><?= e($r['creator'] ?? '—') ?></td>
            <td>
                <form method="post" onsubmit="return confirm('Delete this redirect?')">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php admin_footer(); ?>
