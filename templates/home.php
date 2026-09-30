<?php
/** Homepage — layout order per PRD 5: hero → planning shortcuts → destinations → featured → first trip → latest. */
$title = SITE_NAME . ' — Your practical guide to Saudi Arabia';
$metaDescription = 'Plan a Saudi Arabia trip with confidence: city guides for Riyadh, Jeddah and AlUla, realistic itineraries, transport and budget advice.';
$canonicalPath = url($locale);
$latest = get_latest_articles($locale, 6);
?>

<section class="hero">
    <div class="container">
        <h1>Your practical guide to Saudi Arabia</h1>
        <p class="lede">Destination guides, realistic itineraries and source-checked logistics for Riyadh, Jeddah and AlUla.</p>
        <a class="btn" href="<?= url($locale, 'destinations') ?>">Explore destinations</a>
    </div>
</section>

<section class="container planning-shortcuts" aria-label="Planning shortcuts">
    <a class="shortcut-card" href="<?= url($locale, 'topics/travel-planning') ?>"><h2>First trip</h2><p>Start planning step by step</p></a>
    <a class="shortcut-card" href="<?= url($locale, 'topics/itineraries') ?>"><h2>Itineraries</h2><p>Day-by-day routes</p></a>
    <a class="shortcut-card" href="<?= url($locale, 'topics/transport') ?>"><h2>Transport</h2><p>Airports &amp; getting around</p></a>
    <a class="shortcut-card" href="<?= url($locale, 'topics/travel-planning') ?>"><h2>Budget</h2><p>Dated cost planning</p></a>
</section>

<section class="container" aria-labelledby="destinations-heading">
    <h2 id="destinations-heading">Destinations</h2>
    <div class="card-grid">
        <?php foreach ($destinations as $d): ?>
            <article class="card">
                <h3><a href="<?= url($locale, 'destinations/' . $d['slug']) ?>"><?= e($d['title']) ?></a></h3>
                <p><?= e($d['intro'] ?? '') ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="container" aria-labelledby="first-trip-heading">
    <h2 id="first-trip-heading">Plan your first trip</h2>
    <ol class="reading-sequence">
        <li><a href="<?= url($locale, 'guides/saudi-arabia-travel-guide-first-time-visitors') ?>">Saudi Arabia Travel Guide for First-Time Visitors</a></li>
        <li><a href="<?= url($locale, 'guides/riyadh-travel-guide-first-time-visitors') ?>">Riyadh Travel Guide</a></li>
        <li><a href="<?= url($locale, 'guides/riyadh-three-day-itinerary') ?>">A 3-Day Riyadh Itinerary</a></li>
    </ol>
</section>

<section class="container" aria-labelledby="latest-heading">
    <h2 id="latest-heading">Latest updated guides</h2>
    <div class="card-grid">
        <?php foreach ($latest as $a): ?>
            <article class="card">
                <h3><a href="<?= url($locale, 'guides/' . $a['slug']) ?>"><?= e($a['title']) ?></a></h3>
                <p><?= e($a['excerpt'] ?? '') ?></p>
                <p class="fine-print">Updated <?= e(fmt_date($a['substantive_updated_at'] ?? $a['published_at'])) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
