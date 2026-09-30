-- SaudiVisit.net — database schema (MySQL/MariaDB, utf8mb4)
-- Implements the data model from TRD section 6, adapted for plain PHP.
-- Select the target database in phpMyAdmin before importing this file.
-- For local CLI use: mysql -u USER -p DATABASE_NAME < database/schema.sql

-- ---------- Users & roles ----------
CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email         VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  name          VARCHAR(120) NOT NULL,
  role          ENUM('admin','editor','writer','reviewer') NOT NULL DEFAULT 'writer',
  mfa_enabled   TINYINT(1) NOT NULL DEFAULT 0,
  created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE authors (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NULL,
  slug       VARCHAR(190) NOT NULL UNIQUE,
  name       VARCHAR(120) NOT NULL,
  bio        TEXT NULL,
  experience TEXT NULL,
  image_id   INT UNSIGNED NULL,
  INDEX (user_id)
) ENGINE=InnoDB;

-- ---------- Content ----------
CREATE TABLE articles (
  id                  INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  translation_group_id INT UNSIGNED NULL,
  owner_id            INT UNSIGNED NULL,
  primary_author_id   INT UNSIGNED NULL,
  created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (owner_id),
  INDEX (primary_author_id)
) ENGINE=InnoDB;

-- States follow the PRD workflow: draft → in_review → fact_review → approved → published → archived
CREATE TABLE article_localizations (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  article_id            INT UNSIGNED NOT NULL,
  locale                VARCHAR(5) NOT NULL DEFAULT 'en',
  slug                  VARCHAR(190) NOT NULL,
  title                 VARCHAR(255) NOT NULL,
  excerpt               TEXT NULL,
  body                  MEDIUMTEXT NULL,          -- sanitized HTML
  state                 ENUM('draft','in_review','fact_review','approved','scheduled','published','archived') NOT NULL DEFAULT 'draft',
  published_at          DATETIME NULL,
  substantive_updated_at DATETIME NULL,
  reviewed_at           DATETIME NULL,
  review_due_at         DATETIME NULL,
  scheduled_at          DATETIME NULL,
  seo_title             VARCHAR(255) NULL,
  meta_description      VARCHAR(320) NULL,
  hero_media_id         INT UNSIGNED NULL,
  reviewer_id           INT UNSIGNED NULL,
  content_type          ENUM('guide','pillar','itinerary','practical','policy') NOT NULL DEFAULT 'guide',
  updated_at            DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_locale_slug (locale, slug),
  INDEX idx_public (locale, state, published_at),
  INDEX idx_review_due (review_due_at),
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE revisions (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  localization_id INT UNSIGNED NOT NULL,
  title           VARCHAR(255) NOT NULL,
  body            MEDIUMTEXT NULL,
  actor_id        INT UNSIGNED NULL,
  review_notes    TEXT NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (localization_id) REFERENCES article_localizations(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- Taxonomy ----------
CREATE TABLE destinations (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  locale       VARCHAR(5) NOT NULL DEFAULT 'en',
  slug         VARCHAR(190) NOT NULL,
  title        VARCHAR(190) NOT NULL,
  intro        TEXT NULL,
  quick_facts  TEXT NULL,               -- JSON
  image_id     INT UNSIGNED NULL,
  is_indexable TINYINT(1) NOT NULL DEFAULT 1,
  sort_order   INT NOT NULL DEFAULT 0,
  UNIQUE KEY uq_dest (locale, slug)
) ENGINE=InnoDB;

CREATE TABLE topics (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  locale       VARCHAR(5) NOT NULL DEFAULT 'en',
  slug         VARCHAR(190) NOT NULL,
  title        VARCHAR(190) NOT NULL,
  intro        TEXT NULL,
  is_indexable TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uq_topic (locale, slug)
) ENGINE=InnoDB;

CREATE TABLE article_destination (
  article_id      INT UNSIGNED NOT NULL,
  destination_id  INT UNSIGNED NOT NULL,
  PRIMARY KEY (article_id, destination_id),
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
  FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE article_topic (
  article_id INT UNSIGNED NOT NULL,
  topic_id   INT UNSIGNED NOT NULL,
  PRIMARY KEY (article_id, topic_id),
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
  FOREIGN KEY (topic_id) REFERENCES topics(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- Sources (fact-check trail) ----------
CREATE TABLE sources (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  localization_id INT UNSIGNED NOT NULL,
  source_url      VARCHAR(500) NOT NULL,
  publisher       VARCHAR(190) NULL,
  claim_section   VARCHAR(190) NULL,
  checked_at      DATETIME NULL,
  reviewer_id     INT UNSIGNED NULL,
  FOREIGN KEY (localization_id) REFERENCES article_localizations(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------- Media ----------
CREATE TABLE media (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  file_path  VARCHAR(500) NOT NULL,     -- relative to /assets/uploads/
  mime       VARCHAR(80) NOT NULL,
  width      INT UNSIGNED NULL,
  height     INT UNSIGNED NULL,
  alt_text   VARCHAR(255) NULL,
  caption    VARCHAR(500) NULL,
  credit     VARCHAR(190) NULL,
  rights     VARCHAR(190) NULL,         -- e.g. 'own', 'licensed', 'cc-by'
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------- Trust / static pages ----------
CREATE TABLE pages (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  locale      VARCHAR(5) NOT NULL DEFAULT 'en',
  slug        VARCHAR(190) NOT NULL,
  title       VARCHAR(190) NOT NULL,
  body        MEDIUMTEXT NULL,
  is_indexable TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uq_page (locale, slug)
) ENGINE=InnoDB;

-- ---------- SEO / ops ----------
CREATE TABLE redirects (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  locale      VARCHAR(5) NOT NULL DEFAULT 'en',
  old_path    VARCHAR(500) NOT NULL UNIQUE,
  new_path    VARCHAR(500) NOT NULL,
  http_status SMALLINT NOT NULL DEFAULT 301,
  created_by  INT UNSIGNED NULL,
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE audit_logs (
  id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  actor_id   INT UNSIGNED NULL,
  action     VARCHAR(80) NOT NULL,
  entity     VARCHAR(80) NOT NULL,
  entity_id  INT UNSIGNED NULL,
  meta       TEXT NULL,                 -- JSON; never store secrets
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX (entity, entity_id)
) ENGINE=InnoDB;

CREATE TABLE subscribers (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email           VARCHAR(190) NOT NULL UNIQUE,
  consent_evidence VARCHAR(255) NULL,
  confirmed_at    DATETIME NULL,
  unsubscribed_at DATETIME NULL,
  created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
