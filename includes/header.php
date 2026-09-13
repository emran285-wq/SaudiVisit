<?php
// Include configuration and utilities
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

// Set default page metadata if not already set
$pageTitle = $pageTitle ?? DEFAULT_TITLE;
$metaDescription = $metaDescription ?? DEFAULT_DESCRIPTION;
$currentPage = basename($_SERVER['PHP_SELF']);
$canonical = $canonical ?? '';

// Prepare Open Graph and Twitter meta if not set
$ogData = $ogData ?? [];
$twitterData = $twitterData ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="theme-color" content="#0b3d2e">
    <?php if ($canonical): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif; ?>
    
    <!-- Open Graph / Social Media -->
    <?= ogMeta($ogData) ?>
    
    <!-- Twitter Card -->
    <?= twitterMeta($twitterData) ?>
    
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    
    <!-- WebSite Schema -->
    <script type="application/ld+json">
    <?= websiteSchema() ?>
    </script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header" id="top">
    <div class="container nav-wrap">
        <a class="brand" href="<?= BASE_PATH ?>/index.php" aria-label="SaudiVisit.net home">
            <span class="brand-mark">SV</span>
            <span class="brand-text"><strong>SaudiVisit</strong><small>.net</small></span>
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu</button>
        <nav class="site-nav" id="site-nav" aria-label="Primary navigation">
            <a class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" href="<?= BASE_PATH ?>/index.php">Home</a>
            <a class="<?= in_array($currentPage, ['destinations.php', 'destination.php'], true) ? 'active' : '' ?>" href="<?= BASE_PATH ?>/destinations.php">Destinations</a>
            <a class="<?= in_array($currentPage, ['articles.php', 'article.php'], true) ? 'active' : '' ?>" href="<?= BASE_PATH ?>/articles.php">Travel Guides</a>
            <a class="<?= $currentPage === 'attractions.php' ? 'active' : '' ?>" href="<?= BASE_PATH ?>/attractions.php">Attractions</a>
            <a class="button button-small" href="<?= BASE_PATH ?>/planner.php">Plan a Trip</a>
        </nav>
    </div>
</header>
<main id="main">
