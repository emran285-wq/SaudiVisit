<?php
/** Admin shared bootstrap + chrome. Expects $pageTitle set by the including file. */

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/auth.php';

$user = require_login();

function admin_header(string $pageTitle): void
{
    global $user;
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
    <title><?= e($pageTitle) ?> — <?= e(SITE_NAME) ?> Admin</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/admin.css">
</head>
<body>
<header class="admin-bar">
    <strong><?= e(SITE_NAME) ?> CMS</strong>
    <nav>
        <a href="<?= BASE_PATH ?>/admin/index.php">Dashboard</a>
        <a href="<?= BASE_PATH ?>/admin/articles.php">Articles</a>
        <a href="<?= BASE_PATH ?>/admin/media.php">Media</a>
        <a href="<?= BASE_PATH ?>/admin/redirects.php">Redirects</a>
        <a href="<?= BASE_PATH ?>/admin/pages.php">Pages</a>
        <a href="<?= BASE_PATH ?>/admin/logout.php">Log out (<?= e($user['name']) ?>, <?= e($user['role']) ?>)</a>
    </nav>
</header>
<main class="admin-main">
    <?php
}

function admin_footer(): void
{
    echo '</main></body></html>';
}

function flash(string $msg): void
{
    auth_start();
    $_SESSION['flash'] = $msg;
}

function flash_show(): void
{
    auth_start();
    if (!empty($_SESSION['flash'])) {
        echo '<p class="flash">' . e($_SESSION['flash']) . '</p>';
        unset($_SESSION['flash']);
    }
}
