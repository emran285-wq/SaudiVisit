<?php
require __DIR__ . '/data/site-data.php';

$pageTitle = 'About SaudiVisit.net';
$metaDescription = 'Learn about SaudiVisit.net, an independent Saudi Arabia travel guide built for travelers, by travelers.';
$breadcrumbs = [
    ['name' => 'Home', 'url' => BASE_PATH . '/index.php'],
    ['name' => 'About'],
];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero compact-hero">
    <div class="container narrow">
        <span class="eyebrow eyebrow-light">About</span>
        <h1>About SaudiVisit.net</h1>
        <p>An independent travel platform dedicated to helping explorers discover Saudi Arabia.</p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <div class="prose">
            <h2>Our Mission</h2>
            <p>SaudiVisit.net is an independent travel guide created to help international visitors explore Saudi Arabia with practical, honest, and comprehensive information. We focus on helping travelers make the most of their journeys while respecting local culture and regulations.</p>
            
            <h2>What We Offer</h2>
            <ul>
                <li><strong>Destination Guides:</strong> In-depth information about major Saudi cities and regions</li>
                <li><strong>Travel Planning:</strong> Practical articles on visas, transportation, safety, and logistics</li>
                <li><strong>Attractions Database:</strong> Curated listings of museums, heritage sites, natural wonders and cultural experiences</li>
                <li><strong>Itineraries:</strong> Ready-made and customizable trip plans for different travel styles</li>
                <li><strong>Cultural Information:</strong> Guides to Saudi customs, cuisine, and local experiences</li>
                <li><strong>Trip Planner:</strong> An interactive tool to generate personalized itineraries</li>
            </ul>
            
            <h2>Our Editorial Standards</h2>
            <p>SaudiVisit.net is committed to accuracy and responsible travel information:</p>
            <ul>
                <li>We don't publish unverified travel facts, pricing, or regulations</li>
                <li>All travel-sensitive information includes disclaimers directing travelers to official sources</li>
                <li>We update content regularly as rules and conditions change</li>
                <li>We clearly mark content as structural templates when appropriate</li>
                <li>We encourage travelers to verify official regulations before booking</li>
            </ul>
            
            <h2>Not an Official Agency</h2>
            <p>SaudiVisit.net is <strong>not</strong> affiliated with the Saudi Ministry of Tourism, Saudi Arabia's government, or any official tourism authority. We are an independent editorial platform. For official travel requirements, visas, and regulations, always refer to official government sources.</p>
            
            <h2>Feedback & Corrections</h2>
            <p>Found an error or have a suggestion? We welcome feedback to improve our guides. Please use our <a href="contact.php">contact form</a> to report inaccuracies or share improvements.</p>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
