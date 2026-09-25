<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
$addr="";
$region=$sourceCountry="CA";
$locale="en-CA";
$useSsl="no";
$version = 3;
include 'header.php';
?>
<body  class="tm-background"  >
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




<?php
$formsticky='';
$navsticky='data-uk-sticky';
?>


<?php 
include 'nav-main.php';

?>
<!-- NAV --!>
            <!-- #START FORM GRID --!>
            <div class="uk-grid" >
                <div id="fc-form" class="uk-width-1-1">
                </div>
            </div>
            <div class="uk-grid">
                <div  class="uk-width-1-1">
                         <div class="uk-container uk-container-center">
                              <div class="uk-panel uk-margin uk-text-large uk-alert">
                                     <h2>Thank You for your Home Evaluation Request!</h2>
                                      Please check you email <b><?php print $_SESSION['email']  ?></b> where in few minutes you will recieve the online property valuation report.</br></br>You can also take a look at our <a href="/real-estate-search">Map Search</a> or use <a href="/real-estate-listings" >Home Finder</a> to browse our up-to-date database list of all available properties in the desired area.
                              </div>
                          </div>
                </div>
                <div  class="uk-width-1-1 uk-hidden-small">
	            <div class="uk-grid"  style="margin-right: 5px">
        	       	 <div class="uk-width-1-1" >
                	 	<?php # include 'elza-contact-v.php' ?>
               		 </div>
      		     </div>
                </div>
            </div>
<?php

unset($_SESSION['tr']);
unset($_SESSION['what_it_worth']);

include 'footer.php';

?>

