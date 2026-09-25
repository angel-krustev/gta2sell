# PostgreSQL Setup for GTA2Sell Signup System

## Database Permissions Issue

From the error logs, it appears there's a permissions issue with accessing the `reg_users` table. The web server is connecting as `web_user` but cannot find the table.

## Solution Steps

1. **Execute the reg_users table creation script:**
   ```sql
   -- Run this SQL in your PostgreSQL database using a user with appropriate privileges (like syncuser)
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
   
   CREATE INDEX idx_reg_users_email ON reg_users(email);
   ```

2. **Verify database access:**
   Test that the `web_user` can access the table:
   ```bash
   psql -h 192.168.1.167 -p 5433 -U web_user -d treb -c "SELECT COUNT(*) FROM reg_users;"
   ```

3. **If needed, grant explicit privileges:**
   If the table is created but `web_user` still can't access it, grant explicit privileges:
   ```sql
   GRANT ALL PRIVILEGES ON TABLE reg_users TO web_user;
   GRANT USAGE, SELECT ON SEQUENCE reg_users_id_seq TO web_user;
   ```

## Configuration Details

- Host:
- Port:
- Database: 
- User: 
- Password:

## Testing

After creating the table, test that the signup functionality works by:
1. Visiting the signup page on your website
2. Checking that no database errors occur in the PHP error logs
3. Verifying that user registration creates records in the `reg_users` table

## Troubleshooting

If you continue to have issues:
1. Check PostgreSQL logs for permission errors
2. Ensure `web_user` has appropriate privileges on the `treb` database
3. Verify that the database connection parameters in your config files are correct
4. Make sure the table exists in the same schema that the application is connecting to
