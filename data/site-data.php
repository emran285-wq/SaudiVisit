<?php
/**
 * SaudiVisit.net Site Data
 * Comprehensive content database for destinations, articles and attractions
 */

declare(strict_types=1);

// ============================================================================
// DESTINATIONS
// ============================================================================

$destinations = [
    'riyadh' => [
        'name' => 'Riyadh',
        'slug' => 'riyadh',
        'tagline' => 'Heritage, modern architecture and desert adventures.',
        'summary' => 'Saudi Arabia\'s capital blends historic Diriyah and old Riyadh with contemporary dining, museums, shopping and dramatic desert landscapes.',
        'description' => 'Riyadh is a dynamic city that showcases Saudi Arabia\'s transformation. Explore UNESCO-listed Diriyah for heritage, visit world-class museums, shop in modern malls, enjoy excellent dining, and take desert excursions to dramatic landscapes like the Edge of the World.',
        'best_time' => 'October to March',
        'days' => '2–4 days',
        'accent' => 'gold',
        'image' => 'assets/images/riyadh.svg',
        'highlights' => ['At-Turaif & Diriyah', 'Masmak Fortress', 'Kingdom Centre', 'Edge of the World', 'National Museum', 'AlFaisaliyah Tower'],
        'tips' => [
            'Use ride-hailing or a rental car for flexible city travel.',
            'Reserve popular restaurants and desert tours in peak season.',
            'Carry water and sun protection for outdoor excursions.',
            'Plan Al Masmak early in the day to avoid crowds.',
            'Allow 3-4 hours for Edge of the World tours including transfer time.',
        ],
    ],
    'jeddah' => [
        'name' => 'Jeddah',
        'slug' => 'jeddah',
        'tagline' => 'Red Sea energy, historic Al-Balad and coastal culture.',
        'summary' => 'Jeddah is a lively Red Sea gateway known for waterfront walks, coral-coast activities, art, seafood and UNESCO-listed Al-Balad historic district.',
        'description' => 'Jeddah offers a distinctive coastal atmosphere unique among Saudi cities. Wander the narrow lanes of Al-Balad with its historic architecture, enjoy waterfront dining on the Corniche, dive or snorkel in the Red Sea, explore art galleries and museums, and experience vibrant nightlife and modern dining concepts.',
        'best_time' => 'November to March',
        'days' => '2–3 days',
        'accent' => 'blue',
        'image' => 'assets/images/jeddah.svg',
        'highlights' => ['Al-Balad Historic District', 'Jeddah Corniche', 'Red Sea diving', 'Waterfront dining', 'Al Tayebat Museum', 'Floating Mosque'],
        'tips' => [
            'Plan Al-Balad for late afternoon into evening when it\'s cooler.',
            'Check sea conditions before diving or boat trips.',
            'Allow extra time for traffic during rush hours and major events.',
            'The corniche is best visited at sunset and early evening.',
            'Book diving tours with certified operators in advance.',
        ],
    ],
    'alula' => [
        'name' => 'AlUla',
        'slug' => 'alula',
        'tagline' => 'Ancient tombs, sandstone canyons and desert skies.',
        'summary' => 'AlUla combines archaeology, striking rock formations, desert experiences and carefully developed cultural attractions around an oasis landscape.',
        'description' => 'AlUla is a treasure for archaeology and nature lovers. Visit UNESCO World Heritage Hegra with its ancient Nabatean tombs, explore Elephant Rock and dramatic red sandstone formations, wander through the charming Old Town, experience the oasis settlement, and participate in desert stargazing experiences under pristine skies.',
        'best_time' => 'October to April',
        'days' => '2–4 days',
        'accent' => 'rose',
        'image' => 'assets/images/alula.svg',
        'highlights' => ['Hegra', 'Elephant Rock', 'AlUla Old Town', 'Desert stargazing', 'Madain Saleh', 'Winter at Tantora Festival'],
        'tips' => [
            'Book Hegra tickets in advance during peak season.',
            'Bring a light layer for cooler desert evenings.',
            'Keep time between attractions as they are spread throughout the region.',
            'A rental car is essential for exploring AlUla properly.',
            'Sunset and sunrise photography opportunities are exceptional.',
        ],
    ],
    'makkah' => [
        'name' => 'Makkah',
        'slug' => 'makkah',
        'tagline' => 'Sacred destination for Hajj and Umrah travelers.',
        'summary' => 'Makkah is Islam\'s holiest city and the destination of Hajj and Umrah. Access and travel planning should follow current Saudi regulations and religious requirements.',
        'description' => 'Makkah is the spiritual heart of Islam and a destination of profound importance for Muslim pilgrims. The city centers on the Masjid al-Haram and the sacred Kaaba. Access, accommodation, and religious protocols are strictly regulated and vary by pilgrimage type (Hajj vs. Umrah vs. general visitation).',
        'best_time' => 'Depends on pilgrimage dates',
        'days' => 'Trip-dependent',
        'accent' => 'green',
        'image' => 'assets/images/makkah.svg',
        'highlights' => ['Masjid al-Haram', 'The Kaaba', 'Pilgrimage services', 'Islamic heritage', 'Mount Arafat', 'Abraj Al-Bait Clock Tower'],
        'tips' => [
            'Always confirm current entry requirements and regulations before travel.',
            'Build generous buffer time around prayer periods and crowd flows.',
            'Use official channels and licensed tour operators for pilgrimage logistics.',
            'Modest dress and respectful behavior are mandatory.',
            'Plan carefully around seasonal closures and event schedules.',
        ],
    ],
    'madinah' => [
        'name' => 'Madinah',
        'slug' => 'madinah',
        'tagline' => 'Spiritual heritage and historic Islamic landmarks.',
        'summary' => 'Madinah is centered on Al-Masjid an-Nabawi and offers visitors important Islamic heritage sites, museums and a calm urban atmosphere.',
        'description' => 'Madinah offers a peaceful pilgrimage experience and rich Islamic history. The city centers on Al-Masjid an-Nabawi (The Prophet\'s Mosque), one of Islam\'s holiest sites. Visitors can explore historical Islamic sites, visit excellent museums, walk in gardens and parks, and experience the serene spiritual atmosphere.',
        'best_time' => 'October to March',
        'days' => '2–3 days',
        'accent' => 'green',
        'image' => 'assets/images/madinah.svg',
        'highlights' => ['Al-Masjid an-Nabawi', 'Quba Mosque', 'Islamic museums', 'Uhud mountain site', 'Al-Baqi cemetery', 'Medina gardens'],
        'tips' => [
            'Respect prayer times and designated prayer area access rules.',
            'Choose accommodation within walking distance of the mosque.',
            'Wear modest clothing appropriate for religious sites.',
            'Women may have restricted hours in some areas; confirm before visiting.',
            'The atmosphere is most peaceful during off-peak tourist seasons.',
        ],
    ],
    'abha' => [
        'name' => 'Abha',
        'slug' => 'abha',
        'tagline' => 'Mountain scenery, cooler weather and southern culture.',
        'summary' => 'Abha and the Asir region offer highland views, parks, traditional villages and a notably different climate from much of Saudi Arabia.',
        'description' => 'Abha is a refreshing contrast to desert regions, offering cooler mountain air and lush green landscapes. The Asir region is known for traditional architecture, terraced farms, open-air markets, local crafts, and spectacular viewpoints. It\'s an ideal destination for nature walks, cultural experiences, and meeting local Asir communities.',
        'best_time' => 'March to October',
        'days' => '2–4 days',
        'accent' => 'teal',
        'image' => 'assets/images/abha.svg',
        'highlights' => ['Asir highlands', 'Rijal Almaa village', 'Mountain viewpoints', 'Local crafts markets', 'Habala village', 'Shada mountain'],
        'tips' => [
            'Expect quick weather changes in the mountains.',
            'A rental car is useful for regional sightseeing and remote drives.',
            'Check road conditions before driving to remote areas.',
            'Cooler nights mean you\'ll need a light jacket even in warmer months.',
            'Visit local markets early in the day for the best selection.',
        ],
    ],
    'taif' => [
        'name' => 'Taif',
        'slug' => 'taif',
        'tagline' => 'Mountain air, rose gardens and historic heritage.',
        'summary' => 'Taif is a historic mountain city known for its cool climate, rose gardens, traditional architecture and role in Saudi Arabia\'s heritage.',
        'description' => 'Located at high altitude, Taif offers cooler temperatures and lush surroundings. The city is famous for cultivating roses and other flowers. Visitors can explore historic architecture, visit old souks, enjoy mountain viewpoints, and experience the more traditional side of Saudi culture.',
        'best_time' => 'May to September',
        'days' => '1–2 days',
        'accent' => 'rose',
        'image' => 'assets/images/taif.svg',
        'highlights' => ['Rose gardens', 'Al Shafa plateau', 'Old Taif souks', 'Al-Habala cliffside village', 'Mountain viewpoints'],
        'tips' => [
            'Visit during rose harvest season (April-May) for full flower blooms.',
            'The mountain climate means cooler evenings year-round.',
            'Many attractions are family-friendly with outdoor activities.',
            'Book Al-Habala visit in advance if interested in the cliffside village.',
        ],
    ],
    'dammam' => [
        'name' => 'Dammam & Khobar',
        'slug' => 'dammam',
        'tagline' => 'Modern eastern region with beaches and cosmopolitan culture.',
        'summary' => 'Dammam and neighboring Khobar form the eastern region\'s hub, offering modern amenities, beaches, shopping and a multicultural atmosphere.',
        'description' => 'Dammam serves as the capital of the Eastern Region with modern infrastructure. Khobar, just south of Dammam, offers beautiful beaches and more developed leisure facilities. Together they create a cosmopolitan destination with shopping malls, restaurants, waterfront activities, and access to beaches and regional sights.',
        'best_time' => 'November to March',
        'days' => '1–2 days',
        'accent' => 'blue',
        'image' => 'assets/images/dammam.svg',
        'highlights' => ['Khobar Corniche', 'King Fahd Causeway', 'The Avenues mall', 'Al-Noor beach', 'Tarout Island', 'Shopping districts'],
        'tips' => [
            'Khobar has better-developed beach facilities than Dammam proper.',
            'The King Fahd Causeway connects to Bahrain for day trips.',
            'Modern shopping and dining infrastructure is extensive.',
            'Summer heat is intense; water activities are best October-April.',
        ],
    ],
];

