<body  class="tm-background"  >
<?php
$p = isset($param)?$param:'ltf';

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

            <div class="uk-grid">
                <div  class="uk-width-3-4">
<?php

   if( !isset($p) || $p == 'ltf' ){
?>

		      <div class="ratehub" style="max-width: 825px; margin: 0 auto;">
			<div id="payment-calc-widget"></div>
			<div style="position: relative; height: 20px;">
			<div style="position: absolute; right: 0px; top: -15px;">Mortgage calculator by <a style="text-decoration: none;" href="https://www.ratehub.ca/"><img style="border: none;" src="https://www.ratehub.ca/images/logo-small-right.png" alt="ratehub.ca" /></a></div>
			</div>
			<p><script id="payment-calc-script" src="https://www.ratehub.ca/widgets/payment-calc.js?htmlid=payment-calc-widget&amp;ltt=only&amp;lang=en&amp;province=ON&amp;city=toronto" type="text/javascript"></script></p>
                      </div>
<?php 
   }else if ($p == 'mpc' ){
?>

         	      <div class="ratehub" style="max-width:825px;margin:0 auto;">
                           <div id="payment-calc-widget">&nbsp;</div>
			   <div style="position:relative;height:20px;">
			      <div style="position:absolute;right:0px;top:-15px;">Mortgage calculator&nbsp;by&nbsp;<a href="https://www.ratehub.ca/" style="text-decoration:none"><img src="https://www.ratehub.ca/images/logo-small-right.png" alt="ratehub.ca" style="border:none" /></a></div>
			   </div>
			   <p><script id="payment-calc-script" type="text/javascript"src="https://www.ratehub.ca/widgets/payment-calc.js?htmlid=payment-calc-widget&#038;lang=en&#038;province=ON"></script>
                      </div>

<?php 
   }else if ($p == 'cmhc' ){
?>
		      <div class="ratehub" style="max-width:825px;margin:0 auto;">
			  <div id="payment-calc-widget">&nbsp;</div>
			  <div style="position:relative;height:20px;">
	  		      <div style="position:absolute;right:0px;top:-15px;">Mortgage calculator&nbsp;by&nbsp;<a href="https://www.ratehub.ca/" style="text-decoration:none"><img src="https://www.ratehub.ca/images/logo-small-right.png" alt="ratehub.ca" style="border:none" /></a>
                              </div>
                          </div>
                          <p><script id="payment-calc-script" type="text/javascript"src="https://www.ratehub.ca/widgets/payment-calc.js?htmlid=payment-calc-widget&#038;cmhc=only&#038;lang=en&#038;province=ON"></script>
                     </div>
<?php 
   }
?>

                </div>
                <div  class="uk-width-1-4 uk-hidden-small">
	            <div class="uk-grid"  style="margin-right: 5px">
        	       	 <div class="uk-width-1-1" >
                	 	<?php include 'elza-contact-v.php' ?>
               		 </div>
      		     </div>
                </div>
            </div>
