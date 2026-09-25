<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

#require_once 'vendor/autoload.php';
#require_once '../config/config.php';
#require_once '../config/legacy_helpers.php';
#require_once 'signup/includes/main.php';

use Geocoder\Model\AddressFactory;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\CurlHttpAdapter;
$region=$sourceCountry="CA";
$locale="en-CA";
$useSsl="no";
$version = 3;
/*
$adapter     = new \Ivory\HttpAdapter\CurlHttpAdapter();

$geocoder = new \Geocoder\ProviderAggregator();


            $chain = new \Geocoder\Provider\Chain([
               #new \Geocoder\Provider\BingMaps($adapter, $keys['bing']),
                new \Geocoder\Provider\GoogleMaps($adapter),
                new \Geocoder\Provider\Nominatim($adapter, "http://nominatim.openstreetmap.org/search"),
               # new \Geocoder\Provider\MapQuest($adapter, $keys['mapquest'], true),
               # new \Geocoder\Provider\ArcGISOnline($adapter),
                //new \Geocoder\Provider\GeocoderCaProvider($adapter, $geocoderCaKey), // geocoder-extra hasn't been updated
            ]);
*/

         if(isset($_GET['addr']))
          {
            $addr=$_GET['addr'];
            if ($addr == "")
            {
            echo "<p>You forgot to enter a search term!!!";
            exit;
            }
         }
#include 'header-main.php';
include 'header-list.php';
include 'footer.php';
?>
