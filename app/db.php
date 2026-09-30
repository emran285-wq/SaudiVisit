<?php
/** Database access (PDO) + content queries used by public routes. */

declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    if (DB_HOST === '' || DB_NAME === '' || DB_USER === '') {
        throw new RuntimeException('Database configuration is incomplete. Set DB_HOST, DB_NAME, and DB_USER in the application environment.');
    }
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    return $pdo;
}

function q(string $sql, array $params = []): PDOStatement
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/* ---------- Public content queries (published only) ---------- */

function get_destinations(string $locale): array
{
    return q('SELECT * FROM destinations WHERE locale = ? ORDER BY sort_order, title', [$locale])->fetchAll();
}

function get_destination(string $locale, string $slug): ?array
{
    $row = q('SELECT * FROM destinations WHERE locale = ? AND slug = ?', [$locale, $slug])->fetch();
    return $row ?: null;
}

function get_topic(string $locale, string $slug): ?array
{
    $row = q('SELECT * FROM topics WHERE locale = ? AND slug = ?', [$locale, $slug])->fetch();
    return $row ?: null;
}

function get_article(string $locale, string $slug): ?array
{
    $row = q(
        "SELECT al.*, a.primary_author_id, au.name AS author_name, au.slug AS author_slug
         FROM article_localizations al
         JOIN articles a ON a.id = al.article_id
         LEFT JOIN authors au ON au.id = a.primary_author_id
         WHERE al.locale = ? AND al.slug = ? AND al.state = 'published'",
        [$locale, $slug]
    )->fetch();
    return $row ?: null;
}

function get_articles_by_destination(int $destinationId, string $locale, int $page = 1, int $perPage = 10): array
{
    $offset = ($page - 1) * $perPage;
    return q(
        "SELECT al.* FROM article_localizations al
         JOIN article_destination ad ON ad.article_id = al.article_id
         WHERE ad.destination_id = ? AND al.locale = ? AND al.state = 'published'
         ORDER BY al.published_at DESC
         LIMIT ? OFFSET ?",
        [$destinationId, $locale, $perPage, $offset]
    )->fetchAll();
}

function count_articles_by_destination(int $destinationId, string $locale): int
{
    return (int) q(
        "SELECT COUNT(*) FROM article_localizations al
         JOIN article_destination ad ON ad.article_id = al.article_id
         WHERE ad.destination_id = ? AND al.locale = ? AND al.state = 'published'",
        [$destinationId, $locale]
    )->fetchColumn();
}

function get_articles_by_topic(int $topicId, string $locale, int $page = 1, int $perPage = 10): array
{
    $offset = ($page - 1) * $perPage;
    return q(
        "SELECT al.* FROM article_localizations al
         JOIN article_topic at ON at.article_id = al.article_id
         WHERE at.topic_id = ? AND al.locale = ? AND al.state = 'published'
         ORDER BY al.published_at DESC
         LIMIT ? OFFSET ?",
        [$topicId, $locale, $perPage, $offset]
    )->fetchAll();
}

function get_latest_articles(string $locale, int $limit = 6): array
{
    return q(
        "SELECT * FROM article_localizations
         WHERE locale = ? AND state = 'published'
         ORDER BY COALESCE(substantive_updated_at, published_at) DESC
         LIMIT ?",
        [$locale, $limit]
    )->fetchAll();
}

function get_articles_page(string $locale, int $page = 1, int $perPage = 10): array
{
    $offset = (max(1, $page) - 1) * $perPage;
    return q(
        "SELECT * FROM article_localizations
         WHERE locale = ? AND state = 'published'
         ORDER BY COALESCE(substantive_updated_at, published_at) DESC
         LIMIT ? OFFSET ?",
        [$locale, $perPage, $offset]
    )->fetchAll();
}

function count_published_articles(string $locale): int
{
    return (int) q(
        "SELECT COUNT(*) FROM article_localizations WHERE locale = ? AND state = 'published'",
        [$locale]
    )->fetchColumn();
}

function get_related_articles(int $articleId, string $locale, int $limit = 3): array
{
    return q(
        "SELECT DISTINCT al2.* FROM article_localizations al2
         JOIN article_destination ad2 ON ad2.article_id = al2.article_id
         WHERE ad2.destination_id IN (SELECT destination_id FROM article_destination WHERE article_id = ?)
           AND al2.article_id <> ? AND al2.locale = ? AND al2.state = 'published'
         ORDER BY al2.published_at DESC
         LIMIT ?",
        [$articleId, $articleId, $locale, $limit]
    )->fetchAll();
}

function get_article_destinations(int $articleId, string $locale): array
{
    return q(
        "SELECT d.* FROM destinations d
         JOIN article_destination ad ON ad.destination_id = d.id
         WHERE ad.article_id = ? AND d.locale = ? ORDER BY d.sort_order",
        [$articleId, $locale]
    )->fetchAll();
}

function get_article_sources(int $localizationId): array
{
    return q('SELECT * FROM sources WHERE localization_id = ? ORDER BY id', [$localizationId])->fetchAll();
}

function search_articles(string $locale, string $term, int $page = 1, int $perPage = 10): array
{
    $offset = ($page - 1) * $perPage;
    $like = '%' . $term . '%';
    return q(
        "SELECT * FROM article_localizations
         WHERE locale = ? AND state = 'published'
           AND (title LIKE ? OR excerpt LIKE ? OR body LIKE ?)
         ORDER BY published_at DESC
         LIMIT ? OFFSET ?",
        [$locale, $like, $like, $like, $perPage, $offset]
    )->fetchAll();
}

function count_search_articles(string $locale, string $term): int
{
    $like = '%' . $term . '%';
    return (int) q(
        "SELECT COUNT(*) FROM article_localizations
         WHERE locale = ? AND state = 'published'
           AND (title LIKE ? OR excerpt LIKE ? OR body LIKE ?)",
        [$locale, $like, $like, $like]
    )->fetchColumn();
}

function get_page(string $locale, string $slug): ?array
{
    $row = q('SELECT * FROM pages WHERE locale = ? AND slug = ?', [$locale, $slug])->fetch();
    return $row ?: null;
}

function get_author(string $slug): ?array
{
    $row = q('SELECT * FROM authors WHERE slug = ?', [$slug])->fetch();
    return $row ?: null;
}

function redirect_lookup(string $locale, string $route): ?array
{
    $row = q('SELECT * FROM redirects WHERE old_path = ?', [$locale . '/' . $route])->fetch();
    return $row ?: null;
}
