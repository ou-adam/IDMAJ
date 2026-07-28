-- schema.sql: MySQL Database Schema for IDMADJ.DZ website



-- 1. Users Table (Administrative Roles)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM(
        'super_admin',
        'content_manager',
        'registration_manager',
        'sponsors_manager',
        'b2b_manager',
        'hackathon_manager',
        'media_manager'
    ) NOT NULL DEFAULT 'registration_manager',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 2. Unified Registrations Table (Dynamic based on type)
CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_id VARCHAR(50) NOT NULL UNIQUE, -- IDMAJ-2026-XXXX
    participant_type VARCHAR(50) NOT NULL, -- corporate, seminar, expert, media, sponsor, b2b, hackathon, pitch

-- Organization Details
organization_name VARCHAR(150),
legal_status VARCHAR(100),
commercial_register_no VARCHAR(100),
nif VARCHAR(100),
economic_sector VARCHAR(100),
main_activity VARCHAR(150),
company_size VARCHAR(50), -- micro, small, medium, large, startup
company_type VARCHAR(50), -- producer, subcontractor, service_provider

-- Personal & Contact Details
representative_name VARCHAR(100) NOT NULL,
representative_title VARCHAR(100),
wilaya VARCHAR(50) NOT NULL,
address TEXT NOT NULL,
email VARCHAR(100) NOT NULL,
phone VARCHAR(50) NOT NULL,
website VARCHAR(150),
selected_seminar VARCHAR(150),

-- File Uploads
personal_photo VARCHAR(255),
company_logo VARCHAR(255),
company_profile_pdf VARCHAR(255),

-- Administrative fields
status ENUM('pending', 'approved', 'rejected', 'info_needed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. B2B Requests Table (Specific to B2B matchmaking)
CREATE TABLE IF NOT EXISTS b2b_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    b2b_role VARCHAR(100) NOT NULL, -- client_seeking_subcontractor, subcontractor_offering_services, funding_institution, audit_lab
    sectors_needed TEXT, -- comma-separated values
    opportunities_needed TEXT, -- supply, manufacturing, maintenance, quality, finance, digitizing, partnership
    status ENUM(
        'pending',
        'approved',
        'rejected'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 4. Hackathon Teams Table
CREATE TABLE IF NOT EXISTS hackathon_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    team_name VARCHAR(100) NOT NULL,
    members_count INT NOT NULL DEFAULT 3,
    leader_name VARCHAR(100) NOT NULL,
    leader_email VARCHAR(100) NOT NULL,
    leader_phone VARCHAR(50) NOT NULL,
    wilaya VARCHAR(50) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    track VARCHAR(100) NOT NULL, -- smart_subcontracting, quality_tracking, maintenance_4.0, green_logistics
    idea_desc TEXT NOT NULL,
    has_prototype TINYINT(1) DEFAULT 0,
    github_link VARCHAR(255),
    slide_pdf VARCHAR(255),
    status ENUM(
        'pending',
        'approved',
        'rejected'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 5. Pitch Submissions Table (1-Minute Pitch Box)
CREATE TABLE IF NOT EXISTS pitch_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    project_name VARCHAR(150) NOT NULL,
    wilaya VARCHAR(50) NOT NULL,
    sector VARCHAR(100) NOT NULL,
    stage VARCHAR(100) NOT NULL, -- idea, prototype, active, expansion
    description TEXT NOT NULL,
    value_add TEXT NOT NULL,
    need_type VARCHAR(100) NOT NULL, -- funding, partner, market, mentoring, quality, manufacturing
    video_link VARCHAR(255),
    pdf_path VARCHAR(255),
    status ENUM(
        'pending',
        'approved',
        'rejected',
        'selected_finalist'
    ) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 6. Sponsors & Partners Table
CREATE TABLE IF NOT EXISTS sponsors_partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ar VARCHAR(100) NOT NULL,
    name_fr VARCHAR(100),
    logo_path VARCHAR(255) NOT NULL,
    url VARCHAR(255),
    type ENUM('sponsor', 'partner') NOT NULL,
    level VARCHAR(50) NOT NULL, -- official, gold, silver, bronze, support, organization, coordination
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 7. News Articles Table (CMS)
CREATE TABLE IF NOT EXISTS news_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_ar VARCHAR(200) NOT NULL,
    title_fr VARCHAR(200),
    content_ar TEXT NOT NULL,
    content_fr TEXT,
    image_path VARCHAR(255),
    category VARCHAR(50), -- general, hackathon, seminaires, press
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 8. Podcasts Table
CREATE TABLE IF NOT EXISTS podcasts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    guest VARCHAR(100),
    sponsor_name VARCHAR(100),
    youtube_url VARCHAR(255) NOT NULL,
    audio_path VARCHAR(255),
    thumbnail_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- 9. Contact Messages Table
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(50),
    subject VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    reason VARCHAR(50) NOT NULL, -- general, sponsor, register, b2b, hackathon, partner, media
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Seed initial admin user (username: admin, password: password123 hashed)
INSERT INTO
    users (username, password, role)
VALUES (
        'admin',
        '$2y$10$eE61dO/NndvR.qF2jPq/k.Q0wG6qL.YxZ984E3k3.1b9f7s2n3m4K',
        'super_admin'
    )
ON DUPLICATE KEY UPDATE
    password = VALUES(password);