<?php
require __DIR__ . '/data/site-data.php';
$pageTitle = 'Saudi Arabia Travel Guide 2026 | Explore Riyadh, AlUla & More';
$metaDescription = 'Discover Saudi Arabia with destination guides, itineraries, attractions, travel tips and trip planning ideas across Riyadh, AlUla, Jeddah and beyond.';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="hero-orb hero-orb-one"></div>
    <div class="hero-orb hero-orb-two"></div>
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">Independent Saudi travel guide</span>
            <h1>Discover Saudi Arabia,<br><span>one unforgettable journey at a time.</span></h1>
            <p>Destination guides, practical trip planning, cultural insights and itinerary ideas for Riyadh, AlUla, Jeddah, the Red Sea and beyond.</p>
            <div class="hero-actions">
                <a class="button" href="destinations.php">Explore destinations</a>
                <a class="text-link" href="planner.php">Build an itinerary →</a>
            </div>
            <div class="hero-stats" aria-label="Website highlights">
                <div><strong><?= count($destinations) ?>+</strong><span>Destinations</span></div>
                <div><strong><?= count($articles) ?>+</strong><span>Starter guides</span></div>
                <div><strong><?= count($attractions) ?>+</strong><span>Attractions</span></div>
            </div>
        </div>
        <div class="hero-card-wrap">
            <article class="feature-card">
                <img src="assets/images/alula.svg" alt="Stylized desert landscape representing AlUla">
                <div class="feature-card-body">
                    <span class="pill">Featured journey</span>
                    <h2>AlUla: ancient history under desert skies</h2>
                    <p>Build a 3-day route around Hegra, Old Town, Elephant Rock and a desert evening.</p>
                    <a href="destination.php?slug=alula">Explore AlUla →</a>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="search-band">
    <div class="container search-panel">
        <div>
            <span class="eyebrow">Start exploring</span>
            <h2>What are you looking for?</h2>
        </div>
        <form class="site-search" action="destinations.php" method="get">
            <input type="search" name="q" placeholder="Try ‘desert’, ‘Riyadh’ or ‘heritage’" aria-label="Search destinations">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Top destinations</span><h2>Where will Saudi Arabia take you?</h2></div>
            <a class="text-link" href="destinations.php">View all destinations →</a>
        </div>
        <div class="card-grid card-grid-3">
            <?php foreach (array_slice($destinations, 0, 6, true) as $slug => $destination): ?>
                <article class="destination-card">
                    <a href="destination.php?slug=<?= e($slug) ?>" class="card-image-link">
                        <img src="<?= e($destination['image']) ?>" alt="Stylized travel illustration for <?= e($destination['name']) ?>">
                    </a>
                    <div class="card-body">
                        <div class="card-kicker"><span><?= e($destination['best_time']) ?></span><span><?= e($destination['days']) ?></span></div>
                        <h3><a href="destination.php?slug=<?= e($slug) ?>"><?= e($destination['name']) ?></a></h3>
                        <p><?= e($destination['tagline']) ?></p>
                        <a class="text-link" href="destination.php?slug=<?= e($slug) ?>">Read guide →</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-tinted">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Plan smarter</span><h2>Everything you need for a better trip</h2></div>
        </div>
        <div class="feature-grid">
            <a class="feature-tile" href="articles.php?category=Travel+Planning"><span class="feature-icon">01</span><h3>Travel planning</h3><p>Visa reminders, seasonal planning, transport ideas and budgeting basics.</p></a>
            <a class="feature-tile" href="attractions.php"><span class="feature-icon">02</span><h3>Attractions</h3><p>Browse starter listings for heritage sites, nature, museums and waterfront experiences.</p></a>
            <a class="feature-tile" href="planner.php"><span class="feature-icon">03</span><h3>Trip planner</h3><p>Choose a destination, number of days, budget and interest to generate a starter itinerary.</p></a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Travel stories</span><h2>Guides for your next Saudi journey</h2></div>
            <a class="text-link" href="articles.php">Browse all guides →</a>
        </div>
        <div class="article-grid">
            <?php foreach (array_filter($articles, static fn($a) => $a['featured']) as $article): ?>
                <article class="article-card">
                    <span class="pill pill-light"><?= e($article['category']) ?></span>
                    <h3><a href="article.php?slug=<?= e($article['slug']) ?>"><?= e($article['title']) ?></a></h3>
                    <p><?= e($article['excerpt']) ?></p>
                    <div class="article-meta"><span><?= e($article['read_time']) ?></span><a href="article.php?slug=<?= e($article['slug']) ?>">Read article →</a></div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container cta-panel">
        <div><span class="eyebrow eyebrow-light">Create your route</span><h2>Not sure where to start?</h2><p>Generate a simple day-by-day itinerary from your travel style and trip length.</p></div>
        <a class="button button-light" href="planner.php">Open trip planner</a>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
