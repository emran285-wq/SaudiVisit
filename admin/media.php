<?php
/** Media library: validated upload + alt/caption/credit/rights records (PRD P08). */

declare(strict_types=1);

require_once __DIR__ . '/_bootstrap.php';
require_role($user, 'admin', 'editor', 'writer');

$uploadDir = __DIR__ . '/../assets/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/avif' => 'avif'];
$maxBytes = 5 * 1024 * 1024;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $err = '';
    if (empty($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $err = 'Upload failed.';
    } elseif ($_FILES['image']['size'] > $maxBytes) {
        $err = 'File too large (max 5MB).';
    } else {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['image']['tmp_name']);
        if (!isset($allowed[$mime])) {
            $err = 'Only JPEG, PNG, WebP and AVIF images are allowed.';
        } else {
            $name = slugify(pathinfo($_FILES['image']['name'], PATHINFO_FILENAME)) . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
            $dest = $uploadDir . $name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                [$w, $h] = getimagesize($dest) ?: [null, null];
                q('INSERT INTO media (file_path, mime, width, height, alt_text, caption, credit, rights) VALUES (?,?,?,?,?,?,?,?)', [
                    $name, $mime, $w, $h,
                    trim((string)$_POST['alt_text']),
                    trim((string)$_POST['caption']),
                    trim((string)$_POST['credit']),
                    in_array($_POST['rights'] ?? '', ['own','licensed','cc-by','permission'], true) ? $_POST['rights'] : null,
                ]);
                audit((int)$user['id'], 'upload', 'media', (int)db()->lastInsertId());
                flash('Uploaded.');
            } else {
                $err = 'Could not store file.';
            }
        }
    }
    flash($err ?: 'Uploaded.');
    redirect(BASE_PATH . '/admin/media.php');
}

$items = q('SELECT * FROM media ORDER BY id DESC LIMIT 100')->fetchAll();

admin_header('Media');
flash_show();
?>
<h1>Media library</h1>
<form method="post" enctype="multipart/form-data" class="admin-form">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <label>Image (JPEG/PNG/WebP/AVIF, max 5MB) <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/avif" required></label>
    <label>Alt text (required for content images) <input type="text" name="alt_text" maxlength="255"></label>
    <label>Caption <input type="text" name="caption" maxlength="500"></label>
    <label>Credit <input type="text" name="credit" maxlength="190"></label>
    <label>Rights
        <select name="rights">
            <option value="">—</option>
            <option value="own">Own work</option>
            <option value="licensed">Licensed</option>
            <option value="cc-by">CC-BY</option>
            <option value="permission">Used with permission</option>
        </select>
    </label>
    <button class="btn" type="submit">Upload</button>
</form>

<div class="media-grid">
    <?php foreach ($items as $m): ?>
        <figure>
            <img src="<?= BASE_PATH ?>/assets/uploads/<?= e($m['file_path']) ?>" alt="<?= e($m['alt_text'] ?? '') ?>" loading="lazy" width="200">
            <figcaption>
                <?= e($m['file_path']) ?><br>
                <small><?= e($m['rights'] ?? 'no rights recorded') ?> · <?= e($m['credit'] ?? '') ?></small>
            </figcaption>
        </figure>
    <?php endforeach; ?>
</div>
<?php admin_footer(); ?>
