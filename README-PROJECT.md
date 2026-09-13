# SaudiVisit.net – Professional Saudi Arabia Travel Guide

A comprehensive, SEO-optimized PHP travel guide for Saudi Arabia, designed as an independent editorial platform with destination guides, travel planning resources, attractions database, and interactive trip planner.

## Project Overview

**Status:** Professional Travel Platform v1.0  
**Language:** PHP 8.0+ | HTML5 | CSS3 | Vanilla JavaScript  
**Database:** None required for starter version (static PHP arrays)  
**Architecture:** Modular, reusable PHP components  
**Deployment:** Apache/XAMPP/WAMP compatible  

## Installation

### XAMPP / WAMP

1. Download and install XAMPP (https://www.apachefriends.org/) or WAMP (https://www.wampserver.com/)

2. Copy the `saudivisit` folder into your server's document root:
   - **XAMPP:** `C:\xampp\htdocs\saudivisit\`
   - **WAMP:** `C:\wamp64\www\saudivisit\`
   - **Linux XAMPP:** `/opt/lampp/htdocs/saudivisit/`

3. Start your Apache server through the control panel

4. Open your browser and navigate to: `http://localhost/saudivisit/`

### PHP Built-in Server

For quick testing without XAMPP/WAMP:

```bash
cd /path/to/saudivisit
php -S localhost:8000
```

Then visit: `http://localhost:8000`

### MAMP (macOS)

1. Copy folder to: `/Applications/MAMP/htdocs/saudivisit/`
2. Start MAMP server
3. Visit: `http://localhost:8888/saudivisit/`

## Project Structure

```
saudivisit/
├── index.php                # Homepage
├── destinations.php         # Destination listing page
├── destination.php          # Individual destination guide (dynamic)
├── articles.php             # Article listing page
├── article.php              # Individual article page (dynamic)
├── attractions.php          # Attraction database browser
├── planner.php              # Interactive trip planner
├── about.php                # About SaudiVisit page
├── contact.php              # Contact page
├── privacy.php              # Privacy policy
├── 404.php                  # 404 error page
├── robots.txt               # Search engine instructions
├── sitemap.xml.php          # Dynamic sitemap
├── .htaccess                # Apache configuration
│
├── assets/
│   ├── css/
│   │   └── style.css        # Main stylesheet
│   ├── js/
│   │   └── app.js           # Mobile nav + interactions
│   └── images/              # SVG illustrations and images
│
├── data/
│   └── site-data.php        # All content arrays (destinations, articles, attractions)
│
├── includes/
│   ├── config.php           # Site configuration & paths
│   ├── functions.php        # SEO utilities & helper functions
│   ├── header.php           # HTML head + navigation
│   └── footer.php           # Footer markup
│
└── README.md                # This file
```

## Key Features

### ✓ 8 Comprehensive Destinations
- **Riyadh** – Culture, museums, desert excursions
- **Jeddah** – Red Sea coast, heritage district, diving
- **AlUla** – UNESCO Hegra, desert landscapes
- **Madinah** – Islamic pilgrimage center
- **Makkah** – Hajj/Umrah destination
- **Abha** – Mountain scenery, highland culture
- **Taif** – Rose gardens, mountain air
- **Dammam** – Eastern region, modern amenities

### ✓ 20+ High-Quality Articles
All articles are SEO-optimized and include:
- Complete travel planning guides
- Itineraries (7-day, 3-day, weekend plans)
- Cultural & culinary guides
- Transportation & logistics
- Budget & safety information
- Hajj/Umrah pilgrimage guidance

### ✓ 30+ Attractions Database
Curated attractions across all destinations with:
- Category classification
- Ratings & pricing
- Location information
- Photo galleries (structure ready)

### ✓ Interactive Trip Planner
- Rule-based itinerary generation
- Customizable by: destination, days, budget, interests
- Production-ready foundation for AI/API integration

### ✓ Professional SEO
- Dynamic meta tags for all pages
- Open Graph & Twitter Card support
- JSON-LD structured data (Article, Breadcrumb, WebSite schemas)
- Semantic HTML5
- Clean URL structure
- XML sitemap generation
- robots.txt configuration
- Breadcrumb navigation
- Internal linking strategy

### ✓ Responsive Design
- Mobile-first CSS
- Works from 320px to 1440px+
- Touch-friendly navigation
- Optimized for all devices

### ✓ Accessibility
- Semantic HTML structure
- Skip-to-content link
- Keyboard navigation support
- Proper ARIA labels
- Color contrast compliance
- Descriptive alt text

### ✓ Performance
- CSS minification-ready
- Lazy loading on images
- No heavy dependencies
- Fast load times
- Cacheable static assets
- Gzip compression configured

## Configuration

### Base URL / Subdirectory

The site is configured to run at `http://localhost/saudivisit/`.

To change the installation folder:

1. Edit `/includes/config.php`:
   ```php
   define('BASE_PATH', '/your-new-path');
   ```

2. Update `.htaccess`:
   ```
   RewriteBase /your-new-path/
   ```

### Production Deployment

For live deployment to `https://saudivisit.net`:

1. Update `/includes/config.php`:
   ```php
   define('CANONICAL_DOMAIN', 'https://saudivisit.net');
   ```

2. Update `.htaccess` to force HTTPS:
   ```
   RewriteCond %{HTTPS} !=on
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

3. Regenerate sitemaps for production domain

## Content Management

### Adding a Destination

Edit `/data/site-data.php` and add to `$destinations` array:

```php
'destination-slug' => [
    'name' => 'Destination Name',
    'slug' => 'destination-slug',
    'tagline' => 'Brief tagline',
    'summary' => 'One-paragraph description',
    'description' => 'Longer multi-paragraph description',
    'best_time' => 'October to March',
    'days' => '2-4 days',
    'image' => 'assets/images/destination.svg',
    'highlights' => ['Highlight 1', 'Highlight 2'],
    'tips' => ['Tip 1', 'Tip 2'],
],
```

### Adding an Article

Edit `/data/site-data.php` and add to `$articles` array:

```php
[
    'slug' => 'article-url-slug',
    'title' => 'Article Title',
    'category' => 'Travel Planning',
    'excerpt' => 'Short preview text',
    'read_time' => '10 min read',
    'featured' => true,
    'published_date' => '2026-01-15',
    'updated_date' => '2026-09-13',
    'content' => [
        'First paragraph...',
        'Second paragraph...',
        // Add more paragraphs as needed
    ],
],
```

### Adding Attractions

Edit `/data/site-data.php` and add to `$attractions` array:

```php
[
    'name' => 'Attraction Name',
    'destination' => 'destination-slug',
    'category' => 'Heritage',
    'price' => 'Entry details',
    'rating' => '4.8',
],
```

## Database Migration (Future)

The current version uses static PHP arrays. To migrate to MySQL:

1. Create tables for destinations, articles, attractions
2. Migrate `/data/site-data.php` arrays to database
3. Create database connection functions in a new `/includes/db.php`
4. Update content loading functions to query database
5. Build an admin CMS for content management

A `database.sql` template is available in production upgrades.

## SEO Best Practices Implemented

✓ **Metadata:** Dynamic title, description, canonical URLs  
✓ **Structured Data:** JSON-LD schemas for articles, breadcrumbs, FAQs  
✓ **Content:** Well-structured H1/H2/H3 hierarchy  
✓ **Internal Links:** Topic clusters connecting related content  
✓ **Performance:** Fast load times, optimized assets  
✓ **Mobile:** Responsive, fast on mobile devices  
✓ **Security:** HTTPS-ready, secure headers configured  
✓ **Accessibility:** WCAG 2.1 AA standards  
✓ **Sitemaps:** XML sitemap for search engines  
✓ **Robots.txt:** Clear crawl directives  

## Common Tasks

### Reset to Clean State
```bash
rm /data/site-data.php
cp /data/site-data.backup.php /data/site-data.php
```

### Test on Different Port
```bash
php -S localhost:3000
```

### Check PHP Version
```bash
php -v
```

### Clear Browser Cache
Use Ctrl+Shift+Delete (Windows/Linux) or Cmd+Shift+Delete (Mac)

## Troubleshooting

### 404 Errors on Pages
- Check `.htaccess` is in the correct directory
- Verify `mod_rewrite` is enabled in Apache
- Check `BASE_PATH` setting in `/includes/config.php`

### Missing Images
- Ensure images are in `/assets/images/`
- Check image paths in `site-data.php`
- Use complete relative paths starting from `BASE_PATH`

### PHP Errors
- Verify PHP version is 8.0+
- Check error logs in XAMPP/WAMP control panel
- Enable error reporting: `error_reporting(E_ALL); ini_set('display_errors', 1);`

### Navigation Issues
- Clear browser cache (Ctrl+Shift+Delete)
- Verify JavaScript is enabled
- Check console for errors (F12)

## Design System

### Color Palette
- **Primary:** Deep charcoal/midnight (#0b3d2e)
- **Accent:** Saudi emerald (#155b44)
- **Secondary:** Warm sand (#f6f0e6)
- **Highlight:** Desert terracotta (#c79443)
- **Text:** Dark charcoal (#14231d)
- **Background:** Warm off-white (#fbfaf6)

### Typography
- **Headings:** Georgia, serif (editorial feel)
- **Body:** Inter, system sans-serif (clean, readable)
- **Scale:** Responsive clamp() for fluid sizing

### Spacing
- Container max-width: 1180px
- Section padding: 86px vertical
- Card radius: 24px (large, modern)
- Gutter: 22px

## Analytics & Tracking

The site is ready for:
- Google Analytics 4 (add tracking ID to header)
- Search Console integration (via sitemap)
- Conversion tracking (ecommerce plugin)
- Heat mapping (Hotjar, Clarity)

## Future Enhancement Ideas

### Content
- 100+ comprehensive destination guides
- 200+ SEO articles covering all topics
- User-generated reviews & ratings
- Seasonal event calendars
- Live weather integration

### Technology
- MySQL/PostgreSQL database
- Admin CMS interface
- User accounts & saved trips
- Real-time booking availability
- AI-powered itinerary generation
- Map integration (Google Maps/Mapbox)
- Booking affiliate links

### Marketing
- Email newsletter system
- Social media integration
- User reviews & testimonials
- Photo gallery with community submissions
- Blog system with author profiles
- Podcast integration

### Monetization
- Affiliate hotel bookings
- Tour operator partnerships
- Travel insurance partnerships
- Car rental affiliate links
- Flight booking partnerships
- Sponsored content sections

## Support & Contributions

**Report Issues:** Use the contact form or email info@saudivisit.net

**Contribute Content:** We welcome accurate, well-researched travel information

**Pull Requests:** Open source contributions welcome on GitHub

## License

Creative Commons Attribution 4.0 International (CC-BY-4.0)

You are free to use, modify, and distribute this project with attribution.

## Disclaimer

SaudiVisit.net is an independent travel guide. Always verify current travel regulations, visa requirements, opening hours, and safety information from official government sources before travel. This site does not guarantee accuracy of time-sensitive information.

---

**Last Updated:** September 13, 2026

**Version:** 1.0

**Recommended For:** Travelers, travel agents, content creators, tourism professionals
