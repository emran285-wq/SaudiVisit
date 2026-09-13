<?php
require __DIR__ . '/data/site-data.php';

http_response_code(404);
$pageTitle = 'Page Not Found - SaudiVisit.net';
$metaDescription = 'The page you\'re looking for couldn\'t be found. Check out our guides and destinations instead.';

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero compact-hero">
    <div class="container narrow">
        <h1 style="font-size: 4rem; margin: 0 0 10px;">404</h1>
        <p>The page you're looking for doesn't exist or has moved.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <div class="prose">
            <h2>What You Can Do</h2>
            <p>Try one of these:</p>
            <ul>
                <li><a href="<?= BASE_PATH ?>/index.php">Return to the homepage</a></li>
                <li><a href="<?= BASE_PATH ?>/destinations.php">Explore destinations</a></li>
                <li><a href="<?= BASE_PATH ?>/articles.php">Browse travel guides</a></li>
                <li><a href="<?= BASE_PATH ?>/attractions.php">See attractions</a></li>
                <li><a href="<?= BASE_PATH ?>/planner.php">Use the trip planner</a></li>
            </ul>
            
            <h2>Search for What You Need</h2>
            <form class="site-search" action="<?= BASE_PATH ?>/destinations.php" method="get">
                <input type="search" name="q" placeholder="Search destinations...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
