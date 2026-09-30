<?php
/** Shared layout. Expects: $view, $locale, $title, $metaDescription, $canonicalPath, $noindex, $headExtra */
$title = $title ?? SITE_NAME;
$metaDescription = $metaDescription ?? SITE_TAGLINE;
$canonicalPath = $canonicalPath ?? ($_SERVER['REQUEST_URI'] ?? url($locale));
$noindex = $noindex ?? false;
$headExtra = $headExtra ?? '';
$destinations = $view === '404' ? [] : get_destinations($locale);
?>
<!DOCTYPE html>
<html lang="<?= e($locale) ?>" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" sizes="16x16 32x32 48x48" href="<?= BASE_PATH ?>/assets/favicon.ico?v=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_PATH ?>/assets/favicon-16x16.png?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_PATH ?>/assets/favicon-32x32.png?v=1">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_PATH ?>/assets/apple-touch-icon.png?v=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <?= seo_meta($canonicalPath, $noindex) ?>
    <?= social_meta($title, $metaDescription, $canonicalPath) ?>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/style.css">
    <?= $headExtra ?>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>

<header class="masthead">
    <div class="container masthead-inner">
        <a class="wordmark" href="<?= url($locale) ?>"><?= e(SITE_NAME) ?></a>
        <button class="nav-toggle" aria-expanded="false" aria-controls="primary-nav">Menu</button>
        <nav id="primary-nav" aria-label="Primary">
            <ul>
                <li><a href="<?= url($locale, 'destinations') ?>">Destinations</a></li>
                <li><a href="<?= url($locale, 'guides') ?>">Guides</a></li>
                <li><a href="<?= url($locale, 'topics/travel-planning') ?>">Plan Your Trip</a></li>
                <li><a href="<?= url($locale, 'topics/itineraries') ?>">Itineraries</a></li>
                <li><a href="<?= url($locale, 'topics/food-culture') ?>">Food &amp; Culture</a></li>
                <li><a href="<?= url($locale, 'search') ?>">Search</a></li>
            </ul>
        </nav>
    </div>
</header>

<main id="main">
    <?php require $viewFile; ?>
</main>

<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <p><strong><?= e(SITE_NAME) ?></strong> — <?= e(SITE_TAGLINE) ?></p>
            <p class="fine-print">Independent travel publication. Not a government portal, tourism authority or visa service.</p>
        </div>
        <nav aria-label="Destinations">
            <h2 class="footer-heading">Destinations</h2>
            <ul>
                <?php foreach ($destinations as $d): ?>
                    <li><a href="<?= url($locale, 'destinations/' . $d['slug']) ?>"><?= e($d['title']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <nav aria-label="About this site">
            <h2 class="footer-heading">About</h2>
            <ul>
                <li><a href="<?= url($locale, 'pages/about') ?>">About</a></li>
                <li><a href="<?= url($locale, 'pages/editorial-policy') ?>">Editorial Policy</a></li>
                <li><a href="<?= url($locale, 'pages/corrections') ?>">Corrections</a></li>
                <li><a href="<?= url($locale, 'pages/disclosure') ?>">Disclosure</a></li>
            </ul>
        </nav>
        <nav aria-label="Legal">
            <h2 class="footer-heading">Legal</h2>
            <ul>
                <li><a href="<?= url($locale, 'pages/contact') ?>">Contact</a></li>
                <li><a href="<?= url($locale, 'pages/privacy') ?>">Privacy</a></li>
                <li><a href="<?= url($locale, 'pages/terms') ?>">Terms</a></li>
            </ul>
        </nav>
    </div>
    <p class="container fine-print">&copy; <?= date('Y') ?> <?= e(SITE_NAME) ?>. All rights reserved.</p>
</footer>

<script src="<?= BASE_PATH ?>/assets/js/main.js" defer></script>
</body>
</html>
