</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="brand brand-footer" href="index.php"><span class="brand-mark">SV</span><span class="brand-text"><strong>SaudiVisit</strong><small>.net</small></span></a>
            <p>Independent travel inspiration and practical planning resources for exploring Saudi Arabia.</p>
        </div>
        <div>
            <h3>Explore</h3>
            <a href="destinations.php">Destinations</a>
            <a href="articles.php">Travel Guides</a>
            <a href="attractions.php">Attractions</a>
        </div>
        <div>
            <h3>Plan</h3>
            <a href="planner.php">Trip Planner</a>
            <a href="article.php?slug=best-time-to-visit-saudi-arabia">Best Time to Visit</a>
            <a href="article.php?slug=saudi-arabia-travel-guide-2026">Saudi Travel Guide</a>
        </div>
        <div>
            <h3>Newsletter</h3>
            <p>Get new itineraries and destination guides.</p>
            <form class="newsletter" action="#" method="post" onsubmit="return false;">
                <label class="sr-only" for="footer-email">Email address</label>
                <input id="footer-email" type="email" placeholder="you@example.com" required>
                <button type="submit">Join</button>
            </form>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© <?= date('Y') ?> SaudiVisit.net</span>
        <span>Starter site for local development. Verify live travel rules before publishing.</span>
    </div>
</footer>
<script src="assets/js/app.js"></script>
</body>
</html>
