<?php
require __DIR__ . '/data/site-data.php';
require_once __DIR__ . '/includes/config.php';

// Set content type to XML
header('Content-Type: application/xml; charset=utf-8');

$baseUrl = SITE_URL;

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc><?= $baseUrl ?>/index.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    
    <!-- Main pages -->
    <url>
        <loc><?= $baseUrl ?>/destinations.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/articles.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/attractions.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/planner.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    
    <!-- Destinations -->
    <?php foreach ($destinations as $slug => $destination): ?>
    <url>
        <loc><?= $baseUrl ?>/destination.php?slug=<?= urlencode($slug) ?></loc>
        <lastmod><?= $destination['updated_date'] ?? '2026-09-13' ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    
    <!-- Articles -->
    <?php foreach ($articles as $article): ?>
    <url>
        <loc><?= $baseUrl ?>/article.php?slug=<?= urlencode($article['slug']) ?></loc>
        <lastmod><?= $article['updated_date'] ?? '2026-09-13' ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
    
    <!-- Informational pages -->
    <url>
        <loc><?= $baseUrl ?>/about.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/contact.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc><?= $baseUrl ?>/privacy.php</loc>
        <lastmod>2026-09-13</lastmod>
        <changefreq>yearly</changefreq>
        <priority>0.4</priority>
    </url>
</urlset>