// ============================================================================
// ARTICLES
// ============================================================================

$articles = [
    // Planning & Getting Started
    [
        'slug' => 'saudi-arabia-travel-guide-2026',
        'title' => 'Saudi Arabia Travel Guide 2026: Everything You Need to Know',
        'category' => 'Travel Planning',
        'excerpt' => 'A practical first-trip overview covering where to go, trip length, transport, culture and planning basics for independent travelers.',
        'read_time' => '12 min read',
        'featured' => true,
        'published_date' => '2026-01-15',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saudi Arabia is a large destination with very different travel experiences across its major cities, heritage regions, coastlines and mountains. A first trip works best when you choose two or three regions rather than trying to cover the whole country at once.',
            'Riyadh is strong for museums, architecture, food and desert excursions; Jeddah combines Red Sea culture with historic Al-Balad; AlUla is ideal for archaeology and dramatic desert landscapes. Religious travel to Makkah and Madinah requires additional planning and current permit checks.',
            'For the smoothest trip, confirm official visa and entry rules, book high-demand attractions before arrival, and plan around long driving distances. Domestic flights can save significant time between regions. Most tourists spend 5-7 days combining 2-3 destinations for a balanced itinerary.',
        ],
    ],
    [
        'slug' => 'best-places-to-visit-saudi-arabia',
        'title' => 'Best Places to Visit in Saudi Arabia',
        'category' => 'Destinations',
        'excerpt' => 'A shortlist of Saudi Arabia\'s most useful destinations for culture, history, coast, mountains and desert experiences.',
        'read_time' => '8 min read',
        'featured' => true,
        'published_date' => '2026-01-20',
        'updated_date' => '2026-09-13',
        'content' => [
            'The best destination depends on your interests. Riyadh suits first-time city visitors, Jeddah suits coastal travelers, AlUla is ideal for heritage and desert scenery, and Abha provides mountain landscapes and cooler temperatures.',
            'Travelers with more time can combine a major city with a contrasting region. Riyadh plus AlUla is a strong history-and-desert pairing, while Jeddah plus Abha creates a coast-and-mountains route. The eastern region around Dammam offers modern amenities and access to causeway travel.',
        ],
    ],
    // Things To Do & Attractions
    [
        'slug' => 'things-to-do-riyadh',
        'title' => 'Top 25 Things To Do in Riyadh',
        'category' => 'Things To Do',
        'excerpt' => 'From old Riyadh and Diriyah to modern viewpoints, museums, shopping and desert day trips.',
        'read_time' => '10 min read',
        'featured' => true,
        'published_date' => '2026-01-25',
        'updated_date' => '2026-09-13',
        'content' => [
            'Start with historic Riyadh, then contrast it with the city\'s modern skyline. Diriyah, Masmak Fortress, major museums and the Kingdom Centre help create a balanced city itinerary.',
            'For an outdoor day, travelers often add a guided desert excursion. Leave enough time for transfers and sunset stops, and choose reputable operators with clear pickup and safety information. Shopping districts and dining precincts offer evening entertainment.',
        ],
    ],
    [
        'slug' => 'best-beaches-saudi-arabia',
        'title' => 'Best Beaches in Saudi Arabia: Red Sea & Gulf Coast Guide',
        'category' => 'Things To Do',
        'excerpt' => 'Discover Saudi Arabia\'s best beach experiences from Red Sea coral reefs to modern coastal developments.',
        'read_time' => '9 min read',
        'featured' => false,
        'published_date' => '2026-02-01',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saudi Arabia\'s coastlines offer distinct beach experiences. The Red Sea near Jeddah features world-class diving, coral reefs and waterfront dining. The eastern coast near Khobar offers modern beach clubs and facilities.',
            'Most beaches are best visited November through March when temperatures are comfortable. Always check current beach access rules and swimming protocols before visiting.',
        ],
    ],
    // Itineraries
    [
        'slug' => 'saudi-arabia-7-day-itinerary',
        'title' => 'Saudi Arabia in 7 Days: Complete Itinerary',
        'category' => 'Itineraries',
        'excerpt' => 'A practical one-week route combining Riyadh\'s culture, AlUla\'s heritage and desert landscapes.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-02-05',
        'updated_date' => '2026-09-13',
        'content' => [
            'A strong seven-day Saudi itinerary typically combines Riyadh (2-3 days), AlUla (2-3 days), and either Jeddah or Abha (1-2 days). This structure offers cultural heritage, natural attractions, desert experiences and varied landscapes.',
            'Days 1-3 explore Riyadh\'s museums, heritage sites and desert edges. Days 4-6 focus on AlUla archaeology and natural formations. Day 7 can either extend in AlUla or visit Jeddah\'s Red Sea culture. Build in travel days and confirm flight or drive times.',
        ],
    ],
    [
        'slug' => 'alula-three-day-itinerary',
        'title' => 'AlUla 3-Day Itinerary: Hegra, Old Town & Desert',
        'category' => 'Itineraries',
        'excerpt' => 'A structured three-day framework for Hegra, Old Town, Elephant Rock and desert experiences.',
        'read_time' => '8 min read',
        'featured' => false,
        'published_date' => '2026-02-10',
        'updated_date' => '2026-09-13',
        'content' => [
            'Day one works well for orientation, Old Town exploration and a relaxed sunset. Day two can focus on Hegra and nearby heritage experiences. Day three can combine a scenic desert activity with free time around the oasis or local markets.',
            'Because many attractions are timed or spread apart, avoid stacking too many bookings. Build your schedule around confirmed Hegra reservation windows first.',
        ],
    ],
    [
        'slug' => 'riyadh-weekend-guide',
        'title' => 'Riyadh Weekend Guide: 48-Hour Plan',
        'category' => 'Itineraries',
        'excerpt' => 'Make the most of a weekend in Riyadh with key museums, heritage sites and dining experiences.',
        'read_time' => '6 min read',
        'featured' => false,
        'published_date' => '2026-02-15',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saturday: Explore Diriyah and At-Turaif in the morning, visit the National Museum, enjoy dinner in a trendy precinct. Sunday: Take a desert tour to Edge of the World or similar landscape attraction, relax at Al Masmak or another heritage site, finish with a farewell meal.',
            'Adjust based on museum closures and prayer times. Book popular restaurants and tour operators in advance.',
        ],
    ],
    // Travel Information & Planning
    [
        'slug' => 'best-time-to-visit-saudi-arabia',
        'title' => 'Best Time to Visit Saudi Arabia: Seasons & Events',
        'category' => 'Travel Planning',
        'excerpt' => 'How seasons affect city sightseeing, desert trips, Red Sea travel and mountain escapes.',
        'read_time' => '8 min read',
        'featured' => false,
        'published_date' => '2026-03-01',
        'updated_date' => '2026-09-13',
        'content' => [
            'For many travelers, the cooler months October through March are ideal for city sightseeing and desert activities. Daytime temperatures range from 20-25°C (68-77°F), while summer temperatures exceed 45°C (113°F).',
            'Best timing varies by region. The Red Sea coast is comfortable November-March. Mountains like Abha are pleasant May-September. Check the forecast for each stop and plan outdoor activities during cooler morning and late afternoon hours.',
        ],
    ],
    [
        'slug' => 'saudi-arabia-visa-guide',
        'title' => 'Saudi Arabia Visa Guide 2026: Types, Requirements & Process',
        'category' => 'Travel Planning',
        'excerpt' => 'Complete overview of tourist visas, e-visas, religious visas and current entry requirements.',
        'read_time' => '11 min read',
        'featured' => false,
        'published_date' => '2026-03-05',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saudi Arabia offers tourist e-visas for many nationalities, making entry easier than in previous years. Most tourists should verify their nationality\'s eligibility and current processing times on official Saudi government websites.',
            'Religious travel (Hajj and Umrah) follows separate processes. Always confirm current visa requirements, documentation needs, and processing times with official sources before applying.',
        ],
    ],
    [
        'slug' => 'is-saudi-arabia-safe',
        'title' => 'Is Saudi Arabia Safe for Tourists? Travel Safety Guide',
        'category' => 'Travel Planning',
        'excerpt' => 'Evidence-based information on travel safety, local customs and practical security considerations.',
        'read_time' => '9 min read',
        'featured' => false,
        'published_date' => '2026-03-10',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saudi Arabia is generally considered safe for tourists in major cities and popular visitor areas. Petty theft is rare. Standard travel precautions apply: be aware of surroundings, use registered taxis or ride-hailing apps, and keep valuables secure.',
            'Always check current government travel advisories, register with your embassy before travel, and have emergency contact information. Respect local customs and regulations regarding dress, alcohol, prayer times and gender dynamics.',
        ],
    ],
    [
        'slug' => 'saudi-arabia-transportation-guide',
        'title' => 'Saudi Arabia Transportation Guide: Getting Around',
        'category' => 'Travel Planning',
        'excerpt' => 'Complete guide to internal flights, car rentals, public transport, taxis and regional buses.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-03-15',
        'updated_date' => '2026-09-13',
        'content' => [
            'Domestic flights are the fastest way between major cities. Riyadh, Jeddah, and AlUla are well-connected. Car rentals offer flexibility for regional exploration. International driving permits are typically required.',
            'Ride-hailing apps (Uber, Careem) work in major cities. Public buses connect major routes. Within cities, taxis are affordable and reliable. Plan transfers carefully as regions are spread far apart.',
        ],
    ],
    [
        'slug' => 'renting-car-saudi-arabia',
        'title' => 'Renting a Car in Saudi Arabia: Complete Guide',
        'category' => 'Travel Planning',
        'excerpt' => 'Requirements, costs, driving regulations and tips for independent car rental travel.',
        'read_time' => '9 min read',
        'featured' => false,
        'published_date' => '2026-03-20',
        'updated_date' => '2026-09-13',
        'content' => [
            'International visitors need a valid driving license and international driving permit. Major rental companies operate at airports. Daily rates vary by vehicle type. Petrol is inexpensive. Road quality is excellent on main routes.',
            'Driving is on the right side. Navigation apps work well. Some areas restrict night driving for tourists. Confirm current regulations before renting.',
        ],
    ],
    // Food & Culture
    [
        'slug' => 'saudi-food-guide',
        'title' => 'Saudi Food Guide: Dishes to Try & Where to Eat',
        'category' => 'Culture',
        'excerpt' => 'Beginner-friendly guide to rice dishes, grilled meats, breads, sweets, coffee and regional flavors.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-04-01',
        'updated_date' => '2026-09-13',
        'content' => [
            'Saudi cuisine varies by region, but visitors commonly encounter kabsa (rice with meat), shawarma (grilled meat wraps), falafel, hummus, fresh breads, and dates. Arabic coffee is offered as a gesture of hospitality.',
            'Every major city has excellent restaurants ranging from casual to fine dining. Food is a cornerstone of Saudi hospitality. Respect Islamic dietary practices and local customs around meal times.',
        ],
    ],
    [
        'slug' => 'saudi-culture-customs-travelers',
        'title' => 'Saudi Culture & Customs: Essential Guide for Travelers',
        'category' => 'Culture',
        'excerpt' => 'Understanding dress codes, prayer times, gender dynamics, greetings and cultural etiquette.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-04-05',
        'updated_date' => '2026-09-13',
        'content' => [
            'Respecting Saudi culture is essential for a positive visit. Dress modestly, especially in religious areas. Acknowledge prayer times when businesses close. Photography around people requires permission. Alcohol is not permitted.',
            'Greet with "Assalam alaikum" (peace be upon you). Accept hospitality graciously. Understand gender-specific customs regarding handshakes and social interactions. Learning basic Arabic phrases is appreciated.',
        ],
    ],
    // Specific Destinations
    [
        'slug' => 'hegra-visitor-guide',
        'title' => 'Hegra UNESCO World Heritage Site: Complete Visitor Guide',
        'category' => 'Destinations',
        'excerpt' => 'Everything you need to know about Hegra\'s ancient Nabatean tombs, architecture and significance.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-04-10',
        'updated_date' => '2026-09-13',
        'content' => [
            'Hegra is Saudi Arabia\'s first UNESCO World Heritage Site, featuring 94 well-preserved Nabatean tombs carved into rose-red sandstone cliffs. The site dates back 2,000 years and represents Nabatean funeral architecture at its finest.',
            'Visits are by guided tour only with reserved time slots. Wear comfortable shoes, bring water and sun protection. Photography is permitted. The dramatic landscape and historical significance make it one of Saudi Arabia\'s must-see attractions.',
        ],
    ],
    [
        'slug' => 'jeddah-red-sea-diving-guide',
        'title' => 'Red Sea Diving & Snorkeling Guide: Jeddah & Beyond',
        'category' => 'Things To Do',
        'excerpt' => 'Best dive sites, coral reefs, marine life and how to arrange diving experiences.',
        'read_time' => '9 min read',
        'featured' => false,
        'published_date' => '2026-04-15',
        'updated_date' => '2026-09-13',
        'content' => [
            'The Red Sea near Jeddah offers world-class diving with pristine coral reefs, abundant marine life, and excellent visibility. Popular dive sites include Mavi Reef and various wrecks. Snorkeling is possible from beaches and organized boat tours.',
            'Book with certified dive operators. Bring your diving certification card. Best diving conditions are typically October through May. Respect marine conservation practices.',
        ],
    ],
    // Budget & Practical
    [
        'slug' => 'saudi-arabia-travel-cost-guide',
        'title' => 'Saudi Arabia Travel Cost Guide: Budget Breakdown',
        'category' => 'Travel Planning',
        'excerpt' => 'Realistic daily costs for accommodation, food, attractions and activities across budget levels.',
        'read_time' => '10 min read',
        'featured' => false,
        'published_date' => '2026-04-20',
        'updated_date' => '2026-09-13',
        'content' => [
            'Budget travelers can spend $50-75/day including modest accommodation and local food. Mid-range travelers should plan $100-150/day. Premium travelers typically spend $200+/day. Costs vary significantly by city and season.',
            'Attractions have entrance fees ranging from free (public areas) to $20-30 (major heritage sites). Food costs depend on restaurant choice. Transportation between regions can add significantly to overall costs.',
        ],
    ],
    [
        'slug' => 'saudi-arabia-shopping-guide',
        'title' => 'Saudi Arabia Shopping Guide: Markets, Malls & Local Products',
        'category' => 'Culture',
        'excerpt' => 'Where to find traditional crafts, souvenirs, modern goods and authentic local products.',
        'read_time' => '8 min read',
        'featured' => false,
        'published_date' => '2026-04-25',
        'updated_date' => '2026-09-13',
        'content' => [
            'Traditional souks (markets) in Al-Balad (Jeddah) and old Riyadh offer local handicrafts, textiles, and souvenirs. Modern shopping malls in Riyadh and Jeddah have international brands. Oud (fragrant resin) is a popular local luxury gift.',
            'The Asir region is known for traditional crafts and textiles. Haggling is common in traditional souks. Many shops close during prayer times.',
        ],
    ],
    // Religious Travel
    [
        'slug' => 'hajj-umrah-guide',
        'title' => 'Hajj and Umrah: Pilgrim\'s Complete Guide',
        'category' => 'Travel Planning',
        'excerpt' => 'Overview of Hajj and Umrah pilgrimages, requirements, timing and essential information.',
        'read_time' => '12 min read',
        'featured' => false,
        'published_date' => '2026-05-01',
        'updated_date' => '2026-09-13',
        'content' => [
            'Hajj is the mandatory pilgrimage to Makkah during specific Islamic calendar dates, required of Muslims who are physically and financially able. Umrah is a voluntary pilgrimage possible year-round. Both require significant planning and adherence to religious protocols.',
            'Processing visas, selecting tour operators, understanding health requirements, and budgeting appropriately are essential. Always work with official channels and licensed operators for safe, compliant pilgrim experiences.',
        ],
    ],
];

