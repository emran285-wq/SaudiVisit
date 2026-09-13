<?php
/**
 * Editorial enrichment for every published article.
 *
 * This layer keeps the stable article index in site-data.php while allowing
 * each guide to carry its own search metadata, sections, FAQs and links.
 */

$section = static function (string $heading, array $paragraphs, array $bullets = []): array {
    return [
        'heading' => $heading,
        'paragraphs' => $paragraphs,
        'bullets' => $bullets,
    ];
};

$articleEnhancements = [
    'saudi-arabia-travel-guide-2026' => [
        'seo_title' => 'Saudi Arabia Travel Guide 2026: First Trip Planner',
        'meta_description' => 'Plan a first trip to Saudi Arabia with practical advice on destinations, visas, transport, costs, culture, safety and itineraries.',
        'primary_keyword' => 'Saudi Arabia travel guide',
        'secondary_keywords' => ['Saudi Arabia itinerary', 'travel to Saudi Arabia', 'Saudi Arabia trip planning'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Saudi Arabia rewards travelers who plan by region. The capital brings museums, contemporary dining and desert excursions; Jeddah adds Red Sea coast and historic Al-Balad; AlUla combines archaeology with extraordinary sandstone scenery; Abha offers highland landscapes and a cooler change of pace. This guide explains how to choose a route, prepare for entry, move between regions and travel respectfully in 2026. It is written for independent visitors, while religious travel to Makkah and Madinah is treated separately because requirements and access rules can change.',
        'sections' => [
            $section('Choose a route that matches your time', [
                'A first visit of five to seven days is usually more enjoyable when it focuses on two or three areas. Riyadh and AlUla make a strong culture-and-landscape pairing. Jeddah and AlUla provide a coast-and-heritage contrast, while Riyadh and Jeddah suit travelers who prefer museums, food and urban life.',
                'Saudi Arabia is geographically large. Check the actual transfer time before adding another city, and use a domestic flight when a long drive would consume a full sightseeing day. A slower itinerary leaves room for prayer breaks, weather changes, traffic and the time needed to experience large heritage sites properly.'
            ], ['5-7 days: Riyadh plus AlUla or Jeddah', '8-12 days: add a third region', 'Religious trips require their own official planning process']),
            $section('Entry, documents and trip preparation', [
                'Visa eligibility, validity, insurance and entry conditions depend on nationality and can change. Confirm current requirements through official Saudi government channels before paying for flights or accommodation. Keep digital and printed copies of your passport, visa, insurance details, hotel confirmations and emergency contacts.',
                'Reserve time-sensitive experiences early, especially Hegra visits and seasonal events in AlUla. Download offline maps, arrange an eSIM or roaming plan, and check whether your driving licence and international driving permit are accepted if you plan to rent a car.'
            ]),
            $section('Getting around Saudi Arabia', [
                'Domestic flights are the practical choice between distant cities. Ride-hailing is useful in Riyadh and Jeddah, while a rental car gives more freedom in AlUla, Abha and the Eastern Region. In cities, allow extra time for peak traffic and do not assume that two attractions on a map are a quick walk apart.',
                'For desert and mountain excursions, use an experienced operator or a suitable vehicle and share your itinerary. Carry water, fuel up before remote drives and avoid treating a navigation estimate as a guarantee in areas with limited services.'
            ]),
            $section('Culture, comfort and responsible travel', [
                'Dress modestly in public and be especially attentive around mosques, family spaces and pilgrimage areas. Ask before photographing people, private homes or sensitive facilities. Businesses may pause during prayer times, so keep plans flexible and treat hospitality as an invitation to slow down rather than rush through a checklist.',
                'Summer heat changes the shape of a trip: plan outdoor visits early or late, use indoor museums during the middle of the day and monitor official weather guidance. Religious access, photography rules and attraction schedules should always be checked close to travel.'
            ]),
            $section('Suggested first-trip outline', [
                'Spend two or three days in Riyadh for Diriyah, the National Museum, Masmak Fortress, skyline views and a carefully planned desert excursion. Fly to AlUla for two or three nights, placing the reserved Hegra experience at the centre of that stay. Use the remaining time for Old Town, Elephant Rock and an oasis or stargazing activity.',
                'This outline is a framework rather than a booking instruction. Seasonal events, flight schedules and attraction availability may change, so confirm each segment before finalizing the route.'
            ])
        ],
        'faq' => [
            ['question' => 'How many days are enough for a first trip to Saudi Arabia?', 'answer' => 'Five to seven days works well for two regions, such as Riyadh and AlUla. Add days rather than destinations when you want a slower pace or long road transfers.'],
            ['question' => 'Is Saudi Arabia suitable for independent travelers?', 'answer' => 'Yes, many visitors plan independently in major cities. Time-sensitive attractions and remote desert trips are easier when reserved with official or reputable operators.'],
            ['question' => 'What should travelers verify before booking?', 'answer' => 'Verify visa eligibility, passport validity, insurance, attraction access, transport schedules and any pilgrimage-related rules through official sources.']
        ],
        'related_articles' => ['best-places-to-visit-saudi-arabia', 'best-time-to-visit-saudi-arabia', 'saudi-arabia-transportation-guide', 'saudi-arabia-travel-cost-guide'],
    ],
    'best-places-to-visit-saudi-arabia' => [
        'seo_title' => 'Best Places to Visit in Saudi Arabia: 10 Regions',
        'meta_description' => 'Compare the best places to visit in Saudi Arabia for history, coast, desert, mountains, food and first-time travel planning.',
        'primary_keyword' => 'best places to visit in Saudi Arabia',
        'secondary_keywords' => ['Saudi Arabia destinations', 'where to go in Saudi Arabia', 'Saudi travel regions'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/alula.svg',
        'intro' => 'The best places to visit in Saudi Arabia depend on the kind of trip you want. Riyadh is the most versatile introduction, Jeddah is the country\'s Red Sea cultural gateway, and AlUla is the standout for ancient sites and desert scenery. Abha and Taif offer mountain air, while Dammam and Khobar bring beaches and modern Eastern Province life. Makkah and Madinah are destinations of religious significance whose access and requirements must be checked through official channels.',
        'sections' => [
            $section('Riyadh: the strongest all-round first stop', [
                'Choose Riyadh for museums, historic Diriyah, Masmak Fortress, modern architecture and a deep restaurant scene. It works for short breaks because the city combines indoor attractions with evening dining and nearby desert landscapes.',
                'Allow at least two full days. Add a third for a guided Edge of the World excursion or a slower food-and-neighborhood schedule. The city is spread out, so group stops by area and use ride-hailing or a car rather than planning to walk between districts.'
            ]),
            $section('Jeddah: Red Sea coast and Al-Balad', [
                'Jeddah suits travelers who want sea air, seafood, waterfront promenades, art and historic architecture. Al-Balad is best treated as a living district rather than a single monument: allow time for lanes, restored houses, markets and small cultural stops.',
                'Two or three days covers Al-Balad, the Corniche and one organized Red Sea activity. Check sea conditions and operator credentials before diving or snorkeling, and plan outdoor walks for cooler parts of the day.'
            ]),
            $section('AlUla: archaeology and desert landscapes', [
                'AlUla is the most distinctive choice for ancient sites and geological scenery. Hegra, Jabal Ikmah, the oasis, Old Town and Elephant Rock are spread across a broad area, so a car, transfer service or organized excursion is important.',
                'Stay two to four nights if Hegra and photography are priorities. Build the itinerary around confirmed reservation windows and leave space for sunset, weather and the distances between visitor zones.'
            ]),
            $section('Abha, Taif and the Eastern Region', [
                'Abha and the wider Asir region provide mountain viewpoints, traditional villages and a noticeably different climate. Taif is a practical highland escape from the western region, known for rose cultivation, markets and mountain roads. Both are better for travelers who enjoy scenery and short drives than for visitors seeking a dense city checklist.',
                'Dammam and Khobar are useful for beaches, shopping, restaurants and a modern base in the Eastern Region. They suit a shorter coastal break or travelers continuing toward the King Fahd Causeway, subject to current entry rules for onward travel.'
            ]),
            $section('How to choose', [
                'For history choose Riyadh, AlUla and Jeddah. For nature combine AlUla with Abha or the Red Sea. For food and city life prioritize Riyadh and Jeddah. For a first trip with limited time, two contrasting destinations are more rewarding than four rushed stops.',
                'Before committing, compare seasonal weather, flight availability and the operating calendar for major attractions. A destination can be a strong match in principle but a poor fit for your dates if the activities you want are unavailable.'
            ])
        ],
        'faq' => [
            ['question' => 'Which Saudi destination is best for first-time visitors?', 'answer' => 'Riyadh is the most flexible first stop, while Riyadh plus AlUla gives a broad introduction to city culture, heritage and desert landscapes.'],
            ['question' => 'What is the best destination for beaches?', 'answer' => 'Jeddah is the easiest major base for Red Sea experiences. Organized trips and access rules vary, so check current operators and conditions.'],
            ['question' => 'Which destinations are cooler?', 'answer' => 'Abha and Taif are highland destinations with a milder feel than much of the country, although temperatures and rainfall vary by season.']
        ],
        'related_articles' => ['saudi-arabia-travel-guide-2026', 'best-time-to-visit-saudi-arabia', 'saudi-arabia-7-day-itinerary', 'saudi-food-guide'],
    ],
    'things-to-do-riyadh' => [
        'seo_title' => '25 Best Things to Do in Riyadh: Local Guide',
        'meta_description' => 'Plan Riyadh sightseeing with historic Diriyah, museums, skyline views, desert trips, family activities, food and shopping ideas.',
        'primary_keyword' => 'things to do in Riyadh',
        'secondary_keywords' => ['Riyadh attractions', 'Riyadh sightseeing', 'Riyadh activities'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Riyadh is easiest to enjoy as a series of contrasting experiences: historic mud-brick architecture in Diriyah and old Riyadh, carefully curated museums, dramatic skyline viewpoints, contemporary restaurants and wide-open desert beyond the city. The best things to do are not all interchangeable. Some need a timed reservation, some are best after sunset and some require a car or tour. This guide groups the city\'s major experiences so you can build a realistic day rather than collect disconnected pins.',
        'sections' => [
            $section('History and heritage', [
                'Begin with At-Turaif in Diriyah to understand the political and architectural history of the First Saudi State. Continue through the surrounding heritage and dining areas, checking the current access and event calendar before you go. The restored setting is most comfortable when you allow time to read, pause and photograph details rather than rushing between buildings.',
                'Masmak Fortress and the nearby historic centre offer a more compact introduction to Riyadh\'s modern history. Pair them with the National Museum if you want broader context. Modest clothing, respectful photography and flexibility around prayer times make heritage visits smoother.'
            ], ['At-Turaif and Diriyah', 'Masmak Fortress', 'National Museum of Saudi Arabia', 'Historic markets and restored districts']),
            $section('Modern Riyadh and city views', [
                'The Kingdom Centre Sky Bridge is the classic high-level view of the capital, while AlFaisaliyah provides another recognizable landmark and restaurant setting. Visit near sunset only if the schedule and visibility suit you; the most popular time is not always the clearest.',
                'For contemporary architecture and design, explore major business and cultural districts rather than limiting the visit to one tower. Riyadh\'s appeal is often in the transition between a gallery, a coffee stop, a bookstore and an evening restaurant.'
            ]),
            $section('Outdoor, family and evening activities', [
                'A guided Edge of the World trip is a full excursion, not a quick city attraction. Confirm vehicle suitability, weather, pickup details and return time. Carry water, sun protection and closed shoes, and follow the guide\'s instructions near cliff edges.',
                'Families can choose from current parks, seasonal entertainment and the zoo, while adults may prefer live events, galleries and restaurant districts. Programming changes, so use official event listings rather than relying on an old social post.'
            ]),
            $section('Food, shopping and a practical day plan', [
                'Riyadh\'s dining scene spans Saudi classics, regional Middle Eastern food, coffee shops and international restaurants. Use a heritage lunch or local breakfast to balance more polished evening venues. Traditional souks are best approached as places to browse, ask questions and buy thoughtfully rather than as a rushed souvenir stop.',
                'A workable day is Diriyah in the late morning, an indoor museum in the afternoon, a rest during the hottest hours and a skyline or dining district after sunset. Grouping locations by area reduces traffic time and leaves energy for the experience itself.'
            ])
        ],
        'faq' => [
            ['question' => 'How many days do you need in Riyadh?', 'answer' => 'Two full days covers the main heritage, museum and skyline experiences. Add a third day for a desert excursion, shopping or a slower food itinerary.'],
            ['question' => 'Can Riyadh attractions be visited without a car?', 'answer' => 'Major city attractions are reachable by ride-hailing, but a car or organized tour is more convenient for spread-out sites and desert excursions.'],
            ['question' => 'What should I book ahead?', 'answer' => 'Reserve timed heritage experiences, desert tours, popular restaurants and seasonal events when demand is high.']
        ],
        'related_articles' => ['riyadh-weekend-guide', 'saudi-arabia-transportation-guide', 'saudi-food-guide', 'best-time-to-visit-saudi-arabia'],
    ],
    'best-beaches-saudi-arabia' => [
        'seo_title' => 'Best Beaches in Saudi Arabia: Red Sea and Gulf',
        'meta_description' => 'Compare Saudi Arabia beach destinations for swimming, diving, snorkeling, family days and waterfront evenings on the Red Sea and Gulf.',
        'primary_keyword' => 'best beaches in Saudi Arabia',
        'secondary_keywords' => ['Saudi Red Sea beaches', 'Jeddah beaches', 'Saudi Gulf coast'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/jeddah.svg',
        'intro' => 'Saudi Arabia has two very different coastlines. The Red Sea is the stronger choice for coral reefs, boat trips and diving, while the Arabian Gulf around Khobar and Dammam is convenient for waterfront walks, family facilities and a modern coastal weekend. Beach access is not uniform: some places are public, some are private or resort-managed, and some require an organized boat or excursion. Check current rules, weather, swimming conditions and operator details before setting out.',
        'sections' => [
            $section('Red Sea experiences around Jeddah', [
                'Jeddah is the most practical large-city base for Red Sea activities. The Corniche works for a sunset walk and waterfront atmosphere, while boat operators take visitors to reefs and offshore sites. The experience is often more rewarding on a planned marine excursion than at an urban shoreline.',
                'Choose a certified operator that explains equipment, weather cancellations, group size, insurance and conservation expectations. Snorkelers should ask about current conditions and entry points; divers should carry certification details and disclose their experience honestly.'
            ]),
            $section('The Eastern Province coast', [
                'Khobar and Dammam offer an easier coastal break for travelers already exploring the Eastern Region. Corniche areas, cafes and family-oriented facilities create a more urban beach day than the remote Red Sea experience. Visibility, water conditions and access differ by site, so avoid assuming that every shoreline is suitable for swimming.',
                'A Gulf itinerary works well with shopping and dining, especially in cooler months. Summer heat can make the middle of the day uncomfortable, so schedule outdoor time early or near sunset and carry more water than you think you need.'
            ]),
            $section('When to go and what to pack', [
                'For comfortable outdoor time, many travelers prefer the cooler period from late autumn through early spring. Red Sea water activities can follow a different seasonal pattern than city sightseeing. Check the forecast, wind and sea state for the exact coast you plan to visit.',
                'Pack reef-safe sun protection where appropriate, a rash guard, water shoes for rocky entries, a dry bag and modest cover-ups for moving between beach and public spaces. Bring identification and booking confirmation for organized excursions.'
            ]),
            $section('Responsible coastal travel', [
                'Do not touch coral, feed marine life or remove shells and fragments. Follow operator instructions around protected areas and dispose of waste properly. Ask before photographing other beach users, and check whether a facility has separate family or private access policies.',
                'The most beautiful coast is not always the most accessible. A responsible plan accepts weather cancellations and leaves fragile shorelines undisturbed rather than forcing an activity for the sake of a photograph.'
            ])
        ],
        'faq' => [
            ['question' => 'Where is the best base for Red Sea diving?', 'answer' => 'Jeddah is the most convenient major-city base, with certified operators arranging boat trips to reefs and offshore sites.'],
            ['question' => 'Are Saudi beaches free to enter?', 'answer' => 'Access varies by beach and facility. Some public waterfront areas are free, while resorts, clubs and organized trips charge separately. Check current policies before visiting.'],
            ['question' => 'What is the best season for a beach trip?', 'answer' => 'Cooler months are generally more comfortable for beach walks and coastal sightseeing, but marine conditions vary by coast and activity.']
        ],
        'related_articles' => ['jeddah-red-sea-diving-guide', 'jeddah-travel-guide', 'best-time-to-visit-saudi-arabia'],
    ],
    'saudi-arabia-7-day-itinerary' => [
        'seo_title' => 'Saudi Arabia in 7 Days: Realistic First Itinerary',
        'meta_description' => 'A realistic 7-day Saudi Arabia itinerary with Riyadh, AlUla, daily pacing, transport notes, meals and booking advice.',
        'primary_keyword' => 'Saudi Arabia 7 day itinerary',
        'secondary_keywords' => ['one week in Saudi Arabia', 'Saudi Arabia route', 'Riyadh AlUla itinerary'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/alula.svg',
        'intro' => 'Seven days is enough to see two sides of Saudi Arabia well, but not enough to cover every major region. This route uses Riyadh and AlUla because the combination gives first-time visitors museums, heritage, contemporary city life, ancient tombs and desert scenery without adding a third long transfer. It assumes you can use a domestic flight or a well-planned transfer and that you reserve time-sensitive experiences before arrival. Travelers who prefer the Red Sea can replace the final AlUla day with Jeddah, but should avoid trying to include all three regions at the same pace.',
        'sections' => [
            $section('Days 1-3: Riyadh', [
                'Day 1: arrive, settle in and keep the afternoon light. Visit the National Museum or another indoor cultural stop, then choose a Saudi dinner and early night. Arrival days are a poor time to schedule a remote excursion or a timed attraction that cannot be changed.',
                'Day 2: spend the morning in Diriyah and At-Turaif, with time for the surrounding heritage and dining areas. Rest during the hottest part of the day, then visit a skyline viewpoint or restaurant district after sunset. Day 3: choose Masmak Fortress and historic Riyadh, or use the day for a guided Edge of the World trip if weather and transport align.'
            ], ['Day 1: arrival and museum', 'Day 2: Diriyah and evening city views', 'Day 3: old Riyadh or desert excursion']),
            $section('Day 4: transfer to AlUla', [
                'Use a flight or confirmed transfer based on the current schedule. Once in AlUla, keep the first afternoon flexible: explore Old Town, walk through an oasis area or settle into the accommodation. The region is spread out, so a quiet orientation day prevents missed bookings later.',
                'Plan dinner around the operating calendar and carry a light layer for the evening. If you arrive late, do not force a major attraction; the desert landscape will still be there the next morning.'
            ]),
            $section('Days 5-6: Hegra and the landscape', [
                'Day 5: place your reserved Hegra visit in the morning or late afternoon according to the official slot. Allow time for transfers and the guided format, then use the remaining day for a relaxed meal or Old Town. Do not add another distant booking immediately after Hegra.',
                'Day 6: visit Elephant Rock, Jabal Ikmah or another confirmed cultural experience, then choose a sunset or stargazing activity. Select only what fits the conditions and your transport. AlUla is better experienced through fewer stops with time for the landscape.'
            ]),
            $section('Day 7 and route variations', [
                'Day 7: depart from AlUla if your flight allows, or return to Riyadh with a generous connection buffer. If you strongly prefer coast and food, replace one AlUla day with Jeddah, but accept that the route will feel more urban and less archaeological.',
                'Keep one backup plan for weather, delayed flights or attraction closures. Confirm every flight, transfer and timed entry shortly before departure because schedules and seasonal operations can change.'
            ])
        ],
        'faq' => [
            ['question' => 'Is seven days enough for Saudi Arabia?', 'answer' => 'Yes, for two regions. Riyadh and AlUla offer a balanced first trip; adding Jeddah creates a faster, more transfer-heavy itinerary.'],
            ['question' => 'Should I drive between Riyadh and AlUla?', 'answer' => 'The choice depends on your comfort, route and current road conditions. A domestic flight saves time; driving offers flexibility but consumes a significant portion of a day.'],
            ['question' => 'What should be booked first?', 'answer' => 'Book international and domestic transport, accommodation and timed Hegra or seasonal experiences before filling the daily schedule.']
        ],
        'related_articles' => ['alula-three-day-itinerary', 'riyadh-weekend-guide', 'saudi-arabia-transportation-guide', 'saudi-arabia-travel-cost-guide'],
    ],
    'alula-three-day-itinerary' => [
        'seo_title' => 'AlUla 3-Day Itinerary: Hegra, Old Town and Desert',
        'meta_description' => 'Use this practical three-day AlUla itinerary for Hegra, Old Town, Elephant Rock, oasis walks, desert views and realistic travel pacing.',
        'primary_keyword' => 'AlUla 3 day itinerary',
        'secondary_keywords' => ['AlUla itinerary', 'Hegra trip plan', 'things to do in AlUla'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/alula.svg',
        'intro' => 'AlUla is not a compact city break. Its archaeological sites, visitor zones and rock formations are distributed across an oasis and desert landscape, and several experiences operate through timed reservations or guided transport. Three days is enough for a meaningful introduction if Hegra is booked first and the rest of the schedule remains deliberately spacious. This plan balances heritage, scenery and evening atmosphere without pretending that every viewpoint can fit into one rushed loop.',
        'sections' => [
            $section('Day 1: Old Town and the oasis', [
                'Morning: arrive, collect your transfer or rental car and orient yourself around AlUla Old Town. Focus on the lanes, restored buildings, local craft and the relationship between the settlement and the oasis rather than trying to see every corner quickly.',
                'Afternoon: take a slower oasis walk or a confirmed cultural experience. Evening: visit Elephant Rock if access and transport align, then allow time for dinner. Sunset is popular, so confirm parking, shuttle and reservation details instead of assuming walk-in access.'
            ]),
            $section('Day 2: Hegra and Nabatean heritage', [
                'Morning: make Hegra the anchor booking. The guided format helps explain the tomb facades, inscriptions and landscape, but the heat and open exposure mean water, sun protection and comfortable footwear matter. Follow the guide\'s instructions and do not climb or touch archaeological features.',
                'Afternoon: rest during the hottest period, then choose a nearby museum, heritage stop or reserved experience. Evening: dine locally or book a stargazing session if the weather and moon conditions suit your plans.'
            ]),
            $section('Day 3: rock art, views and departure', [
                'Morning: consider Jabal Ikmah or another confirmed site connected with AlUla\'s inscriptions and cultural history. Check whether your chosen experience requires a guide or transport and leave a buffer before departure.',
                'Afternoon: use the oasis, Old Town or a quiet viewpoint for photography and reflection. If departing by air, confirm the transfer time and airport process; if driving onward, avoid scheduling a final remote activity too close to the road journey.'
            ]),
            $section('Booking and packing notes', [
                'Build the plan around official availability rather than a static list from an old blog. Hegra, seasonal events, shuttles and visitor zones can have different calendars. A local operator can simplify distances, but ask exactly what is included and where pickup occurs.',
                'Pack a hat, refillable water bottle, closed shoes, a light evening layer, power bank and modest clothing. Desert evenings can feel cool even after a hot day, and mobile coverage may vary outside developed visitor areas.'
            ])
        ],
        'faq' => [
            ['question' => 'Can Hegra be visited without a guide?', 'answer' => 'Access formats can change, but visitors should plan around the official reservation and tour system rather than assuming independent entry.'],
            ['question' => 'Do I need a car in AlUla?', 'answer' => 'A car or arranged transfer is useful because the main experiences are spread out. Confirm whether your accommodation provides shuttles.'],
            ['question' => 'How many nights should I stay?', 'answer' => 'Three nights gives the itinerary breathing room; two can work if transport is efficient and the Hegra booking is well timed.']
        ],
        'related_articles' => ['hegra-visitor-guide', 'saudi-arabia-7-day-itinerary', 'best-time-to-visit-saudi-arabia'],
    ],
    'riyadh-weekend-guide' => [
        'seo_title' => 'Riyadh Weekend Guide: A Practical 48-Hour Plan',
        'meta_description' => 'Spend 48 hours in Riyadh with a realistic weekend plan for Diriyah, museums, old Riyadh, skyline views, food and desert options.',
        'primary_keyword' => 'Riyadh weekend guide',
        'secondary_keywords' => ['Riyadh 48 hours', 'Riyadh itinerary', 'Riyadh city break'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'A Riyadh weekend works best when you organize it by geography and energy. Put heritage and outdoor walking in the cooler parts of the day, reserve the hottest hours for a museum or rest, and treat the evening as the city\'s prime time for dining and views. The plan below assumes two full sightseeing days. Adjust the order for attraction closures, prayer times, weather and any event schedule operating during your visit.',
        'sections' => [
            $section('Day 1: Diriyah, museum and evening dining', [
                'Morning: begin in Diriyah and At-Turaif, allowing time for architecture, interpretation and the surrounding visitor district. Wear comfortable shoes and check the current ticketing or reservation process before leaving the hotel.',
                'Afternoon: visit the National Museum or another indoor cultural venue, then rest. Evening: choose a restaurant or cafe district and add a skyline view if visibility is good. This pacing avoids making the first day a sequence of long cross-city transfers.'
            ]),
            $section('Day 2: old Riyadh or the desert', [
                'Morning: explore Masmak Fortress and the historic centre, or substitute a guided desert trip if that is your priority. Edge of the World is not a casual taxi ride: verify operator safety, vehicle, weather policy, pickup and return time.',
                'Afternoon: have lunch, shop for local products or visit a gallery. Evening: finish with Saudi dishes, Arabic coffee or a contemporary dining experience. Keep your final airport transfer separate from the sightseeing schedule.'
            ]),
            $section('Where to stay and how to move', [
                'Choose accommodation based on your evening plans and transfer needs rather than assuming the centre of the map is the best base. Ride-hailing works for major stops, while a rental car gives flexibility but adds parking and navigation decisions.',
                'Riyadh roads can make short distances slow at peak times. Group Diriyah stops together, group central heritage stops together and build a buffer around any timed booking.'
            ]),
            $section('What to reserve', [
                'Reserve popular restaurants, timed heritage experiences, seasonal events and desert tours in advance during busy periods. Use current official listings for hours and access; old travel pages often describe an earlier operating model.',
                'A weekend is enough to understand Riyadh, not to exhaust it. Leave one optional block rather than overfilling every hour.'
            ])
        ],
        'faq' => [
            ['question' => 'Is two days enough for Riyadh?', 'answer' => 'Two full days covers the headline heritage, museum and dining experiences. Add a third day for a desert excursion or slower city exploration.'],
            ['question' => 'What is the best area to visit in the evening?', 'answer' => 'The best choice depends on current restaurants and events; use official venue listings and group the evening with nearby sightseeing to reduce traffic.'],
            ['question' => 'Can I do Edge of the World in half a day?', 'answer' => 'Treat it as a substantial excursion with transfers, weather contingencies and time at the site. Confirm the return time with the operator.']
        ],
        'related_articles' => ['things-to-do-riyadh', 'saudi-arabia-transportation-guide', 'saudi-food-guide'],
    ],
    'best-time-to-visit-saudi-arabia' => [
        'seo_title' => 'Best Time to Visit Saudi Arabia by Region and Season',
        'meta_description' => 'Find the best time to visit Saudi Arabia by region, with weather, summer strategy, events, Ramadan planning and packing advice.',
        'primary_keyword' => 'best time to visit Saudi Arabia',
        'secondary_keywords' => ['Saudi Arabia weather', 'Saudi travel seasons', 'when to visit Saudi Arabia'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'For many first-time visitors, October through March is the easiest period for Saudi Arabia: city walks, desert excursions and heritage sites are more comfortable than in the hottest part of the year. That is not a universal rule. The Red Sea, highlands, eastern coast and northern desert have different conditions, and a summer trip can still work with an indoor-focused schedule. This guide compares seasons by region and explains how Ramadan, events and heat should influence planning.',
        'sections' => [
            $section('Best months by region', [
                'Riyadh and the central desert are most comfortable for outdoor sightseeing in the cooler months. Jeddah and the Red Sea coast are also easier for walking and marine activities from late autumn into spring, although water and wind conditions need separate checking. AlUla benefits from cool-season planning because many experiences are outdoors.',
                'Abha and the Asir highlands can be a useful warm-season alternative, with a different climate and occasional rain. Taif similarly offers highland relief. Conditions can change quickly in the mountains, so pack layers even when the wider country is hot.'
            ]),
            $section('Summer travel strategy', [
                'Summer heat is serious in many lowland areas. Plan outdoor visits at sunrise or after sunset, use museums and shopping centres in the middle of the day, and avoid treating a long desert excursion as an automatic summer activity. Hydration, shade and rest need to be part of the itinerary rather than emergency additions.',
                'Summer can bring lower demand for some hotels, but attraction schedules and outdoor experiences may be reduced. Check current operations before assuming a saving is worth the compromise.'
            ]),
            $section('Ramadan and event calendars', [
                'During Ramadan, routines change: restaurants may open later, some venues alter hours and evenings can become especially lively. Non-Muslim visitors should be respectful about eating, drinking and smoking in public during daylight hours and should confirm local guidance before travel.',
                'Large cultural and entertainment events can transform availability and prices. They may be the reason to visit, but book accommodation and transport early and use the organizer\'s current calendar rather than a recycled date.'
            ]),
            $section('What to pack for the season', [
                'Pack breathable, modest clothing, sun protection, comfortable closed shoes and a refillable water bottle. Add a light jacket for air-conditioned interiors and desert evenings; highland trips need more layers. A scarf or shawl is useful for sun, dust and respectful coverage.',
                'Check the forecast for every region on your route. A national average hides major differences between the coast, capital, mountains and desert.'
            ])
        ],
        'faq' => [
            ['question' => 'What are the best months for a first visit?', 'answer' => 'October through March is generally the most comfortable starting point for central cities, heritage sites and desert activities, subject to regional weather.'],
            ['question' => 'Can I visit Saudi Arabia in summer?', 'answer' => 'Yes, but plan around heat with early starts, indoor midday activities, hydration and careful checks of outdoor tour operations.'],
            ['question' => 'Does Ramadan affect tourists?', 'answer' => 'It can affect opening hours, meal times and daily rhythm. Visitors should research the dates and observe local etiquette.']
        ],
        'related_articles' => ['saudi-arabia-travel-guide-2026', 'saudi-arabia-7-day-itinerary', 'saudi-culture-customs-travelers'],
    ],
    'saudi-arabia-visa-guide' => [
        'seo_title' => 'Saudi Arabia Visa Guide 2026: Requirements and Process',
        'meta_description' => 'Understand Saudi tourist visa planning, eVisa checks, documents, insurance, religious travel distinctions and official verification.',
        'primary_keyword' => 'Saudi Arabia visa guide',
        'secondary_keywords' => ['Saudi tourist visa', 'Saudi eVisa requirements', 'Saudi entry requirements'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Saudi visa rules depend on nationality, passport, purpose of travel and sometimes the season. Tourist entry, business travel, transit and religious pilgrimage are not interchangeable categories. This guide explains how to prepare and what to verify, but it is not a substitute for the official Saudi visa portal, embassy or consulate. Do not book a non-refundable trip on the assumption that a rule described in an old article still applies in 2026.',
        'sections' => [
            $section('Start with the official eligibility check', [
                'Use the current official Saudi government visa service to check whether your nationality can apply online, through an embassy or through another approved channel. Confirm passport validity, photograph requirements, insurance conditions, permitted activities and the number of entries shown on the issued document.',
                'Avoid relying on a third-party summary for a final decision. Names, passport details and dates must match exactly, and processing times can change around holidays, events and pilgrimage seasons.'
            ]),
            $section('Documents and application preparation', [
                'Prepare a passport with sufficient validity, a compliant digital photograph, accommodation or address details when requested, travel dates and a payment method accepted by the official portal. Keep the approval notice accessible offline and carry the same passport used for the application.',
                'Travel insurance, health documents and onward travel evidence may be requested depending on the current rules and your case. Print copies for border or airline questions, but remember that an approval does not override entry decisions or changing public-health measures.'
            ]),
            $section('Tourist travel versus Hajj and Umrah', [
                'A tourist visa is not automatically permission to perform every religious journey or enter every restricted area. Hajj has its own quotas, permits and licensed arrangements. Umrah procedures, timing and booking systems can also change. Pilgrims should use official Ministry channels and licensed providers.',
                'Makkah and Madinah also have location-specific access expectations. Check current rules for non-Muslim visitors and religious sites before building a route that includes them.'
            ]),
            $section('After approval and at the border', [
                'Check the visa validity window, permitted stay, entry points and any conditions immediately after approval. Airlines can apply document checks before boarding, so keep confirmation numbers and insurance details available.',
                'At entry, answer questions accurately and follow instructions. A visa is permission to request entry, not a guarantee that every planned activity is available. Save emergency and embassy contacts before departure.'
            ])
        ],
        'faq' => [
            ['question' => 'Can every nationality get a Saudi eVisa?', 'answer' => 'Eligibility varies. Check the current official Saudi visa portal or your embassy rather than relying on a static list.'],
            ['question' => 'Is a tourist visa the same as an Umrah visa?', 'answer' => 'They are separate travel purposes with rules that can change. Pilgrims should verify current official requirements and permits.'],
            ['question' => 'How early should I apply?', 'answer' => 'Apply with enough time for processing or correction requests, especially before peak seasons, but use the current official guidance for expected timing.']
        ],
        'related_articles' => ['hajj-umrah-guide', 'saudi-arabia-travel-guide-2026', 'saudi-culture-customs-travelers'],
    ],
    'is-saudi-arabia-safe' => [
        'seo_title' => 'Is Saudi Arabia Safe for Tourists? Practical Advice',
        'meta_description' => 'A practical Saudi Arabia safety guide covering transport, heat, desert trips, laws, health, scams, emergencies and respectful travel.',
        'primary_keyword' => 'is Saudi Arabia safe for tourists',
        'secondary_keywords' => ['Saudi Arabia travel safety', 'Saudi tourist safety tips', 'Saudi travel advice'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/jeddah.svg',
        'intro' => 'Many visitors travel through Saudi Arabia without serious incident, particularly when using established city services and reputable tour operators. Safety still depends on preparation: distances are large, summer heat is demanding, road behaviour can feel unfamiliar and local laws differ from those in a traveler\'s home country. This guide separates ordinary precautions from issues that deserve particular attention, while advising every visitor to read current government travel guidance before departure.',
        'sections' => [
            $section('Everyday city safety', [
                'Use official taxis or established ride-hailing services, keep valuables secure and check that accommodation doors and transport arrangements are clear. Crowded markets and events call for the same awareness used in any large city. Share your hotel and excursion details with someone at home.',
                'Carry identification as required, save emergency numbers and keep a small offline note with your accommodation address. If a situation feels unclear, ask hotel staff or an official information desk rather than accepting help from an unverified intermediary.'
            ]),
            $section('Roads, heat and remote areas', [
                'Road safety is one of the most important practical concerns. Avoid fatigued driving, leave generous time, use seatbelts and do not assume that a short map distance means a quick trip. Remote desert and mountain routes require fuel, water, navigation backup and a clear return plan.',
                'Heat illness can develop quickly. Schedule shade and water breaks, cover exposed skin, and move indoor when conditions become unsafe. For Edge of the World, AlUla and similar excursions, follow the operator around cliffs, vehicles and weather cancellations.'
            ]),
            $section('Local laws and respectful conduct', [
                'Dress modestly in public, ask before photographing people and avoid photographing government, military or sensitive infrastructure. Alcohol is prohibited, and public behaviour that is ordinary elsewhere can have legal consequences. Read current official guidance rather than relying on assumptions.',
                'Religious sites and pilgrimage areas require additional respect and may have access rules based on faith, permit or time. Do not enter restricted areas or treat religious observance as a photo opportunity.'
            ]),
            $section('Health and emergency planning', [
                'Arrange travel insurance that covers your activities and any medical needs. Carry prescriptions in original packaging and check whether medication documentation is needed. Heat, dehydration, road journeys and food changes are more common practical problems than dramatic incidents.',
                'In an emergency, contact the relevant local service, your accommodation and your embassy as appropriate. Follow current government advisories, register travel if your country offers that service and reconsider remote plans when official warnings or severe weather apply.'
            ])
        ],
        'faq' => [
            ['question' => 'Is Saudi Arabia safe for solo travelers?', 'answer' => 'Many solo visitors travel successfully, especially in major cities. Share plans, choose reputable transport and take extra care with remote excursions and heat.'],
            ['question' => 'What is the biggest practical safety concern?', 'answer' => 'Road travel and heat deserve the most planning. Use seatbelts, avoid tired driving, carry water and follow excursion safety instructions.'],
            ['question' => 'Do tourists need to follow dress rules?', 'answer' => 'Visitors should dress modestly in public and take extra care around religious places. Check current official guidance for the locations on your route.']
        ],
        'related_articles' => ['saudi-culture-customs-travelers', 'saudi-arabia-transportation-guide', 'renting-car-saudi-arabia'],
    ],
    'saudi-arabia-transportation-guide' => [
        'seo_title' => 'Saudi Arabia Transportation Guide: Flights, Cars and Taxis',
        'meta_description' => 'Learn how to get around Saudi Arabia by domestic flight, train, car, bus, taxi and ride-hailing service with practical planning tips.',
        'primary_keyword' => 'Saudi Arabia transportation guide',
        'secondary_keywords' => ['getting around Saudi Arabia', 'Saudi domestic flights', 'Saudi public transport'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Transport planning determines the quality of a Saudi Arabia itinerary because the country\'s major destinations are far apart. Domestic flights are usually the fastest option between Riyadh, Jeddah, AlUla and other major hubs. Cars are useful for AlUla, Abha and regional exploration, while ride-hailing fills the gap inside large cities. This guide compares each option and explains how to build buffers for traffic, airport transfers, prayer times, weather and long distances.',
        'sections' => [
            $section('Domestic flights and airports', [
                'Flying is usually the sensible choice when a road transfer would remove a full day from a short itinerary. Compare airport locations, baggage rules, arrival times and the cost of the final transfer rather than looking only at the ticket price.',
                'Avoid placing a non-refundable timed attraction immediately after landing. Delays, baggage and ground transport can turn a reasonable connection into a stressful one, particularly in AlUla where visitor zones are spread out.'
            ]),
            $section('Driving and rental cars', [
                'A car provides independence outside the largest city centres and is particularly helpful for AlUla, Asir and the Eastern Region. Confirm licence requirements, insurance, deposits, fuel policy, mileage limits and whether the vehicle is suitable for your route before collecting it.',
                'Use navigation as a planning aid, not a replacement for road judgment. Fill the tank before remote drives, carry water and avoid night driving on unfamiliar mountain or desert roads when conditions are uncertain.'
            ]),
            $section('Ride-hailing, taxis and buses', [
                'Ride-hailing apps operate in major cities and are often simpler than negotiating an unfamiliar street taxi. Verify the vehicle and destination before departure, and keep the hotel address in Arabic or on a map for clarity.',
                'Urban and intercity bus networks can be useful for budget travelers, but routes and schedules change. Check the current operator timetable and station location. They are not always the best fit for a multi-stop sightseeing day.'
            ]),
            $section('Trains, transfers and accessibility', [
                'Rail can be useful on supported corridors, including routes associated with western-region travel, but confirm the current timetable and station transfer before booking. Pilgrimage travel has additional demand and operational rules.',
                'Travelers with mobility needs should ask airlines, hotels, stations and tour operators about step-free access, vehicle type, seating and surface conditions in advance. Desert and heritage sites can have uneven terrain even when visitor facilities are developed.'
            ])
        ],
        'faq' => [
            ['question' => 'Is public transport available in Saudi Arabia?', 'answer' => 'Major cities have buses, ride-hailing and taxis, with rail or coach services on selected routes. Coverage and schedules vary, so check the current operator.'],
            ['question' => 'Should I rent a car in Riyadh?', 'answer' => 'A rental car helps with flexibility but is not essential for every city itinerary. Ride-hailing can be easier for central sightseeing and evening dining.'],
            ['question' => 'What is the best way to reach AlUla?', 'answer' => 'Compare current flights, road transfers and onward logistics. Once there, arrange a car, shuttle or operator because attractions are spread across the region.']
        ],
        'related_articles' => ['renting-car-saudi-arabia', 'saudi-arabia-7-day-itinerary', 'is-saudi-arabia-safe'],
    ],
    'renting-car-saudi-arabia' => [
        'seo_title' => 'Renting a Car in Saudi Arabia: Requirements and Tips',
        'meta_description' => 'Plan a Saudi Arabia car rental with licence, insurance, fuel, driving, navigation, remote-road and pickup advice.',
        'primary_keyword' => 'renting a car in Saudi Arabia',
        'secondary_keywords' => ['driving in Saudi Arabia', 'Saudi car rental requirements', 'Saudi road trip'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/alula.svg',
        'intro' => 'Renting a car can make Saudi Arabia much easier to explore, especially in AlUla, Asir and areas beyond a city centre. It also adds responsibility: visitors must understand licence rules, insurance exclusions, local driving style, fuel planning and the limits of their vehicle. This guide is a preparation checklist, not legal advice. Confirm requirements with the rental company and official authorities before travel because policies vary by nationality and can change.',
        'sections' => [
            $section('Before you reserve', [
                'Ask the rental company which passport, home-country licence and international driving permit they accept, and whether the driver must be a particular age. Confirm the exact deposit, payment card requirement, insurance excess, roadside assistance and additional-driver policy in writing.',
                'Choose the vehicle for the route rather than the photograph. A compact car is fine for city roads, while remote desert or mountain plans may require a suitable vehicle and an experienced driver. Never assume that a rental agreement allows off-road use.'
            ]),
            $section('Pickup, inspection and insurance', [
                'At pickup, photograph all sides of the vehicle, wheels, windscreen, fuel level and odometer. Confirm how damage is recorded and where to return the car. Keep the contract, emergency number and roadside procedure offline.',
                'Understand what insurance covers and what it excludes. Tires, glass, underbody damage, floodwater and unauthorized roads may be treated differently. If anything is unclear, resolve it before leaving the desk.'
            ]),
            $section('Driving on cities and highways', [
                'Saudi highways can make long-distance travel efficient, but traffic, lane changes and speed differences demand attention. Use seatbelts, obey posted limits, avoid phone use and take breaks before fatigue arrives. Do not plan a full sightseeing day after a long overnight drive.',
                'In cities, parking and congestion can be more challenging than the road itself. Use hotel parking guidance and allow time for large venues. Navigation apps are valuable, but check the route before starting rather than making last-second lane decisions.'
            ]),
            $section('Desert, mountain and emergency planning', [
                'Remote travel needs fuel, water, a charged phone, offline maps and a person who knows your route. Check weather and road conditions, avoid isolated tracks without the right vehicle and follow local advice. Mountain fog, rain and flash flooding can change conditions quickly.',
                'If there is an accident or breakdown, move to a safe position when possible, contact the rental company and local emergency services, and do not abandon passengers in heat. Document the scene as safely as possible for the insurer.'
            ])
        ],
        'faq' => [
            ['question' => 'Do I need an international driving permit?', 'answer' => 'Requirements depend on your nationality and rental provider. Confirm the accepted documents before travel rather than assuming a home licence is enough.'],
            ['question' => 'Is driving in Saudi Arabia difficult?', 'answer' => 'Main roads are often straightforward, but city traffic, long distances and remote routes require concentration and conservative planning.'],
            ['question' => 'Can a normal rental car drive to desert attractions?', 'answer' => 'Only if the road and rental agreement allow it. Use a suitable vehicle or an experienced operator for remote terrain and never improvise off-road travel.']
        ],
        'related_articles' => ['saudi-arabia-transportation-guide', 'is-saudi-arabia-safe', 'alula-three-day-itinerary'],
    ],
    'saudi-food-guide' => [
        'seo_title' => 'Saudi Food Guide: Dishes, Regions and Dining Tips',
        'meta_description' => 'Explore Saudi food through kabsa, jareesh, mutabbaq, dates, coffee, seafood and regional dining advice for travelers.',
        'primary_keyword' => 'Saudi food guide',
        'secondary_keywords' => ['Saudi dishes to try', 'Saudi cuisine', 'what to eat in Saudi Arabia'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/jeddah.svg',
        'intro' => 'Food is one of the quickest ways to notice the differences between Saudi regions. Rice and meat dishes are familiar starting points, but the table also includes breads, soups, dates, seafood, fermented flavours, sweets and the ritual of Arabic coffee. Travelers do not need to memorize a menu to eat well: learn a few dishes, ask about ingredients and choose dining settings that fit the pace of the day. This guide covers what to try, where regional differences appear and how to dine respectfully.',
        'sections' => [
            $section('Dishes and ingredients to look for', [
                'Kabsa is a well-known rice dish often served with meat or chicken, but preparation differs by household and restaurant. Jareesh, saleeg, matazeez, mutabbaq and different breads offer a wider view of local comfort food. Dates and Arabic coffee are central to hospitality, while cardamom and saffron may shape the aroma of a meal.',
                'Ask whether a dish contains nuts, dairy, wheat or seafood if you have allergies. Halal food is standard, but cross-contact and preparation still matter. A translation app or a written allergy card can help with complex needs.'
            ]),
            $section('Regional food experiences', [
                'Jeddah is a strong place to explore seafood and the influence of Red Sea trade, as well as restaurants in and around Al-Balad. Riyadh offers traditional Saudi meals alongside ambitious contemporary venues. The Asir region has its own dishes, grains and presentation styles, while the Eastern Province reflects coastal and international influences.',
                'In AlUla, combine a local meal with the landscape rather than expecting every restaurant to serve the same range as a capital city. Seasonal events may add temporary food markets, so confirm dates and opening times.'
            ]),
            $section('How to choose restaurants', [
                'Casual local restaurants can be the best introduction because the menu is focused and the turnover is high. Markets and food districts are useful for sampling, while reservation-led restaurants suit travelers who want a longer evening. Look for recent official information rather than assuming a venue still operates under an old name.',
                'Meal times can shift during Ramadan and holidays. Some venues are family-oriented or have separate seating arrangements. Follow the staff\'s guidance and do not photograph diners without permission.'
            ]),
            $section('Coffee, hospitality and etiquette', [
                'Arabic coffee is commonly offered in small cups and may be accompanied by dates. Accepting a small serving is a gracious way to participate, while politely indicating that you have had enough is understood. Eat with the right hand when sharing a traditional meal and wait for the host when appropriate.',
                'Food is social, so leave room in the schedule for conversation. The most useful recommendation may come from a host, guide or restaurant staff member who knows what is fresh that day.'
            ])
        ],
        'faq' => [
            ['question' => 'What Saudi dish should I try first?', 'answer' => 'Kabsa is an accessible starting point, but ask about regional dishes such as jareesh, saleeg or local seafood to move beyond the most familiar example.'],
            ['question' => 'Is Saudi food spicy?', 'answer' => 'Heat varies by dish and region. Ask the restaurant about spice level and ingredients rather than assuming every rice or stew is hot.'],
            ['question' => 'Can vegetarians eat well in Saudi Arabia?', 'answer' => 'Yes, with planning. Mezze, breads, rice, salads, falafel and vegetable dishes are common, but confirm stock, sauces and preparation.']
        ],
        'related_articles' => ['saudi-culture-customs-travelers', 'saudi-arabia-shopping-guide', 'things-to-do-riyadh', 'saudi-arabia-travel-guide-2026'],
    ],
    'saudi-culture-customs-travelers' => [
        'seo_title' => 'Saudi Culture and Customs: A Traveler\'s Guide',
        'meta_description' => 'Learn how to travel respectfully in Saudi Arabia with guidance on dress, greetings, photography, prayer times, hospitality and etiquette.',
        'primary_keyword' => 'Saudi culture and customs',
        'secondary_keywords' => ['Saudi Arabia etiquette', 'what to wear in Saudi Arabia', 'Saudi travel customs'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Travel in Saudi Arabia is more comfortable when visitors approach local customs with attention rather than anxiety. Dress modestly, ask before photographing people, understand that prayer and family routines shape the day, and accept that rules can differ between a public street, a heritage site, a restaurant and a mosque. The country is changing quickly, but respect remains a practical travel skill. This guide covers ordinary public etiquette and flags areas where current official guidance matters more than any general summary.',
        'sections' => [
            $section('Dress and public behaviour', [
                'Visitors should choose loose, modest clothing that covers shoulders and knees in public. Women travelers are not generally expected to wear an abaya everywhere, but local guidance can be stricter at religious sites or particular venues. Men should also avoid very short or revealing clothing.',
                'Public affection, loud confrontations and disrespectful gestures can create problems. Keep voices calm, follow venue instructions and remember that a photograph or joke that feels harmless to a traveler may be sensitive in its local context.'
            ]),
            $section('Greetings and hospitality', [
                'A greeting such as "as-salamu alaykum" is appreciated. Handshakes and other contact depend on the people involved; let the other person set the tone, especially across genders. A warm welcome may include coffee, dates or a meal, and refusing brusquely can feel uncomfortable.',
                'Hospitality is not a transaction. Ask before entering private spaces, return kindness with thanks and do not assume an invitation to photograph a home, family member or gathering.'
            ]),
            $section('Prayer times, Ramadan and public spaces', [
                'Businesses and routines may pause around prayer, and schedules can be especially different during Ramadan. Plan with flexibility, keep noise low near mosques and avoid eating, drinking or smoking in public during daylight in Ramadan unless local guidance clearly permits it.',
                'Religious sites have their own access, dress and photography rules. Check official instructions, obey barriers and never treat worshippers as background for a travel photograph.'
            ]),
            $section('Photography, gender and family spaces', [
                'Ask permission before photographing people, including vendors and children. Avoid government, military, airport and other sensitive facilities. Some venues have family or gender-specific arrangements; follow staff instructions without making assumptions from an old guide.',
                'When unsure, watch how local visitors use a space or ask politely. Cultural curiosity is welcome when it is paired with consent and restraint.'
            ])
        ],
        'faq' => [
            ['question' => 'What should tourists wear in Saudi Arabia?', 'answer' => 'Wear loose, modest clothing covering shoulders and knees in public, with extra care around religious places and local venue requirements.'],
            ['question' => 'Can tourists photograph people?', 'answer' => 'Ask permission first and avoid photographing children, private spaces or sensitive facilities without clear consent.'],
            ['question' => 'Is English widely understood?', 'answer' => 'English is common in tourism, hotels and many businesses, but a few Arabic greetings and a translation tool are helpful outside those settings.']
        ],
        'related_articles' => ['saudi-food-guide', 'saudi-arabia-visa-guide', 'hajj-umrah-guide', 'is-saudi-arabia-safe'],
    ],
    'hegra-visitor-guide' => [
        'seo_title' => 'Hegra Visitor Guide: UNESCO Site in AlUla',
        'meta_description' => 'Plan a Hegra visit in AlUla with history, reservations, transport, what to wear, photography, etiquette and realistic timing.',
        'primary_keyword' => 'Hegra visitor guide',
        'secondary_keywords' => ['Hegra UNESCO site', 'Mada in Saleh guide', 'AlUla Hegra tour'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/alula.svg',
        'intro' => 'Hegra, also known as Mada\'in Salih, is the first Saudi site inscribed on the UNESCO World Heritage List. Its significance comes from the combination of Nabatean tomb architecture, inscriptions, trade history and the dramatic desert setting around it. A visit is more than a drive to photograph one facade: access, interpretation, transport and heat all shape the experience. Plan around the current official reservation system and treat the archaeological landscape with care.',
        'sections' => [
            $section('Why Hegra matters', [
                'The site preserves monumental tombs and other remains associated with the Nabatean kingdom, which connected parts of the Arabian Peninsula and wider trade routes. The carved facades show how architecture, status, belief and geology met in one place.',
                'A guide adds essential context because the meaning is not always obvious from the rock face. Listen for the difference between a completed tomb facade, an unfinished carving, an inscription and the natural features that surround it.'
            ]),
            $section('Reservations and arrival', [
                'Check the official AlUla visitor platform for current dates, time slots, transport format and identification requirements. Availability can change seasonally. Do not build a tight second booking directly after Hegra because transfers and guided groups take time.',
                'Arrange transport from your accommodation or visitor hub in advance. Independent driving may get you to the general area, but it does not necessarily provide access to every site or replace the official tour format.'
            ]),
            $section('What to bring and how to behave', [
                'Wear closed, comfortable shoes, a hat and breathable modest clothing. Bring water, sun protection and a charged phone, while keeping bags manageable for vehicles and walking. Desert evenings can be cool, so carry a light layer.',
                'Stay on marked routes, do not touch or climb tombs, and follow instructions about photography and drones. Avoid collecting stones or fragments. Archaeological preservation is part of the visitor experience, not a restriction to work around.'
            ]),
            $section('Pairing Hegra with AlUla', [
                'Place Hegra at the centre of a two- or three-day AlUla stay. Use another day for Old Town, the oasis, Elephant Rock or Jabal Ikmah, depending on current availability. This gives the ancient site room to make sense instead of turning it into a rushed stop between flights.',
                'The best photography often depends on light, dust and patience. Follow the guide\'s safe viewpoints and let the landscape provide scale rather than seeking an unsafe angle.'
            ])
        ],
        'faq' => [
            ['question' => 'How long should I allow for Hegra?', 'answer' => 'Allow the full duration shown by the official tour or reservation, plus transfers and a buffer. It is not a quick roadside stop.'],
            ['question' => 'Can I visit Hegra independently?', 'answer' => 'Access arrangements can change. Plan around the current official reservation and tour information rather than assuming open independent entry.'],
            ['question' => 'What is Hegra also called?', 'answer' => 'Hegra is also known as Mada\'in Salih, a historical name widely used in travel and heritage references.']
        ],
        'related_articles' => ['alula-three-day-itinerary', 'best-places-to-visit-saudi-arabia', 'saudi-arabia-7-day-itinerary'],
    ],
    'jeddah-red-sea-diving-guide' => [
        'seo_title' => 'Jeddah Red Sea Diving and Snorkeling Guide',
        'meta_description' => 'Plan Red Sea diving and snorkeling from Jeddah with operator checks, seasons, equipment, marine etiquette and beginner advice.',
        'primary_keyword' => 'Jeddah Red Sea diving',
        'secondary_keywords' => ['Saudi Red Sea snorkeling', 'Jeddah dive trips', 'Red Sea coral reefs'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/jeddah.svg',
        'intro' => 'The Red Sea around Jeddah appeals to experienced divers, first-time snorkelers and travelers who simply want a day on the water. Coral reefs, visibility and marine life are the draw, but the quality of a trip depends heavily on the operator, sea conditions, equipment and transfer logistics. This guide explains how to choose an excursion without inventing fixed site promises: reefs, wrecks, schedules and access can vary by season and weather.',
        'sections' => [
            $section('Choosing a dive or snorkel operator', [
                'Look for clear information about certification requirements, boat safety, group size, equipment rental, insurance, food, transfers and cancellation policy. Certified dive professionals should ask about your experience and last dive rather than pushing every guest into the same plan.',
                'Read recent reviews for operational details, not just underwater photographs. Confirm the marina or pickup point, departure time and whether the boat returns before dark. A cheap trip that hides equipment or weather conditions is not good value.'
            ]),
            $section('Beginners, families and experienced divers', [
                'Beginners should choose a shallow, supervised experience and be honest about comfort in open water. Snorkelers need flotation support if they are not confident swimmers, and children require close adult supervision even in calm conditions.',
                'Certified divers should carry their certification card, log information if requested and explain any medical or depth limitations. Wrecks, current and remote sites are not appropriate for every diver, and the guide\'s decision should be final.'
            ]),
            $section('Seasons, packing and sea conditions', [
                'Cooler months can be comfortable for boat travel, while the best day depends on wind, visibility and local sea state rather than the calendar alone. Operators may cancel or change a route for safety; build flexibility into the itinerary.',
                'Bring swimwear that suits the operator\'s guidance, reef-safe sun protection, a dry bag, motion-sickness medication if needed and a spare layer for the boat ride. Follow instructions about cameras, fins and entry points.'
            ]),
            $section('Protecting the Red Sea', [
                'Never stand on coral, chase wildlife, feed fish or remove shells. Keep buoyancy under control and use established moorings. A good operator explains conservation because healthy reefs are the reason the experience exists.',
                'Ask before photographing other guests and respect local marine rules. Leave no plastic or food waste behind, and report damaged equipment or unsafe practices to the operator.'
            ])
        ],
        'faq' => [
            ['question' => 'Do I need a diving certificate in Jeddah?', 'answer' => 'Certification is generally relevant to scuba dives, while supervised beginner and snorkeling experiences have different requirements. Confirm with the operator.'],
            ['question' => 'Can I snorkel as a non-swimmer?', 'answer' => 'Only with appropriate flotation, supervision and an operator willing to support your ability. Be honest about your confidence before boarding.'],
            ['question' => 'What happens if the sea is rough?', 'answer' => 'A responsible operator may delay, change the route or cancel. Safety and marine conditions should take priority over a fixed itinerary.']
        ],
        'related_articles' => ['best-beaches-saudi-arabia', 'saudi-arabia-transportation-guide', 'saudi-culture-customs-travelers'],
    ],
    'saudi-arabia-travel-cost-guide' => [
        'seo_title' => 'Saudi Arabia Travel Cost Guide: Daily Budgets',
        'meta_description' => 'Estimate Saudi Arabia trip costs for budget, mid-range and luxury travel, including hotels, food, transport and attractions.',
        'primary_keyword' => 'Saudi Arabia travel cost',
        'secondary_keywords' => ['Saudi Arabia daily budget', 'cost of travel in Saudi Arabia', 'Saudi trip budget'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/riyadh.svg',
        'intro' => 'Saudi Arabia travel costs vary more by city, season and transport style than by a single national price. A local meal and ride-hailing trip can be manageable, while a peak-season hotel, domestic flight, private desert excursion or premium restaurant quickly changes the total. Use this guide as a planning framework rather than a promise of fixed prices. Check current rates for your dates, and separate unavoidable transport from optional experiences when building a budget.',
        'sections' => [
            $section('Three useful budget levels', [
                'A budget trip uses simple accommodation, local restaurants, public or shared transport and a smaller number of paid attractions. A mid-range trip adds comfortable hotels, domestic transport and several organized experiences. Luxury travel is shaped by premium accommodation, private transfers, high-end dining and exclusive excursions.',
                'The most useful first step is to price your actual route: number of hotel nights, flights, car days, major bookings and daily meals. A national daily average can hide the cost of a single long transfer.'
            ], ['Budget: simple room, local meals, limited paid tours', 'Mid-range: comfortable hotel, flights or rental car, selected experiences', 'Luxury: premium stays, private transfers, fine dining and bespoke tours']),
            $section('Accommodation and food', [
                'Hotel rates change sharply around events, holidays and peak desert season. Compare location as well as room price: a cheaper hotel far from the activity may add daily transport and time. Confirm taxes, breakfast, cancellation terms and any deposit.',
                'Food offers the widest range of choices. Local restaurants, bakeries and cafes can keep daily spending controlled, while hotel dining and destination restaurants require more planning. Budget for water, coffee, snacks and occasional meals near major attractions.'
            ]),
            $section('Transport and attractions', [
                'Domestic flights, airport transfers and car rental can become the largest line after accommodation. Compare the cost of a flight with fuel, tolls, rental days and a hotel night lost to a long drive. In cities, ride-hailing is easier to budget when you group nearby stops.',
                'Attraction pricing and access models vary. Some public areas are free, while heritage sites, guided tours, water activities and seasonal events charge separately. Check official booking pages and include service fees, equipment, transfers and tips where applicable.'
            ]),
            $section('Ways to save without weakening the trip', [
                'Travel in a shoulder period, stay near a cluster of activities, book cancellable accommodation early and use local meals for some days. Choose one or two paid experiences that matter most instead of buying every optional add-on.',
                'Keep a contingency for weather changes, delayed transport, extra water, medical needs and a final airport transfer. A realistic buffer is more useful than a budget that works only if nothing changes.'
            ])
        ],
        'faq' => [
            ['question' => 'How much should I budget per day in Saudi Arabia?', 'answer' => 'It depends on accommodation and transport. Build a route-specific budget rather than trusting one national figure, then add a contingency for activities and transfers.'],
            ['question' => 'Is Saudi Arabia expensive for food?', 'answer' => 'Food ranges from affordable local meals to premium dining. Travelers can control costs by mixing casual restaurants, bakeries and cafes with selected special meals.'],
            ['question' => 'What is usually the biggest expense?', 'answer' => 'Accommodation and intercity transport are often the largest costs, especially in peak periods or on multi-region itineraries.']
        ],
        'related_articles' => ['saudi-arabia-7-day-itinerary', 'saudi-arabia-transportation-guide', 'saudi-arabia-shopping-guide'],
    ],
    'saudi-arabia-shopping-guide' => [
        'seo_title' => 'Saudi Arabia Shopping Guide: Souks, Malls and Gifts',
        'meta_description' => 'Find Saudi souvenirs and shopping experiences in Riyadh, Jeddah and the Asir region, from souks and oud to modern malls.',
        'primary_keyword' => 'Saudi Arabia shopping guide',
        'secondary_keywords' => ['Saudi souvenirs', 'Riyadh shopping', 'Jeddah souks', 'what to buy in Saudi Arabia'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/jeddah.svg',
        'intro' => 'Shopping in Saudi Arabia ranges from historic markets and specialist fragrance shops to modern malls with international brands. The most meaningful purchases are often connected to a region: oud and perfume, dates, coffee, textiles, baskets, ceramics or contemporary design. A good shopping day leaves time to compare quality, ask about origin and pack items safely. This guide explains where different experiences fit and how to buy respectfully without treating a souk as a performance.',
        'sections' => [
            $section('Souks and historic markets', [
                'Al-Balad in Jeddah is a strong setting for exploring historic lanes, architectural details and small traders. Riyadh\'s traditional markets offer different combinations of perfume, clothing, crafts and food. Go with curiosity and enough time to compare rather than expecting every market to have fixed tourist prices.',
                'Ask whether an item is locally made, imported or a modern reproduction. For textiles, woodwork and crafts, examine construction and care instructions. Haggling can be part of the interaction in some markets, but remain friendly and accept the final price or walk away politely.'
            ]),
            $section('What to buy', [
                'Oud, bakhoor and perfumes are popular gifts, but fragrance strength and quality vary. Ask for a small sample and learn how the product should be transported. Dates, coffee and spice blends are practical choices when packaged for travel, while textiles and baskets add regional character.',
                'Asir is known for distinctive craft traditions and colourful regional design. Contemporary galleries and concept stores in major cities may offer work by Saudi designers, which can be a better choice for travelers seeking an original, easy-to-ship item.'
            ]),
            $section('Malls and modern retail', [
                'Large malls are useful for reliable sizing, air conditioning, international brands and family facilities. They are less about bargaining and more about predictable retail. Check opening hours around prayer times, holidays and seasonal events.',
                'Use malls strategically for essentials, gifts that need a receipt and last-day shopping. Keep fragile or scented items separate from clothes in your luggage and ask about airport restrictions for liquids or food.'
            ]),
            $section('Responsible buying and packing', [
                'Avoid products made from protected wildlife, undocumented antiquities or materials you cannot legally export. A seller\'s claim that an archaeological object is a souvenir is not proof that it can leave the country.',
                'Keep receipts for valuable purchases, check customs rules at your destination and pack coffee, dates, perfume and ceramics according to airline guidance. Shopping is part of cultural exchange when the product\'s story and maker are respected.'
            ])
        ],
        'faq' => [
            ['question' => 'What is a good Saudi souvenir?', 'answer' => 'Oud or bakhoor, dates, coffee, regional crafts and contemporary Saudi design can all be meaningful choices when their origin and quality are clear.'],
            ['question' => 'Is bargaining expected in Saudi souks?', 'answer' => 'It is common in some traditional markets but not in fixed-price malls and shops. Keep the exchange polite and never feel obliged to buy.'],
            ['question' => 'Are shops open during prayer times?', 'answer' => 'Schedules vary, and some businesses pause. Build flexibility into a market visit and follow staff guidance.']
        ],
        'related_articles' => ['saudi-food-guide', 'saudi-culture-customs-travelers', 'things-to-do-riyadh', 'best-places-to-visit-saudi-arabia'],
    ],
    'hajj-umrah-guide' => [
        'seo_title' => 'Hajj and Umrah Guide: Planning a Respectful Pilgrimage',
        'meta_description' => 'A careful overview of Hajj and Umrah planning, official permits, timing, health, accommodation and why requirements must be verified.',
        'primary_keyword' => 'Hajj and Umrah guide',
        'secondary_keywords' => ['Umrah planning', 'Hajj requirements', 'Makkah pilgrimage guide'],
        'author' => 'SaudiVisit Editorial Team',
        'featured_image' => 'assets/images/makkah.svg',
        'intro' => 'Hajj and Umrah are acts of worship, not ordinary tourism products. The required rites, eligibility, permits, visas, health measures, accommodation systems and transport arrangements can change, especially around Hajj season. This article offers a planning framework and respectful context; it does not issue religious rulings or replace official Saudi government, Ministry of Hajj and Umrah, embassy or licensed scholar guidance. Pilgrims should confirm every current requirement before booking or travelling.',
        'sections' => [
            $section('Hajj and Umrah are different journeys', [
                'Hajj takes place during specified days of the Islamic calendar and has capacity, permit and package arrangements that are distinct from ordinary travel. Umrah can generally be performed at other times, but its visa, booking and access requirements still depend on current rules and season.',
                'Do not assume that a tourist itinerary, tourist visa or hotel booking grants permission for pilgrimage rites. Start with your country\'s official channel and the current Saudi pilgrimage platform or embassy guidance.'
            ]),
            $section('Use official and licensed channels', [
                'Verify visa category, permit process, package inclusions, transport, accommodation and refund terms directly with official sources and licensed providers. Be cautious of social-media agents promising guaranteed access, unusually cheap packages or shortcuts around permits.',
                'Keep copies of passport, visa, vaccination or health documents when required, booking confirmations, emergency contacts and your group leader\'s details. Do not surrender original documents to an unverified intermediary.'
            ]),
            $section('Health, timing and physical preparation', [
                'Pilgrimage involves walking, crowds, heat and disrupted sleep. Discuss medical conditions and medication with a qualified clinician well before travel, and follow the current health requirements for your country and pilgrimage season.',
                'Use comfortable footwear where appropriate, hydrate, protect yourself from sun and follow crowd-control instructions. A slower, patient pace is safer than trying to keep a private sightseeing schedule around worship.'
            ]),
            $section('Accommodation, transport and etiquette', [
                'Choose accommodation and transport through the approved arrangement for your pilgrimage. Distances that look short can take much longer in crowds, and prayer or rite timing should be the priority. Keep identification and group contact details with you.',
                'Makkah and Madinah are sacred cities. Dress appropriately, respect prayer spaces, follow gender and access guidance, do not photograph worshippers without consent and never enter restricted areas. Non-Muslim access rules must be checked through official sources.'
            ]),
            $section('A final verification checklist', [
                'Before departure, recheck your passport, visa, permits, health documents, accommodation, transport, operator licence, emergency contacts and the official calendar. Rules can change after an itinerary is published.',
                'Treat this guide as orientation only. The official authority responsible for your visa and pilgrimage arrangements has the final word on eligibility, access and timing.'
            ])
        ],
        'faq' => [
            ['question' => 'Can a tourist visa be used for Hajj?', 'answer' => 'Do not assume so. Hajj has separate requirements and permits; verify the current official rules for your nationality and season.'],
            ['question' => 'Can Umrah be performed year-round?', 'answer' => 'Umrah timing and access can be affected by season, permits and Hajj preparations. Check the current official schedule before booking.'],
            ['question' => 'Where should pilgrims verify requirements?', 'answer' => 'Use official Saudi Ministry channels, your embassy or consulate and licensed pilgrimage providers. Avoid relying on informal agents or old blog posts.']
        ],
        'related_articles' => ['saudi-arabia-visa-guide', 'saudi-culture-customs-travelers', 'is-saudi-arabia-safe', 'saudi-arabia-transportation-guide'],
    ],
];

foreach ($articles as &$article) {
    $enhancement = $articleEnhancements[$article['slug']] ?? null;
    if ($enhancement === null) {
        continue;
    }

    $article = array_merge($article, $enhancement);
    $article['content'] = [$article['intro']];
    foreach ($article['sections'] as $contentSection) {
        foreach ($contentSection['paragraphs'] as $paragraph) {
            $article['content'][] = $paragraph;
        }
    }
    $wordCount = str_word_count(implode(' ', $article['content']));
    $minutes = max(1, (int) ceil($wordCount / 200));
    $article['read_time'] = $minutes === 1 ? '1 min read' : $minutes . ' min read';
}
unset($article);
