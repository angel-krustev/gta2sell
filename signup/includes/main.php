<?php

/**
 * Include the libraries
 */

require_once __DIR__."/idiorm.php";
require_once __DIR__."/User.class.php";
require_once __DIR__."/functions.php";

/**
 * Configure Idiorm
 */

$db_host = 'localhost';
$db_name = 'treb';
$db_user = 'trebuser';
$db_pass = 'r4M0ney';
$sock = "/var/lib/mysql/mysql.sock";


ORM::configure("mysql:host=$db_host;dbname=$db_name;unix_socket=$sock");
ORM::configure("username", $db_user);
ORM::configure("password", $db_pass);

// Set the database connection to UTF-8
// pdo_mysql isn't installed post-migration (signups no longer use local MySQL);
// guard the constant so this doesn't fatal-error the whole request.
if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
    ORM::configure('driver_options', array(constant('PDO::MYSQL_ATTR_INIT_COMMAND') => 'SET NAMES utf8'));
}

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

# $fromEmail = '';

if(!$fromEmail){
	// This is only used if you haven't filled an email address in $fromEmail
	$fromEmail = 'elzakrusteva@'.$_SERVER['SERVER_NAME'];
}
// The "to" email address that is used in the emails that are sent to owner.

$toEmail = 'angel.krustev@gmail.com;elzas2000@yahoo.com;angel@jobvolume.com';
if(!isset($toEmail)){
	// This is only used if you haven't filled an email address in $fromEmail
	$toEmail = 'angel_krustev@yahoo.com';
}
