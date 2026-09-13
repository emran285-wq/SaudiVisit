<?php
require __DIR__ . '/data/site-data.php';
$pageTitle = 'Saudi Arabia Attractions | SaudiVisit.net';
$metaDescription = 'Browse a starter database of Saudi Arabia attractions across Riyadh, Jeddah, AlUla and Abha.';
$destinationFilter = (string)($_GET['destination'] ?? '');
$filtered = $destinationFilter === '' ? $attractions : array_values(array_filter($attractions, static fn($a) => $a['destination'] === $destinationFilter));
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero compact-hero"><div class="container narrow"><span class="eyebrow eyebrow-light">Attraction database</span><h1>Saudi attractions at a glance</h1><p>A clean starter structure ready for a database, map API, live hours, ticketing and affiliate integrations.</p></div></section>
<section class="section">
    <div class="container">
        <form class="filter-bar" method="get">
            <label for="destination">Destination</label>
            <select id="destination" name="destination" onchange="this.form.submit()">
                <option value="">All destinations</option>
                <?php foreach ($destinations as $slug => $item): ?><option value="<?= e($slug) ?>" <?= $destinationFilter === $slug ? 'selected' : '' ?>><?= e($item['name']) ?></option><?php endforeach; ?>
            </select>
            <?php if ($destinationFilter !== ''): ?><a class="text-link" href="attractions.php">Clear</a><?php endif; ?>
        </form>
        <div class="attraction-grid">
            <?php foreach ($filtered as $place): $d = $destinations[$place['destination']]; ?>
                <article class="attraction-card">
                    <div class="attraction-top"><span class="pill pill-light"><?= e($place['category']) ?></span><strong>★ <?= e($place['rating']) ?></strong></div>
                    <h2><?= e($place['name']) ?></h2>
                    <a href="destination.php?slug=<?= e($place['destination']) ?>"><?= e($d['name']) ?></a>
                    <div class="attraction-details"><span>Entry</span><strong><?= e($place['price']) ?></strong></div>
                    <div class="map-placeholder"><span>Map integration placeholder</span><small>Connect Google Maps or Mapbox in production</small></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
