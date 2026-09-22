<?php
#require 'vendor/autoload.php';
#include '../config/config.php';
#include '../config/func.php';
#require_once 'signup/includes/main.php';
#

use Geocoder\Model\AddressFactory;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\CurlHttpAdapter;
$region=$sourceCountry="CA";
$locale="en-CA";
$useSsl="no";
$version = 3;
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

$geocoder->registerProvider($chain);
include 'header-property.php';
?>
          <div class="uk-container uk-container-center uk-padding-remove"  > 
<?php 
include 'contact-layout.php';
?>
         </div>
<?php 
include 'footer.php';
?>
