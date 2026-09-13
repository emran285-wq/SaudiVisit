<?php
require __DIR__ . '/data/site-data.php';
$slug = (string)($_GET['slug'] ?? 'riyadh');
if (!isset($destinations[$slug])) {
    http_response_code(404);
    $slug = 'riyadh';
}
$destination = $destinations[$slug];
$pageTitle = $destination['name'] . ' Travel Guide | SaudiVisit.net';
$metaDescription = $destination['summary'];
$destinationAttractions = array_values(array_filter($attractions, static fn($a) => $a['destination'] === $slug));
require __DIR__ . '/includes/header.php';
?>
<section class="destination-hero">
    <div class="container destination-hero-grid">
        <div>
            <span class="eyebrow eyebrow-light">Destination guide</span>
            <h1><?= e($destination['name']) ?></h1>
            <p><?= e($destination['summary']) ?></p>
            <div class="hero-facts"><div><span>Best time</span><strong><?= e($destination['best_time']) ?></strong></div><div><span>Suggested stay</span><strong><?= e($destination['days']) ?></strong></div></div>
        </div>
        <img src="<?= e($destination['image']) ?>" alt="Stylized travel illustration for <?= e($destination['name']) ?>">
    </div>
</section>
<section class="section">
    <div class="container content-layout">
        <article class="prose">
            <span class="eyebrow">Why visit</span>
            <h2>What makes <?= e($destination['name']) ?> worth the trip?</h2>
            <p><?= e($destination['summary']) ?></p>
            <h2>Top experiences</h2>
            <div class="numbered-grid">
                <?php foreach ($destination['highlights'] as $index => $highlight): ?><div><span><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span><strong><?= e($highlight) ?></strong></div><?php endforeach; ?>
            </div>
            <?php if ($destinationAttractions): ?>
                <h2>Featured attractions</h2>
                <div class="simple-table">
                    <?php foreach ($destinationAttractions as $place): ?><div><div><strong><?= e($place['name']) ?></strong><span><?= e($place['category']) ?></span></div><div><span><?= e($place['price']) ?></span><strong>★ <?= e($place['rating']) ?></strong></div></div><?php endforeach; ?>
                </div>
            <?php endif; ?>
            <h2>Suggested first-day plan</h2>
            <ol class="timeline">
                <li><strong>Morning:</strong> Start with a signature heritage or cultural attraction.</li>
                <li><strong>Afternoon:</strong> Explore a museum, district, waterfront or landscape experience.</li>
                <li><strong>Evening:</strong> Slow down with a local meal and sunset-friendly stop.</li>
            </ol>
        </article>
        <aside class="sidebar-card">
            <h3>Travel tips</h3>
            <ul><?php foreach ($destination['tips'] as $tip): ?><li><?= e($tip) ?></li><?php endforeach; ?></ul>
            <a class="button full-button" href="planner.php?destination=<?= e($slug) ?>">Plan <?= e($destination['name']) ?> trip</a>
            <p class="fine-print">Before publishing live, connect official travel-rule, weather, ticketing and map data sources.</p>
        </aside>
    </div>
</section>
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'TouristDestination',
    'name' => $destination['name'],
    'description' => $destination['summary'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>
<?php require __DIR__ . '/includes/footer.php'; ?>
