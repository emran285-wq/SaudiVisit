<?php
/** Destination hub: unique intro → quick facts → essential guides → paginated archive. */
$dest = get_destination($locale, $slug);
if (!$dest || count_articles_by_destination((int)$dest['id'], $locale) === 0) {
    // Never expose empty hubs publicly (PRD P02)
    http_response_code(404);
    $dest = null;
    $title = 'Destination not found';
    echo '<div class="container page-narrow"><h1>Destination not found</h1><p>This destination has no published guides yet. <a href="' . url($locale, 'destinations') . '">Browse destinations</a>.</p></div>';
    return;
}

$perPage = 10;
$total = count_articles_by_destination((int)$dest['id'], $locale);
$totalPages = max(1, (int)ceil($total / $perPage));
if ($page > $totalPages) {
    http_response_code(404);
    echo '<div class="container page-narrow"><h1>Page not found</h1></div>';
    return;
}
$articles = get_articles_by_destination((int)$dest['id'], $locale, $page, $perPage);
$quickFacts = $dest['quick_facts'] ? json_decode($dest['quick_facts'], true) : [];

$title = $dest['title'] . ' Travel Guide — ' . SITE_NAME;
$metaDescription = mb_strimwidth((string)($dest['intro'] ?? ''), 0, 155, '…');
$canonicalPath = url($locale, 'destinations/' . $dest['slug']) . ($page > 1 ? '?page=' . $page : '');
$headExtra = jsonld_breadcrumbs([
    ['name' => 'Home', 'path' => url($locale)],
    ['name' => 'Destinations', 'path' => url($locale, 'destinations')],
    ['name' => $dest['title'], 'path' => url($locale, 'destinations/' . $dest['slug'])],
]);
?>
<div class="container page-narrow">
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <a href="<?= url($locale) ?>">Home</a> / <a href="<?= url($locale, 'destinations') ?>">Destinations</a> / <span><?= e($dest['title']) ?></span>
    </nav>
    <h1><?= e($dest['title']) ?></h1>
    <p class="lede"><?= e($dest['intro'] ?? '') ?></p>

    <?php if ($quickFacts): ?>
        <aside class="quick-facts" aria-label="Quick facts">
            <h2>Quick facts</h2>
            <dl>
                <?php foreach ($quickFacts as $k => $v): ?>
                    <dt><?= e($k) ?></dt><dd><?= e($v) ?></dd>
                <?php endforeach; ?>
            </dl>
        </aside>
    <?php endif; ?>

    <h2>Essential <?= e($dest['title']) ?> guides</h2>
    <div class="card-grid">
        <?php foreach ($articles as $a): ?>
            <article class="card">
                <h3><a href="<?= url($locale, 'guides/' . $a['slug']) ?>"><?= e($a['title']) ?></a></h3>
                <p><?= e($a['excerpt'] ?? '') ?></p>
                <p class="fine-print">Updated <?= e(fmt_date($a['substantive_updated_at'] ?? $a['published_at'])) ?></p>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination" aria-label="Pagination">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <?php if ($p === $page): ?>
                    <span aria-current="page"><?= $p ?></span>
                <?php else: ?>
                    <a href="<?= url($locale, 'destinations/' . $dest['slug']) ?>?page=<?= $p ?>"><?= $p ?></a>
                <?php endif; ?>
            <?php endfor; ?>
        </nav>
    <?php endif; ?>
</div>
