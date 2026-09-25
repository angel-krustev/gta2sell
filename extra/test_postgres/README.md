# PostgreSQL Setup for GTA2Sell Signup System

This document explains how to set up the PostgreSQL database for the signup system.

## Database Connection Details
## Required Table Creation

Execute this SQL to create the reg_users table:

```sql
-- PostgreSQL table structure for user registration (reg_users)
-- This table is equivalent to the MySQL users table but adapted for PostgreSQL

CREATE TABLE IF NOT EXISTS reg_users (
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
CREATE INDEX IF NOT EXISTS idx_reg_users_email ON reg_users(email);
```

## Testing the Connection

You can test your connection with:
```bash
psql -h 192.168.1.167 -p 5433 -U web_user -d treb
```