require __DIR__ . '/article-content.php';

// ============================================================================
// ATTRACTIONS
// ============================================================================

$attractions = [
    // Riyadh
    ['name' => 'At-Turaif District, Diriyah', 'destination' => 'riyadh', 'category' => 'Heritage', 'price' => 'Check current ticketing', 'rating' => '4.8'],
    ['name' => 'Masmak Fortress', 'destination' => 'riyadh', 'category' => 'Museum', 'price' => 'Check current entry', 'rating' => '4.6'],
    ['name' => 'Edge of the World', 'destination' => 'riyadh', 'category' => 'Nature', 'price' => 'Tour-dependent', 'rating' => '4.8'],
    ['name' => 'National Museum of Saudi Arabia', 'destination' => 'riyadh', 'category' => 'Museum', 'price' => 'Entry fee varies', 'rating' => '4.7'],
    ['name' => 'Kingdom Centre Tower', 'destination' => 'riyadh', 'category' => 'Landmark', 'price' => 'Observation deck fee', 'rating' => '4.5'],
    ['name' => 'AlFaisaliyah Tower', 'destination' => 'riyadh', 'category' => 'Landmark', 'price' => 'Various', 'rating' => '4.4'],
    ['name' => 'Riyadh Zoo', 'destination' => 'riyadh', 'category' => 'Family', 'price' => 'Entrance fee', 'rating' => '4.3'],
    
    // Jeddah
    ['name' => 'Al-Balad Historic District', 'destination' => 'jeddah', 'category' => 'Heritage', 'price' => 'Free public area', 'rating' => '4.7'],
    ['name' => 'Jeddah Corniche', 'destination' => 'jeddah', 'category' => 'Waterfront', 'price' => 'Free public area', 'rating' => '4.6'],
    ['name' => 'Al Tayebat Museum', 'destination' => 'jeddah', 'category' => 'Museum', 'price' => 'Entry fee', 'rating' => '4.5'],
    ['name' => 'Floating Mosque', 'destination' => 'jeddah', 'category' => 'Religious', 'price' => 'Free', 'rating' => '4.8'],
    ['name' => 'Red Sea diving sites', 'destination' => 'jeddah', 'category' => 'Water Sports', 'price' => 'Dive operator fees', 'rating' => '4.9'],
    ['name' => 'Jeddah Art District', 'destination' => 'jeddah', 'category' => 'Art & Culture', 'price' => 'Variable', 'rating' => '4.4'],
    
    // AlUla
    ['name' => 'Hegra (Mada\'in Salih)', 'destination' => 'alula', 'category' => 'Archaeology', 'price' => 'Reservation required', 'rating' => '4.9'],
    ['name' => 'Elephant Rock', 'destination' => 'alula', 'category' => 'Nature', 'price' => 'Free (included in pass)', 'rating' => '4.8'],
    ['name' => 'AlUla Old Town', 'destination' => 'alula', 'category' => 'Heritage', 'price' => 'Free public area', 'rating' => '4.6'],
    ['name' => 'Desert Rose & stargazing', 'destination' => 'alula', 'category' => 'Nature', 'price' => 'Tour-dependent', 'rating' => '4.7'],
    ['name' => 'AlUla Oasis Walk', 'destination' => 'alula', 'category' => 'Nature', 'price' => 'Free', 'rating' => '4.5'],
    ['name' => 'Jabal Ikmah rock art site', 'destination' => 'alula', 'category' => 'Archaeology', 'price' => 'Check current access', 'rating' => '4.6'],
    
    // Abha
    ['name' => 'Rijal Almaa Village', 'destination' => 'abha', 'category' => 'Heritage', 'price' => 'Check current entry', 'rating' => '4.7'],
    ['name' => 'Al-Shafa Plateau', 'destination' => 'abha', 'category' => 'Nature', 'price' => 'Free public access', 'rating' => '4.6'],
    ['name' => 'Habala Cliffside Village', 'destination' => 'abha', 'category' => 'Heritage', 'price' => 'Tour-dependent', 'rating' => '4.8'],
    ['name' => 'Asir National Park', 'destination' => 'abha', 'category' => 'Nature', 'price' => 'Entry fee', 'rating' => '4.5'],
    ['name' => 'Old Abha souks and markets', 'destination' => 'abha', 'category' => 'Shopping', 'price' => 'Free browsing', 'rating' => '4.4'],
    
    // Makkah (pilgrimage sites)
    ['name' => 'Masjid al-Haram', 'destination' => 'makkah', 'category' => 'Religious', 'price' => 'Free for pilgrims', 'rating' => '5.0'],
    ['name' => 'The Kaaba', 'destination' => 'makkah', 'category' => 'Religious', 'price' => 'Pilgrimage-specific', 'rating' => '5.0'],
    ['name' => 'Abraj Al-Bait Clock Tower', 'destination' => 'makkah', 'category' => 'Landmark', 'price' => 'Variable', 'rating' => '4.6'],
    
    // Madinah
    ['name' => 'Al-Masjid an-Nabawi', 'destination' => 'madinah', 'category' => 'Religious', 'price' => 'Free', 'rating' => '5.0'],
    ['name' => 'Quba Mosque', 'destination' => 'madinah', 'category' => 'Religious', 'price' => 'Free', 'rating' => '4.8'],
    ['name' => 'Islamic Museum Madinah', 'destination' => 'madinah', 'category' => 'Museum', 'price' => 'Entry fee', 'rating' => '4.6'],
    ['name' => 'Mount Uhud', 'destination' => 'madinah', 'category' => 'Religious', 'price' => 'Free public access', 'rating' => '4.5'],
];
?>
