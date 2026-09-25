<?php

/**
 * Include the libraries
 */

require_once __DIR__."/idiorm.php";
require_once __DIR__."/User.class.php";
require_once __DIR__."/functions.php";

/**
 * Configure Idiorm for PostgreSQL
 * Using the same connection parameters as the main application
 */

// Get database configuration from the main config (using relative path)
require_once __DIR__.'/../../../config/config.php';

// Configure Idiorm to use the same PostgreSQL connection
ORM::configure("pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME);
ORM::configure("username", DB_USER);
ORM::configure("password", DB_PASS);

// Set the database connection to UTF-8 for PostgreSQL (using proper PDO options)
// Note: PGSQL_ATTR_INIT_COMMAND doesn't exist in PHP's PDO, so we'll skip this
// Any charset configuration is handled by the main config and database setup

/**
 * Configure the session
 */

session_name('tzreg');

// Uncomment to keep people logged in for a week
session_set_cookie_params(60 * 60 * 24 * 365 * 10);
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


 if (!isset($_SESSION['tr']) ){
  $_SESSION['tr'] = generateFormToken('tr');
 }

/**
 * Other settings
 */

// The "from" email address that is used in the emails that are sent to users.
// Some hosting providers block outgoing email if this address
// is not registered as a real email account on their system, so put a real one here.

$fromEmail = 'elzakrusteva@' . $_SERVER['SERVER_NAME'];

// The "to" email address that is used in the emails that are sent to owner.

$toEmail = 'angel.krustev@gmail.com;elzas2000@yahoo.com;angel@jobvolume.com';
if(!isset($toEmail)){
	// This is only used if you haven't filled an email address in $fromEmail
	$toEmail = 'angel_krustev@yahoo.com';
}
