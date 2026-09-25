<?php
define( 'INCLUDE_DIR', dirname( __FILE__ ) . '/' );
require_once 'vendor/autoload.php';
require_once '../config/config.php';
require_once '../config/legacy_helpers.php';
require_once 'signup/includes/functions.php';
require_once 'signup/includes/main.php';
require_once '../config/global.php';
// Overrides $mysqli/$RES from the legacy includes above with the Postgres/IDX connection.

header('Cache-Control: max-age=900');
$ml_num="";
$addr="";
$municipality="";
$street="";
$community="";
$PageTitle = "";
$PageDescription="";
$is_loc_set = false;
#$params = array('ml_num','municipality','community','street','addr');
$params = array('ml_num','municipality','community','street','addr','full_name','email','phone','g_addr','g_token','g_datafield');
$rules = array( 

    'estimation'      => "/e/(?'tk'[\w\-]+)/(?'utm'.*)",                    # // '/post-slug'
    'estimation1'      => "/e/(?'tk'[\w\-]+)",                    # // '/post-slug'
    'home'      => "/home-map-search",                    # // '/post-slug'
    'thank-you'      => "/thank-you",                    # // '/post-slug'
    'thank-you-appointment'      => "/thank-you-appointment",                    # // '/post-slug'
    'mredirect'      => "/mredirect(?'urlParams'.*)",                    # // '/post-slug'
    'reg-what-is-my-home-worth'      => "/reg-what-is-my-home-worth",                    # // '/post-slug'
    'landing'      => "/landing",                    # // '/post-slug'
    'liked'      => "/liked",                    # // '/post-slug'
    'disclaimer'      => "/disclaimer",                    # // '/post-slug'
    'privacy-policy'      => "/privacy-policy",                    # // '/post-slug'
    'calcs-ltf'      => "/land-transfer-tax-calculator",                    # // '/post-slug'
    'calcs-cmhc'      => "/cmhc-calculator",                    # // '/post-slug'
    'calcs-mpc'      => "/mortgage-payments-calculator",                    # // '/post-slug'
    'valid-thx'      => "/valid-thx",                    # // '/post-slug'
    'step1'      => "/step1",                    # // '/post-slug'
    'step2'      => "/step2",                    # // '/post-slug'
    'eml'      => "/eml",                    # // '/post-slug'
    'get_cl_pagination'      => "/get_cl_pagination",                    # // '/post-slug'
    'get_cl_markers'      => "/get_cl_markers",                    # // '/post-slug'
    'get_cl_est-iii'      => "/get_cl_est-iii",                    # // '/post-slug'
    'get_cl_est_landing'      => "/get_cl_est_landing",                    # // '/post-slug'
    'get_cl_est'      => "/get_cl_est",                    # // '/post-slug'
    'get_cl_like'      => "/get_cl_like",                    # // '/post-slug'
    'list'      => "/list",                    # // '/post-slug'
    'mls'   => "/(?'municipality'[\w\-]+)-real-estate/MLS/(?'ml_num'[\w\-]+)",    #// '/picture/some-text/51'
    'my-featured-properties'  => "/my-featured-properties/MLS/(?'ml_num'[\w\-]+)/(?'municipality'[\w\-]+)/(?'addr'[\w\-]+)(?'utm'.*)",    #// '/picture/some-text/51'
    'my-new-featured-properties'  => "/my-new-featured-properties/MLS/(?'ml_num'[\w\-]+)",    #// '/picture/some-text/51'
    'property'   => "/(?'municipality'[\w\-]+)-real-estate/(?'community'[\w\-]+)/(?'addr'[\w\-]+)",    #// '/picture/some-text/51'
    'st'     => "/(?'municipality'[\w\-]+)-home/(?'community'[\w\-]+)/(?'street'[\w\-]+)",             # // '/album/album-slug'
    'com'     => "/(?'municipality'[\w\-]+)-real-estate/(?'community'[\w\-]+)",             # // '/album/album-slug'
    'mun'     => "/(?'municipality'[\w\-]+)-real-estate",             # // '/album/album-slug'
    'category'  => "/category/(?'category'[\w\-]+)",       # // '/category/category-slug'
    'page'      => "/page/(?'page'about|contact)",         # // '/page/about', '/page/contact'
    '/'      => "/",                    # // '/post-slug'
    'map-search'  => "/real-estate-search",                    # // '/post-slug'
    'list'      => "/real-estate-listings",                    # // '/post-slug'
    'my-home-worth'      => "/my-home-worth(?'gclid'.*)",                    # // '/post-slug'
    'what-is-my-home-worth'      => "/what-is-my-home-worth(?'gclid'.*)",                    # // '/post-slug'
    'what-is-my-home-worth-landing'      => "/what-is-my-home-worth-landing",                    # // '/post-slug'
    'what-it-worth'      => "/what-it-worth",                    # // '/post-slug'
    'howmuch'      => "/howmuch",                    # // '/post-slug'
    'contact'      => "/contact"                  # // '/post-slug'
    #'*'      => "/opps"                                     # // '/'
);

