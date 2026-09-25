<?php
#session_start();
$form_action="/real-estate-listings";
$is_radius=true;
         if(isset($_GET['addr']))
         {
         #   $addr =$_GET['addr'];
         }
?>
<!doctype html>
<html>
  <head lang="en-ca" dir="ltr">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $PageTitle; ?></title>
    <meta name="description" content="<?php echo $PageDescription ; ?>"/>
    <!-- Additional tags here -->
    <?php if (function_exists('customPageHeader')){
      customPageHeader();
    }?>


        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/form-select.gradient.min.css" />
        <link href="/css/nouislider.css" rel="stylesheet">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/sticky.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/form-select.min.js"></script>

        <script src="/js/jquery.maskedinput-1.3.1.min_.js"></script>
        <script src="/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
        <script src="/js/cookie.js"></script>
        <script src="/js/jquery.inputfocus-0.9.min.js"></script>

<?php
 include 'google_analytics.php';
?>


    <script type="text/javascript">

      var ulat="";
      var ulon="";

      function imgError(image) {
           image.onerror = "";
           image.width = "600";
           image.height = "400";
           image.src = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjAwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2MDAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yMjguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjI4LjE4NHogTTM2MC4yNDQsMjQ0LjI0N0gyNDAuNDM3di04OC40OTRoMTE5LjgwOEwzNjAuMjQ0LDI0NC4yNDcNCgkJTDM2MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI0Ni44ODEsMjM0LjcxNyAyNzEuNTcyLDIwOC43NjQgMjgwLjgyNCwyMTIuNzY4IDMxMC4wMTYsMTgxLjY4OCAzMjEuNTA1LDE5NS40MzQgDQoJCTMyNi42ODksMTkyLjMwMyAzNTQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjI3NS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K";
           return false;
     }

    </script>
     <style>
      #map {
        height: 40%;
      }


            .currencyLabelMin { display:block; }  
            #slider .ui-slider-range { background: #00AFF2; }
            .noUi-connect { background: #00AFF2; }

            .currencyLabelMax { display:block; }  
            img {
                border: 0;
            }
.rlabels {
     color: red;
     background-color: white;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 10px;
     font-weight: bold;
     text-align: center;
     width: 50px;
     border: 0px;
     white-space: nowrap;
   }
.labels {
     color: black;
     background-color: white;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 10px;
     font-weight: bold;
     text-align: center;
     width: 50px;
     border: 0px;
     white-space: nowrap;
   }

.blabels {
     color: #008CFF;
     background-color: white;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 10px;
     font-weight: bold;
     text-align: center;
     width: 50px;
     border: 0px;
     white-space: nowrap;
   }


.clabels {
     color: black;
     background-color: none;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 12px;
     font-weight: bold;
     text-align: center;
     width: 50px;
     border: 0px;
     white-space: nowrap;
     z-index: 0;
   }

.pac-container:after{display:none !important;}

   .uk-navbar { padding: 10px 0;}
   .blend { outline: none; border: none; }
         </style>
</head>
<body  onload="onLoad('fc'); onLoad('st1');onLoad('st2');onLoad('pg')"  class="tm-background"  >

<?php
 include 'js-form-header.php';
 include 'js-pagination.php';
 include 'js-of.php'; 
?>

<script src="/js/nouislider.min.js"></script>
<?php

if( isset($_COOKIE[$cookie_name]) ){
   $cookie = base64_decode($_COOKIE[$cookie_name]); 
   $_SESSION['email'] =  $cookie;
   $email = $cookie;

   if (!isset($_SESSION['phone']) || !isset($_SESSION['full_name']) ){
         $user = User::findByEmail($cookie);
   }

   if (isset($_SESSION['phone'])){
          $phone = $_SESSION['phone'];
   }else{
          $phone = $user->phone;
          $_SESSION['phone']=$user->phone;
   }

   if (isset($_SESSION['full_name'])){
          $full_name = $_SESSION['full_name'];
   }else{
          $full_name = $user->full_name;
          $_SESSION['full_name']=$user->full_name;
   }

} else {
unset($_SESSION['email']);
unset($_SESSION['phone']);
unset($_SESSION['full_name']);

}
?>


<script type='text/javascript'>
$('document').ready(function() {
    $('#phone').mask("999-999-9999");
    $('#ph').mask("999-999-9999");
    $('#cph').mask("999-999-9999");
});

</script>

<script type='text/javascript'>//<![CDATA[
var modal = UIkit.modal("#mfilter");
</script>
<?php
include 'price-slider.php';
?>
<!-- NAV --!>
<?php
$formsticky='';
$navsticky='data-uk-sticky';
?>

<?php 
include 'nav-main.php'
?>
<!-- NAV --!>
            <!-- #START FORM GRID --!>
            <div class="uk-grid" >
                <div id="fc-form" class="uk-width-1-1">
                </div>
            </div>

<!-- SPINNER --!>
            <div class="uk-grid uk-margin-top-remove">
                 <div class="uk-width-medium-1-1" >
                    <div style="display: none; overflow-y: scroll;" aria-hidden="true" id="modal-spinner" class="uk-modal">
                            <div class="uk-container uk-container-center">
                             <div class="uk-modal-dialog uk-text-center">
<i class="uk-icon-large uk-icon-spinner uk-icon-spin"></i>
                             </div>
                          </div>
                    </div>
                 </div>
            </div>

<!-- SPINNER --!>



       <div class="uk-grid uk-margin-top-remove uk-margin-right uk-margin-left">
              <div id="totals" class="uk-width-1-2 uk-text-left uk-text-large">
              </div>
              <div class="uk-width-1-2 uk-text-right">
  <!-- social--!>
                    <?php include 'social-line.php' ?>
  <!-- social--!>
           </div>
              <div id="list" class="uk-width-1-1"></div>
              <div id="pagination" class="uk-width-1-1  uk-margin"></div>
              <div id="modalList" class="uk-width-1-1"></div>
              <div class="uk-width-1-1"><br/></div>
              <div id="map" class="uk-width-1-1 uk-container-center" style="height:300px; width: 80%;"> </div> 
              <div class="uk-width-1-1"><form name="pg" id="pg" action="" method="post" ><input id="s" name="s" type="hidden"/></form></div> 
      </div>

<?php
include 'form-main.php';
include 'get_list.php';
include 'js-autocompete-search.php';
include 'form-like.php';
?>
        <script type="text/javascript" src="/js/markerwithlabel.js"></script>

                <script>
                   var script = '<script type="text/javascript" src="/js/markerclusterer';
                      if (document.location.search.indexOf('compiled') !== -1) {
                        script += '_compiled';
                      }
                      script += '.js"><' + '/script>';
                      document.write(script);
                </script>

