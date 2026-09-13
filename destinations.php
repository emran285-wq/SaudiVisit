<?php
require __DIR__ . '/data/site-data.php';
$pageTitle = 'Saudi Arabia Destinations | SaudiVisit.net';
$metaDescription = 'Explore Saudi Arabia destination guides for Riyadh, Jeddah, AlUla, Makkah, Madinah, Abha and more.';
$q = trim((string)($_GET['q'] ?? ''));
$filtered = $destinations;
if ($q !== '') {
    $filtered = array_filter($destinations, static function ($item) use ($q) {
        $haystack = strtolower($item['name'] . ' ' . $item['tagline'] . ' ' . $item['summary'] . ' ' . implode(' ', $item['highlights']));
        return str_contains($haystack, strtolower($q));
    });
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact-hero">
    <div class="container narrow">
        <span class="eyebrow eyebrow-light">Destinations</span>
        <h1>Find your corner of Saudi Arabia</h1>
        <p>Compare city culture, coast, desert heritage, religious travel and mountain escapes.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <form class="filter-bar" method="get" action="destinations.php">
            <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search destinations or interests">
            <button class="button button-small" type="submit">Filter</button>
            <?php if ($q !== ''): ?><a class="text-link" href="destinations.php">Clear</a><?php endif; ?>
        </form>
        <?php if (!$filtered): ?>
            <div class="empty-state"><h2>No destinations matched “<?= e($q) ?>”.</h2><p>Try a broader term such as desert, heritage, coast or city.</p></div>
        <?php else: ?>
            <div class="card-grid card-grid-3">
                <?php foreach ($filtered as $slug => $destination): ?>
                    <article class="destination-card">
                        <a href="destination.php?slug=<?= e($slug) ?>" class="card-image-link"><img src="<?= e($destination['image']) ?>" alt="Stylized travel illustration for <?= e($destination['name']) ?>"></a>
                        <div class="card-body">
                            <div class="card-kicker"><span><?= e($destination['best_time']) ?></span><span><?= e($destination['days']) ?></span></div>
                            <h2><a href="destination.php?slug=<?= e($slug) ?>"><?= e($destination['name']) ?></a></h2>
                            <p><?= e($destination['tagline']) ?></p>
                            <ul class="mini-list"><?php foreach (array_slice($destination['highlights'], 0, 3) as $highlight): ?><li><?= e($highlight) ?></li><?php endforeach; ?></ul>
                            <a class="text-link" href="destination.php?slug=<?= e($slug) ?>">Open destination guide →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
