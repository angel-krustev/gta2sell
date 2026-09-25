<?php
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
         #$_GET['ml_num']='W3456857';
         #$_GET['ml_num']='W3450230';

         #if(isset($_GET['addr']))
         # {
         #   $addr = preg_replace('/-/',' ', $_GET['addr']);
            //If they did not enter a search term we give them an error
         #}
        # if(isset($_GET['ml_num']))
        #  {
        #    $ml_num =$_GET['ml_num'];
            //If they did not enter a search term we give them an error
        # }
        # if ( !( isset($_GET['addr']) or isset($_GET['ml_num']) ) )
        # {
        #    echo "<p>You forgot to enter a search term!!!";
        #    exit;
        # }

         if ( ( ( !isset($addr) || $addr == "" ) || (!isset($ml_num) || $ml_num == "") )  && (  !isset($municipality) || $municipality  == "" ) )
         {
            err_log("Missing parameters addr and municipality",__FILE__);
            include 'opps.php';
            exit;
         }
$geocoder->registerProvider($chain);
include 'header-property.php';
?>
<!--         <div class="uk-container uk-container-center uk-grid-medium"> --!>
<?php 
$is_social_like='Y';
include 'res_template.php';
include 'form-like.php';
?>
<!--         </div>  --!>
<?php 
include 'footer.php';
?>
