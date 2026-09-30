-- SaudiVisit.net — seed data (sample launch content)
-- Demo content only. Do not import this file into production.
-- Set a password hash locally before using these demo accounts.
USE saudivisit;

INSERT INTO users (email, password_hash, name, role) VALUES
('admin@saudivisit.net', 'RESET_REQUIRED', 'Site Admin', 'admin'),
('editor@saudivisit.net', 'RESET_REQUIRED', 'Editor Example', 'editor');

INSERT INTO authors (user_id, slug, name, bio) VALUES
(1, 'saudivisit-team', 'SaudiVisit Editorial Team', 'Independent travel publication covering practical Saudi Arabia trip planning.');

INSERT INTO destinations (locale, slug, title, intro, quick_facts, sort_order) VALUES
('en', 'riyadh', 'Riyadh', 'The capital: modern skyline, historic Diriyah and the practical logistics of a first visit.', '{"Best months":"October–March","Airport":"King Khalid Intl (RUH)","Getting around":"Metro + ride-hailing"}', 1),
('en', 'jeddah', 'Jeddah', 'The Red Sea gateway: Al-Balad''s coral houses, the Corniche and a slower coastal rhythm.', '{"Best months":"November–February","Airport":"King Abdulaziz Intl (JED)","Known for":"Al-Balad, Corniche"}', 2),
('en', 'alula', 'AlUla', 'Desert canyons and Hegra''s Nabataean tombs — plan ahead, many experiences require booking.', '{"Best months":"October–March","Access":"AlUla Intl (ULH) or 3h from Madinah","Book ahead":"Hegra tours"}', 3);

INSERT INTO topics (locale, slug, title, intro) VALUES
('en', 'travel-planning', 'Travel Planning', 'Itineraries, budgets, seasons and first-trip decisions.'),
('en', 'transport', 'Transport', 'Airports, intercity travel and getting around each city.'),
('en', 'food-culture', 'Food & Culture', 'Saudi dishes, coffee hospitality and visitor etiquette.'),
('en', 'itineraries', 'Itineraries', 'Day-by-day routes with realistic travel times.');

-- Sample published articles (replace with real editorial content)
INSERT INTO articles (id, owner_id, primary_author_id) VALUES (1, 1, 1), (2, 1, 1), (3, 1, 1);

INSERT INTO article_localizations
(article_id, locale, slug, title, excerpt, body, state, published_at, reviewed_at, review_due_at, seo_title, meta_description, content_type, reviewer_id) VALUES
(1, 'en', 'saudi-arabia-travel-guide-first-time-visitors',
 'Saudi Arabia Travel Guide for First-Time Visitors',
 'A practical planning path for a first Saudi trip: when to go, where to base yourself and how to get around.',
 '<h2>Start here</h2><p>This is sample launch content. Replace it in the CMS with your reviewed pillar guide.</p><h2>When to visit</h2><p>October to March offers milder weather across most regions.</p>',
 'published', UTC_TIMESTAMP(), UTC_TIMESTAMP(), DATE_ADD(UTC_TIMESTAMP(), INTERVAL 180 DAY),
 'Saudi Arabia Travel Guide for First-Time Visitors | SaudiVisit',
 'Plan a first Saudi Arabia trip with confidence: seasons, cities, budgets and transport — a practical starting point.',
 'pillar', 2),
(2, 'en', 'riyadh-travel-guide-first-time-visitors',
 'Riyadh Travel Guide for First-Time Visitors',
 'Riyadh basics: where to stay, how to get around and how to structure your days.',
 '<h2>Riyadh at a glance</h2><p>Sample content — replace via the CMS.</p>',
 'published', UTC_TIMESTAMP(), UTC_TIMESTAMP(), DATE_ADD(UTC_TIMESTAMP(), INTERVAL 180 DAY),
 'Riyadh Travel Guide for First-Time Visitors | SaudiVisit',
 'A practical Riyadh guide: areas, transport, a 3-day structure and current logistics for first-time visitors.',
 'pillar', 2),
(3, 'en', 'riyadh-three-day-itinerary',
 'A 3-Day Riyadh Itinerary',
 'A realistic day-by-day Riyadh route with travel-time assumptions.',
 '<h2>Day 1: Historic Riyadh</h2><p>Sample content — replace via the CMS.</p>',
 'published', UTC_TIMESTAMP(), UTC_TIMESTAMP(), DATE_ADD(UTC_TIMESTAMP(), INTERVAL 180 DAY),
 'A 3-Day Riyadh Itinerary | SaudiVisit',
 'Three days in Riyadh, planned realistically: Diriyah, museums and modern districts with travel times.',
 'itinerary', 2);

INSERT INTO article_destination (article_id, destination_id) VALUES (1, 1), (2, 1), (3, 1);
INSERT INTO article_topic (article_id, topic_id) VALUES (1, 1), (2, 1), (3, 4);

INSERT INTO sources (localization_id, source_url, publisher, claim_section, checked_at, reviewer_id) VALUES
(1, 'https://www.visitsaudi.com/en', 'Visit Saudi', 'Seasons and entry basics', UTC_TIMESTAMP(), 2);

INSERT INTO pages (locale, slug, title, body) VALUES
('en', 'about', 'About SaudiVisit', '<p>SaudiVisit.net is an independent travel publication. We are not a government portal, official tourism authority or visa-processing service.</p>'),
('en', 'editorial-policy', 'Editorial Policy', '<p>How we research, fact-check and date our guides.</p>'),
('en', 'corrections', 'Corrections', '<p>How to request a correction to published content.</p>'),
('en', 'contact', 'Contact', '<p>Email the editorial team at editorial@saudivisit.net.</p>'),
('en', 'privacy', 'Privacy Policy', '<p>What data we collect and why.</p>'),
('en', 'terms', 'Terms of Use', '<p>Terms governing use of this website.</p>'),
('en', 'disclosure', 'Affiliate Disclosure', '<p>How future affiliate links and sponsorships will be disclosed.</p>');
