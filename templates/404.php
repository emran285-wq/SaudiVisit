<?php
/** 404 — real status code, never soft-200. */
$title = $title ?? 'Page not found — ' . SITE_NAME;
$metaDescription = 'The page you requested does not exist.';
$canonicalPath = $_SERVER['REQUEST_URI'] ?? '/';
$noindex = true;
?>
<div class="container page-narrow">
    <h1>Page not found</h1>
    <p>The page you requested doesn't exist or was moved. Try <a href="<?= url($locale ?? DEFAULT_LOCALE, 'search') ?>">search</a> or browse <a href="<?= url($locale ?? DEFAULT_LOCALE, 'destinations') ?>">destinations</a>.</p>
</div>
