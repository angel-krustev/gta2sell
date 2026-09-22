<?php
/**
 * New Postgres-backed config bootstrap (replaces the old MySQL config.php).
 * Include this from pages that need $mysqli / $RES / image URL helpers.
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/image_helper.php';
require_once __DIR__ . '/legacy_helpers.php';

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
