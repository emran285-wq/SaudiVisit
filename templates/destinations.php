<?php
/** Destination directory. */
$title = 'Destinations — ' . SITE_NAME;
$metaDescription = 'Saudi Arabia destination guides: Riyadh, Jeddah and AlUla.';
$canonicalPath = url($locale, 'destinations');
$q = $q ?? '';
$noindex = $q !== '';
$destinations = array_values(array_filter($destinations, static function (array $destination) use ($q): bool {
    return $q === '' || stripos($destination['title'] . ' ' . ($destination['intro'] ?? ''), $q) !== false;
}));
?>
<div class="container page-narrow">
    <h1>Destinations</h1>
    <p class="lede">City-by-city practical guides. More destinations are added as reviewed guides are published.</p>
    <form class="search-form" method="get" action="<?= url($locale, 'destinations') ?>" role="search">
        <label for="destination-q">Search destinations</label>
        <div class="search-row">
            <input type="search" id="destination-q" name="q" value="<?= e($q) ?>">
            <button class="btn" type="submit">Search</button>
        </div>
    </form>
    <div class="card-grid">
        <?php foreach ($destinations as $d): ?>
            <article class="card">
                <h2><a href="<?= url($locale, 'destinations/' . $d['slug']) ?>"><?= e($d['title']) ?></a></h2>
                <p><?= e($d['intro'] ?? '') ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</div>
