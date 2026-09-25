<?php
/**
 * New Postgres-backed config bootstrap (replaces the old MySQL config.php).
 * Include this from pages that need $mysqli / $RES / image URL helpers.
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/image_helper.php';
require_once __DIR__ . '/legacy_helpers.php';


if (!defined('DB_HOST')) {
    define('DB_HOST', '192.168.1.167');
    define('DB_PORT', '1234');
    define('DB_NAME', 'dbname');
    define('DB_USER', 'dbuser');
    define('DB_PASS', 'Secret');
}
// Legacy defaults previously set by the old config/global.php; kept here so
// pages that reference them without redefining still work. Safe no-ops if
// already set by something included earlier.
if (!isset($limit)) {
    $limit = 20;
}
if (!isset($size)) {
    $size = 20;
}
if (!isset($rangePage)) {
    $rangePage = 10;
}
if (!isset($radiusSearch)) {
    $radiusSearch = 1;
}
if (!isset($radiusSCH)) {
    $radiusSCH = 5;
}
if (!isset($SEC_LEVEL1)) {
    $SEC_LEVEL1 = false;
}
if (!isset($is_my_realtor)) {
    $is_my_realtor = '';
}
if (!isset($cookie_name)) {
    $cookie_name = 'gta2sell';
}

$domain='gta2sell.ca';
$rimages = 'retsimages';
$featimages = 'featimages';
$image_base = '/'.$rimages;
$cookie_tracker='tr';
$cookie_name='em';
$imgtmb='/timthumb.php?src=';
$property_url='/property.php';
$limit=24;
$radiusSearch=3; #km
$rangePage=10;
$radiusSCH=2;
$fromEmail = 'realtor@'.$_SERVER['SERVER_NAME'];
$toEmail = 'user.fam@gmail.com';
$BEARER_TOKEN="ldskfsf"
function err_log($msg, $fl="-"){
    global $_SERVER;
    $error_log="/tmp/error.log";
    $time = date('Y-m-d\TH:i:s');
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    error_log($time." ERROR ".$_SERVER['REMOTE_ADDR']." \"".$msg."\" ".$fl." ".$actual_link."\n",3,$error_log);
}

function err_log_cli($msg, $fl="-"){
    global $error_log_file;
    global $_SERVER;
    $time = date('Y-m-d\TH:i:s');
    $actual_link = "-";
    error_log($time." ERROR  \"".$msg."\" ".$fl." ".$actual_link."\n",3,$error_log_file);
}

setlocale(LC_MONETARY, 'en_CA');
function escape($value) {
    global $mysqli;
    return  array_map(array($mysqli, 'real_escape_string'), $value);
}

function replace_if_alias($text_to_check,$table_scope=''){
          global $mysqli;
          $where = ($table_scope==''?'':" and table_scope='$table_scope'");
          $pieces = explode(" ", $text_to_check);

          foreach ($pieces as $piece) {
             $al_sql = "select alias from alias WHERE text='$piece'".$where;
            if( $stmt = $mysqli->prepare($al_sql) )
             {
                 $stmt->execute();
                 $al_result = $stmt->get_result();
                 $al_row = $al_result->fetch_array();
                 $text_to_check = str_replace($piece,$al_row['alias'],$text_to_check);
             }
           }

          return $text_to_check;
 }

function jump_to_zip_if_exist($text_to_check,$table_scope=''){
          global $mysqli;
          $where = ($table_scope==''?'':" and table_scope='$table_scope'");
          $pieces = explode(" ", $text_to_check);
#print($text_to_check."\n");
          $ret='';
          foreach ($pieces as $piece) {
             $al_sql = "select alias from alias WHERE text like '$piece%'".$where ;
             if( $stmt = $mysqli->prepare($al_sql) )
             {
                 $stmt->execute();
                 $al_result = $stmt->get_result();
                 $ret = $al_result->fetch_array();
             }
           }
                return $ret;
 }
