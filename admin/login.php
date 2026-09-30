<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();
    $user = attempt_login((string)($_POST['email'] ?? ''), (string)($_POST['password'] ?? ''));
    if ($user) {
        redirect(BASE_PATH . '/admin/index.php');
    }
    $error = 'Invalid credentials, or too many attempts — wait 10 minutes.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" sizes="16x16 32x32 48x48" href="<?= BASE_PATH ?>/assets/favicon.ico?v=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_PATH ?>/assets/favicon-16x16.png?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_PATH ?>/assets/favicon-32x32.png?v=1">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_PATH ?>/assets/apple-touch-icon.png?v=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Log in — <?= e(SITE_NAME) ?> Admin</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
</head>
<body>
<main class="login-box">
    <h1><?= e(SITE_NAME) ?> CMS</h1>
    <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label>Email <input type="email" name="email" required autocomplete="username"></label>
        <label>Password <input type="password" name="password" required autocomplete="current-password"></label>
        <button class="btn" type="submit">Log in</button>
    </form>
</main>
</body>
</html>
