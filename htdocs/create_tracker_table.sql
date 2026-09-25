-- Create TRACKER table for PostgreSQL database
CREATE TABLE IF NOT EXISTS "TRACKER" (
    "id" SERIAL PRIMARY KEY,
    "session" VARCHAR(256) NOT NULL,
    "cookie_email" VARCHAR(128) NOT NULL,
    "ip_fw" VARCHAR(15) NOT NULL DEFAULT '',
    "ip_ra" VARCHAR(15) NOT NULL DEFAULT '',
    "email" VARCHAR(128) NOT NULL,
    "full_name" VARCHAR(80) NOT NULL DEFAULT '',
    "phone" VARCHAR(16) NOT NULL DEFAULT '',
    "address" VARCHAR(128) NOT NULL,
    "br" VARCHAR(2) NOT NULL DEFAULT '',
    "bath" VARCHAR(2) NOT NULL DEFAULT '',
    "gr" VARCHAR(2) NOT NULL DEFAULT '',
    "sqf" VARCHAR(15) NOT NULL DEFAULT '',
    "est_p" VARCHAR(20) NOT NULL DEFAULT '',
    "msg" TEXT NOT NULL,
    "type" VARCHAR(3) NOT NULL DEFAULT '',
    "landing" VARCHAR(255) NOT NULL DEFAULT '',
    "ts" TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create index on session for better performance
CREATE INDEX IF NOT EXISTS idx_tracker_session ON "TRACKER" ("session");

-- Create index on timestamp for better performance
CREATE INDEX IF NOT EXISTS idx_tracker_ts ON "TRACKER" ("ts");