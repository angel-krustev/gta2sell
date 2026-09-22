<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
$addr="";
$region=$sourceCountry="CA";
$locale="en-CA";
$useSsl="no";
$version = 3;
include 'header.php';
include 'mredirect-page.php';
include 'footer.php';
?>
