-- SaudiVisit currently uses PHP data arrays.
-- This file reserves a version-controlled migration point for a future MySQL release.
-- No production data or credentials belong in this repository.

CREATE TABLE IF NOT EXISTS articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(190) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    excerpt TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    published_date DATE NOT NULL,
    updated_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