$uri = rtrim( dirname($_SERVER["SCRIPT_NAME"]), '/' );
$uri = '/' . trim( str_replace( $uri, '', $_SERVER['REQUEST_URI'] ), '/' );
$uri = urldecode( $uri );
foreach ( $rules as $action => $rule ) {
    if ( preg_match( '~^'.$rule.'$~i', $uri, $params ) ) {
       if($action == 'get_cl_markers'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'get_cl_pagination'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'get_cl_est_landing'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'get_cl_est'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'get_cl_like'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'eml'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'step2'){
        include( INCLUDE_DIR . 'signup/step2.php' );
       }else if($action == 'step1'){
        include( INCLUDE_DIR . 'signup/step1.php' );
       }else if($action == 'property'){
        $addr=isset($addr)?ucwords( str_replace('-',' ',url_cooker($params['addr']) ) ):'';
        $community=isset($community)?url_cooker($params['community']):'';
        $municipality=isset($municipality)?url_cooker($params['municipality']):'';
        $PageTitle = $addr." for sale. Real Estate in (".$community.", ".$municipality." ) for sale - Elza Krusteva - ".$domain;
        $ShortPageTitle = $addr;
        $PageDescription = $addr." for sale. Real Estate in (".$community.", ".$municipality." ) for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'my-new-featured-properties'){
        $ml_num=isset($ml_num)?url_cooker($params['ml_num']):'';
        $addr=isset($addr)?ucwords( str_replace('-',' ',url_cooker($params['addr']) ) ):'';
        $community=isset($community)?url_cooker($params['community']):'';
        $municipality=isset($municipality)?url_cooker($params['municipality']):'';
        $PageTitle = $addr." for sale. Featured Real Estate in (".$community.", ".$municipality." ) for sale - Elza Krusteva - ".$domain;
        $ShortPageTitle = $addr;
        $PageDescription = $addr." for sale. Real Estate in (".$community.", ".$municipality." ) for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR . 'my-featured-properties.php' );

       }else if($action == 'my-featured-properties'){
        $ml_num=isset($ml_num)?url_cooker($params['ml_num']):'';
        $addr=isset($addr)?ucwords( str_replace('-',' ',url_cooker($params['addr']) ) ):'';
        $community=isset($community)?url_cooker($params['community']):'';
        $municipality=isset($municipality)?url_cooker($params['municipality']):'';
        $PageTitle = $addr." for sale. Featured Real Estate in (".$community.", ".$municipality." ) for sale - Elza Krusteva - ".$domain;
        $ShortPageTitle = $addr;
        $PageDescription = $addr." for sale. Real Estate in (".$community.", ".$municipality." ) for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR . $action . '.php' );
         
       }else if($action == '/'){
        $PageTitle = "Elza Krusteva - Realtor - Buy - Sell Properties in Toronto and GTA  - RE/MAX Premier - ".$domain;
        $ShortPageTitle = "Elza - your trusted realtor";
        $PageDescription = "Elza Krusteva - Realtor. If you Want to sell or buy home - contact Elza. Provides Free Home Price Estimation. Best selling strategy -  I will advise your for the best selling startegy - I know how to max the home's price.";
        #include( INCLUDE_DIR . 'home.php' );
        include( INCLUDE_DIR . 'home.php' );
       }else if($action == 'list'){
        $PageTitle = "Search and Browse Properties for Sale in Toronto and GTA - Elza Krusteva - Relator - RE/MAX Premier - ".$domain;
        $ShortPageTitle = "Elza - your trusted realtor";
        $PageDescription = "Elza Krusteva - Realtor. If you Want to sell or buy home - contact Elza. Provides Free Home Price Estimation. Best selling strategy - max your house price. ";
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'map-search'){
        $PageTitle = "Do you want to Search Properties for Sale on the MAP of Toronto and GTA - Elza Krusteva - Relator - RE/MAX Premier - ".$domain;
        $ShortPageTitle = "Elza - your trusted realtor";
        $PageDescription = "Elza Krusteva - Realtor. Do you Want to sell your home on the best price? Do you want to buy a home around the best schools? Contact Elza Krusteva - Your realtor. Provides Free Home Price Estimation. Best selling startegy - I know what to do to max your house's price. ";
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'what-is-my-home-worth-landing'){
        $action = 'what-is-my-home-worth-landing';
        $PageTitle = "Do you want to know how much your house in Toronto or GTA worth? - Home Price Estimation  - Elza Krusteva - ".$domain;
        $ShortPageTitle = "Home Price Estimation";
        $PageDescription = "Automated tool for Home Price Estimation. Real Estate in for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'what-is-my-home-worth'){
        $IS_EXT='y';
        $PageTitle = "Do you want to know how much your house in Toronto or GTA worth? - Home Price Estimation  - Elza Krusteva - ".$domain;
        $ShortPageTitle = "Home Price Estimation";
        $PageDescription = "Automated tool for Home Price Estimation. Real Estates in GTA for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR  . $action . '.php' );
       }else if($action == 'my-home-worth'){
        $IS_EXT='y';
        $PageTitle = "Do you want to know how much your house in Toronto or GTA worth? - Home Price Estimation  - Elza Krusteva - ".$domain;
        $ShortPageTitle = "Home Price Estimation";
        $PageDescription = "Automated tool for Home Price Estimation. Real Estates in GTA for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR  . 'what-is-my-home-worth.php' );
       }else if($action == 'howmuch'){
        $IS_EXT='y';
        $PageTitle = "Do you want to know how much your house in Toronto or GTA worth? - Home Price Estimation  - Elza Krusteva - ".$domain;
        $ShortPageTitle = "Home Price Estimation";
        $PageDescription = "Automated tool for Home Price Estimation. Real Estates in GTA for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR  . 'what-is-my-home-worth.php' );

       }else if($action == 'what-it-worth'){
        $IS_EXT='y';
        $PageTitle = "Do you want to know how much your house in Toronto or GTA worth? - Home Price Estimation  - Elza Krusteva - ".$domain;
        $ShortPageTitle = "Home Price Estimation";
        $PageDescription = "Automated tool for Home Price Estimation. Real Estates in GTA for sale. Provided by Elza Krusteva. See the listed property photos &amp; find your dream home for sale.";
        include( INCLUDE_DIR  . $action . '.php' );

       }else if($action == 'contact'){
        $PageTitle = "Contact - Elza Krusteva - Realtor in Toronto and GTA Area - ".$domain;
        $ShortPageTitle = "Contact Elza";
        $PageDescription = "Contact - Elza Krusteva - Realtor. Want to sell or buy home - contact Elza. How to recieve a Free Home Price Estimation. ";
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'mls'){
        $ml_num=isset($ml_num)?url_cooker($params['ml_num']):'';
        $municipality=isset($municipality)?ucwords(url_cooker($params['municipality'])):'';
        include( INCLUDE_DIR . 'property.php' );
       }else if($action == 'st' ){
        $municipality=isset($municipality)?ucwords(url_cooker($params['municipality'])):'';
        $community=isset($community)?ucwords(url_cooker($params['community'])):'';
        $street=isset($street)?ucwords( str_replace('-',' ',url_cooker($params['street']) ) ):'';
        $latlon=get_st_latlon($municipality,$community,$street);
         
        if(count($latlon) >= 2){
           $lat=$latlon[0];
           $lon=$latlon[1];
           $is_loc_set = true;
           $addr = ucwords( $municipality.", ".$street); 
           $PageTitle = $latlon[4].rtrim(" ".$latlon[5]." ".$latlon[6])." Real Estate for Sale (".$latlon[3].", ".$latlon[2]." ) - Elza Krusteva - ".$domain;
           $ShortPageTitle = $addr;
           $PageDescription = "Browse all real estate listings in ".$latlon[4].rtrim(" ".$latlon[5]." ".$latlon[6]). ". Provided by Elza Krusteva. See the listed properties photos &amp; find your dream home for sale.";
        }
        include( INCLUDE_DIR . 'list' . '.php' );
       }else if($action == 'com' ){
        $municipality=isset($municipality)?ucwords(url_cooker($params['municipality'])):'';
        $community=isset($community)?ucwords(url_cooker($params['community'])):'';
        $latlon=get_community_latlon($municipality,$community);
        if(count($latlon)  >= 2){
           $lat=$latlon[0];
           $lon=$latlon[1];
           $is_loc_set = true;
           $addr = $municipality.", ".$community; 
           $PageTitle = $latlon[3]." Real Estate for Sale (".$latlon[2]." ) -  Elza Krusteva - ".$domain;
           $PageDescription = "Browse all real estate listings in $latlon[3], $latlon[2]. Provided by Elza Krusteva. See the listed properties photos &amp; find your dream home for sale.";
           $ShortPageTitle = $addr;
        }
        include( INCLUDE_DIR . 'list' . '.php' );
       }else if($action == 'mun' ){
        $municipality=isset($municipality)?ucwords(url_cooker($params['municipality'])):'';
        $latlon=get_municipality_latlon($municipality);
        if(count($latlon)  >= 2 ){
           $lat=$latlon[0];
           $lon=$latlon[1];
           $is_loc_set = true;
           $addr = $municipality; 
           $PageTitle = $latlon[2]." Real Estate  -  Elza Krusteva - ".$domain;
           $PageDescription = "Browse all real estate listings in $municipality. Provided by Elza Krusteva . See the listed properties photos &amp; find your dream home for sale.";
           $ShortPageTitle = $addr;
        }
        include( INCLUDE_DIR . 'list' . '.php' );
       }else if($action == 'liked'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'disclaimer'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'privacy-policy'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'landing'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'what-is-my-home-worth-ii'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'reg-what-is-my-home-worth'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'mredirect'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'home-test'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'thank-you'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'thank-you-appointment'){
        include( INCLUDE_DIR . $action . '.php' );
       }else if($action == 'estimation1'){
         $tk=isset($params['tk'])?$params['tk']:'';
        include( INCLUDE_DIR . 'estimation.php' );
       }else if($action == 'estimation'){
         $tk=isset($params['tk'])?$params['tk']:'';
        include( INCLUDE_DIR . 'estimation.php' );
       }else if($action == 'calcs-mpc'){
        $param='mpc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-cmhc'){
        $param='cmhc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-ltf'){
        $param='ltf';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'valid-thx'){
        include( INCLUDE_DIR . $action . '.php' );
       }else{
        include( INCLUDE_DIR . 'opps.php' );
       }
        // exit to avoid the 404 message 
        exit();
    }
}

