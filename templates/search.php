<?php
/** Search — crawlable but noindex per PRD. */
$title = 'Search — ' . SITE_NAME;
$metaDescription = 'Search SaudiVisit guides.';
$canonicalPath = url($locale, 'search');
$noindex = true;

$perPage = 10;
$results = [];
$total = 0;
$totalPages = 0;
if ($q !== '') {
    $total = count_search_articles($locale, $q);
    $totalPages = max(1, (int)ceil($total / $perPage));
    $results = search_articles($locale, $q, $page, $perPage);
}
?>
<div class="container page-narrow">
    <h1>Search</h1>
    <form class="search-form" method="get" action="<?= url($locale, 'search') ?>" role="search">
        <label for="search-q">Search guides</label>
        <div class="search-row">
            <input type="search" id="search-q" name="q" value="<?= e($q) ?>" required>
            <button class="btn" type="submit">Search</button>
        </div>
    </form>

    <?php if ($q !== ''): ?>
        <p><?= $total ?> result<?= $total === 1 ? '' : 's' ?> for “<?= e($q) ?>”</p>
        <?php if (!$results): ?>
            <p>No guides matched. Try a city name, or browse <a href="<?= url($locale, 'destinations') ?>">destinations</a>.</p>
        <?php else: ?>
            <ul class="search-results">
                <?php foreach ($results as $r): ?>
                    <li>
                        <h2><a href="<?= url($locale, 'guides/' . $r['slug']) ?>"><?= e($r['title']) ?></a></h2>
                        <p><?= e($r['excerpt'] ?? '') ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($totalPages > 1): ?>
                <nav class="pagination" aria-label="Pagination">
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <?php if ($p === $page): ?>
                            <span aria-current="page"><?= $p ?></span>
                        <?php else: ?>
                            <a href="<?= url($locale, 'search') ?>?q=<?= urlencode($q) ?>&page=<?= $p ?>"><?= $p ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
