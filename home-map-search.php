<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
#require 'vendor/autoload.php';
$is_my_realtor="Y";
use Geocoder\Model\AddressFactory;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\CurlHttpAdapter;
$addr="";
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
            $addr =$_GET['addr'];
            //If they did not enter a search term we give them an error
            if ($addr == "")
            {
            echo "<p>You forgot to enter a search term!!!";
            exit;
            }
         }
include 'header-map.php';
include 'footer.php';
?>
