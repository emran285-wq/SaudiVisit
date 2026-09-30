<?php
/** Dynamic XML sitemap — only canonical, published, indexable URLs with truthful lastmod. */

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

header('Content-Type: application/xml; charset=utf-8');

$urls = [];
$locale = DEFAULT_LOCALE;
$base = SITE_URL;

$urls[] = ['loc' => $base . url($locale), 'lastmod' => null];
$urls[] = ['loc' => $base . url($locale, 'guides'), 'lastmod' => null];

foreach (get_destinations($locale) as $d) {
    if ($d['is_indexable'] && count_articles_by_destination((int)$d['id'], $locale) > 0) {
        $urls[] = ['loc' => $base . url($locale, 'destinations/' . $d['slug']), 'lastmod' => null];
    }
}
$urls[] = ['loc' => $base . url($locale, 'destinations'), 'lastmod' => null];

foreach (q('SELECT * FROM topics WHERE locale = ? AND is_indexable = 1', [$locale])->fetchAll() as $t) {
    $urls[] = ['loc' => $base . url($locale, 'topics/' . $t['slug']), 'lastmod' => null];
}

foreach (q("SELECT slug, COALESCE(substantive_updated_at, published_at) AS lm FROM article_localizations WHERE locale = ? AND state = 'published'", [$locale])->fetchAll() as $a) {
    $urls[] = ['loc' => $base . url($locale, 'guides/' . $a['slug']), 'lastmod' => $a['lm']];
}

foreach (q('SELECT slug FROM pages WHERE locale = ? AND is_indexable = 1', [$locale])->fetchAll() as $p) {
    $urls[] = ['loc' => $base . url($locale, 'pages/' . $p['slug']), 'lastmod' => null];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
    <url>
        <loc><?= e($u['loc']) ?></loc>
        <?php if (!empty($u['lastmod'])): ?>
        <lastmod><?= e(date('Y-m-d', strtotime($u['lastmod']))) ?></lastmod>
        <?php endif; ?>
    </url>
<?php endforeach; ?>
</urlset>