// nothing is found so handle the 404 error
include( INCLUDE_DIR . 'opps.php' );
        exit();


?>
       }else if($action == 'estimation'){
         $tk=isset($params['tk'])?$params['tk']:'';
        include( INCLUDE_DIR . 'estimation.php' );
       }else if($action == 'calcs-mpc'){
        $param='mpc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-cmhc'){
        $param='cmhc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-ltf'){
        $param='ltf';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'valid-thx'){
        include( INCLUDE_DIR . $action . '.php' );
       }else{
        include( INCLUDE_DIR . 'opps.php' );
       }
        // exit to avoid the 404 message 
        exit();
    }
}

// nothing is found so handle the 404 error
include( INCLUDE_DIR . 'opps.php' );
        exit();


?>
       }else if($action == 'estimation'){
         $tk=isset($params['tk'])?$params['tk']:'';
        include( INCLUDE_DIR . 'estimation.php' );
       }else if($action == 'calcs-mpc'){
        $param='mpc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-cmhc'){
        $param='cmhc';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'calcs-ltf'){
        $param='ltf';
        include( INCLUDE_DIR .'calcs.php' );
       }else if($action == 'valid-thx'){
        include( INCLUDE_DIR . $action . '.php' );
       }else{
        include( INCLUDE_DIR . 'opps.php' );
       }
        // exit to avoid the 404 message 
        exit();
    }
}

// nothing is found so handle the 404 error
include( INCLUDE_DIR . 'opps.php' );
        exit();


?>
