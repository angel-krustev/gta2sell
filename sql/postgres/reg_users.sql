-- PostgreSQL table structure for user registration (reg_users)
-- This table is equivalent to the MySQL users table but adapted for PostgreSQL

-- Drop table if it exists (for re-creation purposes)
DROP TABLE IF EXISTS reg_users;

CREATE TABLE reg_users (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    phone VARCHAR(200),
    email VARCHAR(200),
    token VARCHAR(255),
    token_validity TIMESTAMP,
    last_login TIMESTAMP,
    rank INTEGER DEFAULT 0,
    full_name VARCHAR(255),
    landing TEXT,
    step VARCHAR(10) DEFAULT '1',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index on email for faster lookups
CREATE INDEX idx_reg_users_email ON reg_users(email);

-- Sample data (if needed)
-- INSERT INTO reg_users (firstname, lastname, phone, email) VALUES 
-- ('fname1', 'lname1', '(000)000-0000', 'name1@gmail.com'),
-- ('fname2', 'lname2', '(000)000-0000', 'name2@gmail.com');