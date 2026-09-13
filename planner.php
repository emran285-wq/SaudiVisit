<?php
require __DIR__ . '/data/site-data.php';
$pageTitle = 'Saudi Arabia Trip Planner | SaudiVisit.net';
$metaDescription = 'Generate a simple Saudi Arabia itinerary by destination, trip length, budget and interests.';

$selectedDestination = (string)($_POST['destination'] ?? $_GET['destination'] ?? 'riyadh');
if (!isset($destinations[$selectedDestination])) $selectedDestination = 'riyadh';
$days = max(1, min(10, (int)($_POST['days'] ?? 3)));
$budget = (string)($_POST['budget'] ?? 'mid-range');
$interest = (string)($_POST['interest'] ?? 'culture');
$generated = $_SERVER['REQUEST_METHOD'] === 'POST';

$activityPools = [
    'culture' => ['heritage district and museum visit', 'traditional food stop', 'historic neighborhood walk', 'local art or cultural venue'],
    'adventure' => ['guided outdoor excursion', 'sunrise or sunset viewpoint', 'nature activity', 'scenic drive with photo stops'],
    'food' => ['traditional Saudi breakfast', 'local market visit', 'regional lunch experience', 'modern Saudi dinner'],
    'relaxation' => ['slow morning and café stop', 'waterfront or park walk', 'spa or hotel downtime', 'sunset dinner'],
    'family' => ['family-friendly museum', 'easy outdoor attraction', 'shopping and dining district', 'interactive local experience'],
];
require __DIR__ . '/includes/header.php';
?>
<section class="planner-hero"><div class="container planner-heading"><span class="eyebrow eyebrow-light">Trip planner</span><h1>Build a simple Saudi itinerary</h1><p>Choose your trip basics and generate a starter day-by-day plan. No API or account needed for this localhost version.</p></div></section>
<section class="section planner-section">
    <div class="container planner-grid">
        <form class="planner-form" method="post" action="planner.php">
            <div class="form-head"><h2>Your trip</h2><p>Adjust the inputs and regenerate anytime.</p></div>
            <label>Destination<select name="destination"><?php foreach ($destinations as $slug => $item): ?><option value="<?= e($slug) ?>" <?= $selectedDestination === $slug ? 'selected' : '' ?>><?= e($item['name']) ?></option><?php endforeach; ?></select></label>
            <label>Number of days<input type="number" name="days" min="1" max="10" value="<?= e((string)$days) ?>"></label>
            <label>Budget<select name="budget"><option value="budget" <?= $budget === 'budget' ? 'selected' : '' ?>>Budget</option><option value="mid-range" <?= $budget === 'mid-range' ? 'selected' : '' ?>>Mid-range</option><option value="premium" <?= $budget === 'premium' ? 'selected' : '' ?>>Premium</option></select></label>
            <fieldset><legend>Primary interest</legend><div class="radio-grid"><?php foreach (array_keys($activityPools) as $item): ?><label class="radio-card"><input type="radio" name="interest" value="<?= e($item) ?>" <?= $interest === $item ? 'checked' : '' ?>><span><?= e(ucfirst($item)) ?></span></label><?php endforeach; ?></div></fieldset>
            <button class="button full-button" type="submit">Generate itinerary</button>
        </form>
        <div class="itinerary-panel">
            <?php if (!$generated): ?>
                <div class="itinerary-empty"><span class="planner-icon">✦</span><h2>Your itinerary will appear here</h2><p>Use the form to create a starter plan for <?= e($destinations[$selectedDestination]['name']) ?>.</p></div>
            <?php else: ?>
                <?php $pool = $activityPools[$interest] ?? $activityPools['culture']; $highlights = $destinations[$selectedDestination]['highlights']; ?>
                <div class="itinerary-head"><div><span class="eyebrow">Generated plan</span><h2><?= e((string)$days) ?> days in <?= e($destinations[$selectedDestination]['name']) ?></h2></div><span class="pill"><?= e(ucfirst($budget)) ?></span></div>
                <p class="itinerary-summary">Focused on <strong><?= e($interest) ?></strong>, mixing signature highlights with flexible travel time.</p>
                <div class="day-list">
                    <?php for ($i = 1; $i <= $days; $i++): $highlight = $highlights[($i - 1) % count($highlights)]; $activity = $pool[($i - 1) % count($pool)]; ?>
                        <article class="day-card"><span class="day-number">Day <?= $i ?></span><div><h3><?= e($highlight) ?></h3><p>Morning: <?= e(ucfirst($activity)) ?>. Afternoon: explore nearby sights at a relaxed pace. Evening: choose a local dining area and keep the schedule flexible.</p></div></article>
                    <?php endfor; ?>
                </div>
                <div class="callout"><strong>Production upgrade:</strong> Replace this rule-based generator with attraction availability, maps, travel-time estimates, user saves and AI itinerary APIs.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
