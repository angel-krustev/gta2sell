<?php
#session_start();
$form_action="/real-estate-listings";

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slideshow.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slider.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slidenav.gradient.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slider.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow-fx.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/sticky.min.js"></script>



        <script src="/js/jquery.maskedinput-1.3.1.min_.js"></script>
        <script src="/vendor/jquery.formatCurrency-1.4.0.min.js"></script>
        <script src="/js/cookie.js"></script>
        <script src="/js/jquery.inputfocus-0.9.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/geocomplete/1.6.5/jquery.geocomplete.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXmmJE2W7c10R7LcGQOAH28N4Vbv30VKE&libraries=places" ></script>
        <script type="text/javascript" src="/js/markerwithlabel.js"></script>

    <script type="text/javascript">
      function imgError(image) {
           image.onerror = "";
           image.src = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjAwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2MDAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yMjguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjI4LjE4NHogTTM2MC4yNDQsMjQ0LjI0N0gyNDAuNDM3di04OC40OTRoMTE5LjgwOEwzNjAuMjQ0LDI0NC4yNDcNCgkJTDM2MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI0Ni44ODEsMjM0LjcxNyAyNzEuNTcyLDIwOC43NjQgMjgwLjgyNCwyMTIuNzY4IDMxMC4wMTYsMTgxLjY4OCAzMjEuNTA1LDE5NS40MzQgDQoJCTMyNi42ODksMTkyLjMwMyAzNTQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjI3NS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K";
           return true;
     }
    </script>
<?php
 include 'google_analytics.php';
?>



     <style>
            .currencyLabelMin { display:block; }  
            #slider .ui-slider-range { background: #006699; }
            .currencyLabelMax { display:block; }  
            img {
                  border: none;
            }   
            .valid {
              color: #0000;
            }
            .error {
              color: red;
            }

            .pac-container:after{display:none !important;}
            .uk-navbar { padding: 10px 0;z-index: 2}

            .ft-nav > li > a { color: #777; }
            
            /* Hover */
            .ft-nav > li > a:hover,
            .ft-nav > li > a:focus,
            .ft-nav > li.uk-active > a  {
                background: #F5F5F5;
                color: #444;
            }
            .ft-nav .uk-nav-header {
                color: #222;
                padding-left: 0px;
                font-weight: bold;
            }
            

     </style>
</head>
<body onload="onLoad('st1');onLoad('st2');" >
<?php
 include 'js-form-header.php';
?>

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

/*   PRICE  SLIDER START */
function nFormatter(num) {
     if (num >= pMax) {
        return 'Max';
     }
     if (num >= 1000000) {
        return '$'+(num / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
     }
     if (num >= 1000) {
        return '$'+(num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
     }
     return num;
}

</script>

<?php
$formsticky='';
$navsticky='data-uk-sticky';
?>

<?php
include 'nav-main.php';
include 'js-of.php';
?>
<?php
#include 'form-main.php';
?>
