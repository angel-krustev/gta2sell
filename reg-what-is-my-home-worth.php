<?php 
 $addr=$_POST['addr'];
 $lat=$_POST['ulat'];
 $lon=$_POST['ulon'];
 $city=$_POST['city'];
 $country=$_POST['country'];
 $street=$_POST['street'];
 $street_number=$_POST['street_number'];
 $postal_code=$_POST['postal_code'];
 $token=$_POST['tk'];
 if(isset($_SESSION['what_it_worth'] )){
   header("Location:  ".$base_url."/what-is-my-home-worth");
   die();
 }
 $_SESSION['what_it_worth'] = $token;
 $isbot = $_POST['firstname'];
 rate_limit($_SERVER['REMOTE_ADDR']);
?>
<!DOCTYPE html>
<html lang="en-us" dir="ltr" class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Evaluation Request - <?php echo  $addr ?></title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="/css/uikit.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/form-select.gradient.min.css" />
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
                 <script type="text/javascript">

                     /** This section is only needed once per page if manually copying **/
                     if (typeof MauticSDKLoaded == 'undefined') {
                         var MauticSDKLoaded = true;
                         var head            = document.getElementsByTagName('head')[0];
                         var script          = document.createElement('script');
                         script.type         = 'text/javascript';
                         script.src          = 'https://email.nucondo.ca/media/js/mautic-form.js';
                         script.onload       = function() {
                             MauticSDK.onLoad();
                         };
                         head.appendChild(script);
                         var MauticDomain = 'https://email.nucondo.ca';
                         var MauticLang   = {
                             'submittingMessage': "Please wait..."
                         }
                     }
                 </script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/grid.min.js"></script>
        <script src="/js/jquery.maskedinput-1.3.1.min_.js"></script>
        <style>

        #map, #pano {
          float: left;
          height: 200px;
          width: 45%;
        }

        body {
           font-family: 'Lato';
        }
        div.uk-text-head{
           font-size: 26px;
           font-weight: bold;
           line-height: 100%;
           text-align: center;
         }
         div.uk-text-head-small{
           font-size: 20px;
           font-weight: bold;
           line-height: 100%;
           text-align: center;
         }
         .uk-panel-box {
            border: 0px;
         }
         img.bg {
			/* Set rules to fill background */
		min-height: 100%;
		min-width: 1024px;
		
			/* Set up proportionate scaling */
		width: 100%;
		height: auto;
			
			/* Set up positioning */
		position: fixed;
		top: 0;
		left: 0;
          }
		
          @media screen and (max-width: 1080px){
		img.bg {
			left: 50%;
			margin-left: -512px; 
                }
          }

        </style>
</head>

<body class="uk-height-1-1">
<?php
  if( (isset($isbot) && $isbot != '') || !verifyFormToken('addr-form')  ){
?>
          <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/what-is-my-home-worth' ?>'",10); </script>
          die("");
<?php
  }else{
       $cem="-";
       $landing="";
       $sid=$_SESSION['tr'];
       $is_there='N';
       $query = "SELECT * FROM landing WHERE lat = '".$lat."' and lon = '".$lon."' and session = '".$sid."'";
   if( $stmt = $mysqli->prepare($query) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
          $is_there='N';
         err_log('Mysql: [' . $mysqli->error . '] :'.$query ,__FILE__);
         include 'opps-page.php';
       }
   }


     #  $result = mysql_query($query);
     #  $num_rows = mysql_num_rows($result);
     #  if( $num_rows > 1 ) {
     #     $is_there='Y';
     #  }

           $ip_ra=$_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:'-';
           $ip_fw=$_SERVER['HTTP_X_FORWARDED_FOR']!=''?$_SERVER['HTTP_X_FORWARDED_FOR']:'-';
       if( $is_there=='N'){
           $tracksql = "INSERT INTO landing (session,ip_fw,ip_ra,address,cookie_email,landing,token,lat,lon) VALUES ( ?,?,?,?,?,?,?,?,?)";
           if (  $stmt = $mysqli->prepare($tracksql) ){
               $stmt->bind_param("sssssssss",$sid,$ip_fw,$ip_ra, $addr,$cem,$landing,$token,$lat,$lon);
               if ( ! $stmt->execute()) {
                   err_log("Error landing: ".$mysqli->error,__FILE__);
                   err_log("Error landing: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$addr.":".$cem.":".$landing.":".$token.":".$lat.":".$lon,__FILE__);
               }
          }else{
                   err_log("Error landing: ".$mysqli->error,__FILE__);
                   err_log("Error landing: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$addr.":".$cem.":".$landing.":".$token.":".$lat.":".$lon,__FILE__);
          }
       }
  }
?>
<img class="bg" src="/images/woman-tablet.jpg" >

<div class="uk-grid uk-grid-collapse">
  <div  class="uk-width-1-1 uk-hidden-small uk-hidden-medium">&nbsp;</div>
  <div class="uk-width-large-1-3 uk-width-xlarge-1-3 uk-width-medium-1-1 uk-width-small-1-1 uk-height-1-1"  id="szm">
          <div class="" id="pano"></div>
          <div class="uk-hidden-small uk-hidden-medium" id="map"></div>
  </div>
  <div class="uk-width-large-1-3 uk-width-xlarge-1-3 uk-width-medium-1-1 uk-width-small-1-1 uk-height-1-1 uk-text-left"  id="szf">
   <div class="uk-panel uk-panel-box">
     <div class="uk-progress uk-progress-success uk-progress-striped uk-active uk-hidden-small uk-hidden-medium"> <div class="uk-progress-bar" style="width: 50%;">50%</div></div>
      <div class="uk-panel uk-panel-box" style="background-color: #DFF2F6">
       <div class="uk-text-head uk-margin-small-bottom">Address Found!</div>
                 <div class="uk-text-bold uk-margin-small-bottom uk-text-success">
                   <?php print $addr ;?>
                 </div>
                 <div class="uk-margin-small-bottom uk-text uk-text-bold">
                     Tell us more about the property.
                 </div>
          <form autocomplete="false" role="form" method="post" action="https://email.nucondo.ca/form/submit?formId=16" id="mauticform_evaluationrequest" data-mautic-form="mauticform_evaluationrequest"  class="uk-form uk-form-stacked" name="dataform" >
           
               <input id="mauticform_input_evaluationrequest_g_addr1" name="mauticform[g_addr1]" value="<?php echo $addr; ?>" class="mauticform-hidden" type="hidden" />
               <input id="mauticform_input_evaluationrequest_city" name="mauticform[city]" value="<?php echo $city;?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_country" name="mauticform[country]" value="<?php echo $country;?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_postal_code" name="mauticform[postal_code]" value="<?php echo $postal_code;?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_state" name="mauticform[state]" value="<?php echo $state;?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_address" name="mauticform[address]" value="<?php echo $street_number." ".$street;?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_lat" name="mauticform[lat]" value="<?php echo $lat; ?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_lon" name="mauticform[lon]" value="<?php echo $lon; ?>" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_first_name" name="mauticform[first_name]" value="" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_last_name" name="mauticform[last_name]" value="" class="mauticform-hidden" type="hidden" />
                <input id="mauticform_input_evaluationrequest_g_datafield" name="mauticform[g_datafield]" value="" class="mauticform-hidden" type="hidden" />
       <fieldset data-uk-margin>
         <div class="uk-grid">
          <div class="uk-width-2-3 uk-margin-small-bottom">
                 <div class="uk-form-controls">
                   <select id="mauticform_input_evaluationrequest_g_property_type1" name="mauticform[g_property_type1]" value="" class="uk-form-medium uk-width-1-1 mauticform-selectbox">
                    <option value="">Property Type</option>
                    <option value="house">Detached House</option>
                    <option value="semi-detached">Semi Detached House</option>
                    <option value="condo">Condo</option>
                    <option value="townhouse">Townhouse</option>
                    <option value="condo-townhouse">Condo Townhouse</option>
                   </select>
                </div>
          </div>
          <div class="uk-width-1-3 uk-text-left">
               <div class="uk-form-controls">
           <select id="mauticform_input_evaluationrequest_g_planing" name="mauticform[g_planing]" value="" class="uk-form-medium uk-margin-bottom mauticform-selectbox">
                  <option value="">Planing to Sell</option>
                  <option value="now">Now</option>
                  <option value="1-3 months">1-3 months</option>
                  <option value="3-6 months">3-6 months</option>
                  <option value="6+ months">6+ months</option>
                  <option value="Refinancing">Refinancing</option>
                  <option value="Just Looking">Just Looking</option>
           </select>
               </div>
          </div>
          <div class="uk-width-1-3 uk-margin-small-bottom">
               <div class="uk-form-controls">
                 <select id="mauticform_input_evaluationrequest_g_beds1" name="mauticform[g_beds1]" value="" class="uk-form-medium uk-width-1-1  mauticform-selectbox">
                    <option value="">Beds</option>
                    <option value="1">1 bed</option>
                    <option value="2">2 beds</option>
                    <option value="3">3 beds</option>
                    <option value="4">4 beds</option>
                    <option value="5">5+ beds</option>
                 </select>
               </div>
          </div>
          <div class="uk-width-1-3 uk-margin-small-bottom">
               <div class="uk-form-controls">
                <select id="mauticform_input_evaluationrequest_g_baths1" name="mauticform[g_baths1]" value="" class="uk-form-medium mauticform-selectbox">
                    <option value="">Baths</option>
                    <option value="1">1 bath</option>
                    <option value="2">2 baths</option>
                    <option value="3">3 baths</option>
                    <option value="4">4 baths</option>
                    <option value="5">5+ baths</option>
                </select>
               </div>
          </div>
          <div class="uk-width-1-3 uk-margin-small-bottom">
               <div class="uk-form-controls">
                <select id="mauticform_input_evaluationrequest_g_garage1" name="mauticform[g_garage1]" value="" class="uk-form-medium mauticform-selectbox">
                    <option value="0">Garage</option>
                    <option value="1">1 car</option>
                    <option value="2">2 cars</option>
                    <option value="3">3 cars</option>
                    <option value="4">4+ cars</option>
                    <option value="0">None</option>
                </select>
              </div>
          </div>
          <div class="uk-width-2-3 uk-margin-small-bottom">
               <div class="uk-form-controls">
                <select id="mauticform_input_evaluationrequest_g_sqft" name="mauticform[g_sqft]" value="" class="uk-form-medium mauticform-selectbox">
                    <option value="">Size/sqft</option>
                    <option value="0-499">0-499 sqft</option>
                    <option value="500-699">500-699 sqft</option>
                    <option value="700-799">700-799 sqft</option>
                    <option value="800-999">800-999 sqft</option>
                    <option value="1000-1199">1000-1199 sqft</option>
                    <option value="1200-1399">1200-1399 sqft</option>
                    <option value="1600-1849">1600-1849 sqft</option>
                    <option value="1850-1999">1850-1999 sqft</option>
                    <option value="2000-2249">2000-2249 sqft</option>
                    <option value="2250-2499">2250-2499 sqft</option>
                    <option value="2500-2749">2500-2749 sqft</option>
                    <option value="2750-2999">2750-2999 sqft</option>
                    <option value="3000-3499">3000-3499 sqft</option>
                    <option value="3500-4000">3500-4000 sqft</option>
                    <option value="4000+">4000+ sqft</option>
                </select>
             </div>
        </div>

    <div class="uk-text uk-text-bold uk-margin-small-top">Tell us where to send the report.</div>
    <div class="uk-width-1-1">
         <div class="uk-form-row">
                        <input id="mauticform_input_evaluationrequest_full_name" name="mauticform[full_name]" value="" class="uk-form-medium uk-width-2-3 mauticform-input" type="text" placeholder="Full Name" />
         </div>
         <div class="uk-form-row">
        
                        <input id="mauticform_input_evaluationrequest_contact_email" name="mauticform[contact_email]" value="" class="uk-form-medium uk-width-2-3 mauticform-input" type="email"  placeholder="Contact Email" />
         </div>
         <div class="uk-form-row uk-margin-bottom">
                        <input id="mauticform_input_evaluationrequest_contact_phone" name="mauticform[contact_phone]" value="" class="uk-width-1-1 uk-form-medium uk-width-2-3  mauticform-input" type="tel"  placeholder="Contact Phone"  />
         </div>
    </div>
  </div>

 </fieldset>
  <div class="uk-form-row" id="error"></div>

              <button type="submit" name="mauticform[submit]" id="mauticform_input_evaluationrequest_submit" name="mauticform[submit]" class="uk-width-1-1 uk-button uk-button-large uk-button-success" value="1" style="font-size: 30px; font-weight: bold;">Yes, Send me the Report!</button>
 
                <input type="hidden" name="mauticform[formId]" id="mauticform_evaluationrequest_id" value="16"/>
                <input type="hidden" name="mauticform[return]" id="mauticform_evaluationrequest_return" value=""/>
                <input type="hidden" name="mauticform[formName]" id="mauticform_evaluationrequest_name" value="mauticform_evaluationrequest"/>
                <input id="mauticform_input_evaluationrequest_g_token" name="mauticform[g_token]" value="<?php echo $token; ?>" class="mauticform-hidden" type="hidden" />

<div class="uk-text-muted uk-text-small uk-margin-small-top">By clicking above, you confirm that you're interested in receiving updates, invitations, and email offers. You can unsubscribe at any time. Upon submission, you will receive an email with computer generated a home value report.<br>
</div>

     </form>
  </div>
 </div>
 </div>
<div class="uk-block uk-width-1-1">
                               <p class="uk-text-small uk-text-left" style="margin: 10px;color:white;font-size: 10px; line-height:105%; ">
                                                 Elza Krusteva, Realtor , Direct: 647-890-0978 <br>Right at Home Realty, Brokerage,  1396 Don Mills Rd., #B121 Toronto, ON M3B 0A7<br>
                                                  © 2017 All rights Reserved | <a  style="color: #FFFFFF;  text-decoration: underline;"  href="#modal-p"  data-uk-modal="{center:true}">Privacy Policy</a> | <a style="color: #FFFFFF;  text-decoration: underline;"  href="#modal-d"  data-uk-modal="{center:true}">Disclaimer</a></p>
                          </div>

</div>
<?php generateFormToken('dataform'); ?>
 <script type="text/javascript">
  var map;

  function initialize() {
   var myLatLng = {lat: <?php print $lat; ?> , lng: <?php print $lon; ?>};
 
   var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          scrollwheel: false,
          navigationControl: false,
          mapTypeControl: true,
          scaleControl: false,
          fullscreenControl: false,
          draggable: false,
          mapTypeId: 'roadmap',
          streetViewControl: false,
          zoom: 17
        });

      var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title:  '<?php print $addr; ?>'
        });

   var geocoder =  new google.maps.Geocoder();
   geocoder.geocode( { 'address': '<?php echo $addr; ?>' }, function(results, status) {
     
     var lookTo = results[0].geometry.location;
   
      if (status == google.maps.GeocoderStatus.OK) {
     
       var panoOptions = {
        position: lookTo,
        linksControl: false,
        panControl: true,
        enableCloseButton: false,
        fullscreenControl: false,
        zoomControl: true,
        addressControl: false
      };
    
      var pano = new  google.maps.StreetViewPanorama(document.getElementById('pano'),panoOptions);
 
      var service = new google.maps.StreetViewService;
   
      service.getPanoramaByLocation(pano.getPosition(), 50, function(panoData) {
       
        if (panoData != null) {
         
          var panoCenter = panoData.location.latLng;
       
          
          var heading = google.maps.geometry.spherical.computeHeading(panoCenter, lookTo);
        
          var pov = pano.getPov();
          pov.heading = heading;
          pano.setPov(pov);
   
         var marker = new google.maps.Marker({
            map: pano,
            position: lookTo
          });
        } else {
          // no streetview found :(
          console.warn('not found');
        }
      });
    } else {
      console.warn('Could not find your address :(');
    }
  });
}

function initMap() {
        var myLatLng = {lat: <?php print $lat; ?> , lng: <?php print $lon; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          center: myLatLng,
          scrollwheel: false,
          navigationControl: false,
          mapTypeControl: false,
          scaleControl: false,
          draggable: false,
          mapTypeId: 'roadmap',
          zoom: 17
        });
         var heading = google.maps.geometry.spherical.computeHeading(myStreetView.getLocation().latLng, results[0].geometry.location);
         
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('pano'), {
              position: myLatLng,
              pov: {
                heading: 90, pitch: 0
              },
              linksControl: false,
              panControl: true,
              enableCloseButton: false,
              fullscreenControl: false,
              zoomControl: true,
              addressControl: false
            });
        map.setStreetView(panorama);
    var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title:  '<?php print $addr; ?>'
        });

   }

function getScreenSize(){
        if ( $(window).width() <= 960) {
          return "small";
        }
        else if ( $(window).width() < 1000) {
          return "medium";
        }
        else if ( $(window).width() < 1220) {
          return "large";
        }
        else {
          return "xlarge";
        }
}

      function validateForm(){
         $('#mauticform_input_evaluationrequest_submit').on("click", function()
         {
             var ulat = $("#ulat").val();
             var ulon = $("#ulon").val();
             var fullName = $("#mauticform_input_evaluationrequest_full_name").val();
             var phone = $("#mauticform_input_evaluationrequest_contact_phone").val();
             var email = $("#mauticform_input_evaluationrequest_contact_email").val();
             var property_type = $("#mauticform_input_evaluationrequest_g_property_type1").val();
             var beds = $("#mauticform_input_evaluationrequest_g_beds1").val();
             var baths = $("#mauticform_input_evaluationrequest_g_baths1").val();
             var garage = $("#mauticform_input_evaluationrequest_g_garage1").val();
             var size = $("#mauticform_input_evaluationrequest_g_sqft").val();
             var isGood=true;
             if ( typeof(fullName) == "undefined" || fullName == "" ){
                   $('#mauticform_input_evaluationrequest_full_name').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(phone) == "undefined" || phone == "" ){
                   $('#mauticform_input_evaluationrequest_contact_phone').addClass('uk-form-danger');
                   isGood=false;
             } 
             if ( typeof(email) == "undefined" || email == "" ){
                   $('#mauticform_input_evaluationrequest_contact_email').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(property_type) == "undefined" || property_type == "" ){
                   $('#mauticform_input_evaluationrequest_g_property_type1').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(beds) == "undefined" || beds == "" ){
                   $('#mauticform_input_evaluationrequest_g_beds1').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(baths) == "undefined" || baths == "" ){
                   $('#mauticform_input_evaluationrequest_g_baths1').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(garage) == "undefined" || garage == "" ){
                   $('#mauticform_input_evaluationrequest_g_garage1').addClass('uk-form-danger');
                   isGood=false;
             }
             if ( typeof(size) == "undefined" || size == "" ){
                   $('#mauticform_input_evaluationrequest_g_sqft').addClass('uk-form-danger');
                   isGood=false;
             }
             if( isGood ){
              var firstName = fullName.split(' ').slice(0, -1).join(' ');
              var lastName = fullName.split(' ').slice(-1).join(' ');
              var e164_phone =  $('#mauticform_input_evaluationrequest_contact_phone').val().replace(/-/g,'');
                  $("#mauticform_input_evaluationrequest_first_name").val(firstName);
                  $("#mauticform_input_evaluationrequest_last_name").val(lastName);
                  $('#mauticform_input_evaluationrequest_contact_phone').val(e164_phone);
                  $("#error").html("");
              var datafield =  $('#mauticform_input_evaluationrequest_g_property_type1').val()+":"+$('#mauticform_input_evaluationrequest_g_beds1').val()+":"+$('#mauticform_input_evaluationrequest_g_baths1').val()+":"+$('#mauticform_input_evaluationrequest_g_garage1').val()+":"+$('#mauticform_input_evaluationrequest_g_sqft').val()+":"+$('#mauticform_input_evaluationrequest_g_planing').val()+":<?php echo $lat.":".$lon; ?>" ;
              var redirectURL = "https://gta2sell.ca/thankyou?full_name=full_name&contact_email=contact_email&contact_phone=contact_phone&g_addr=g_addr&g_token=g_token";
                  $('#mauticform_input_evaluationrequest_g_datafield').val(datafield);
                  document.getElementById("mauticform_evaluationrequest").submit();
                  return false;
             }else{
                 $("#error").html("<div class=\"uk-alert uk-alert-danger\">Please fill out the highlighted fields.</div>");
             }


         });
       }


$('document').ready(function() {

     $('#mauticform_input_evaluationrequest_contact_phone').mask("+1-999-999-9999");


         if( getScreenSize() != "small" ){
                    $('#szf').css('width', '500px');
                    $('#szm').css('width', '300px');
                    $('#map').css('width', '300px');
                    $('#pano').css('width', '300px');
                    $('#mauticform_input_evaluationrequest_submit').css('font-size','30px');
                    $('.uk-text-head-small').addClass('uk-text-head').removeClass('uk-text-head-small');
         }else{
                    var fwidth='350px';
                    if( $(window).width() < 350 ){
                      fwidth='300px';
                    }
                    $('#szf').css('width',fwidth);
                    $('#szm').css('width',fwidth);
                    $('#map').css('width',fwidth);
                    $('#pano').css('width',fwidth);
                    $('#mauticform_input_evaluationrequest_submit').css('font-size','20px');
                    $('.uk-text-head').addClass('uk-text-head-small').removeClass('uk-text-head');
         }

      $( window ).resize(function() {

         if( getScreenSize() != "small" ){
                    $('#szf').css('width', '500px');
                    $('#szm').css('width', '300px');
                    $('#map').css('width', '300px');
                    $('#pano').css('width', '300px');
                    //$('.').removeClass('uk-grid-collapse');
                    $('#mauticform_input_evaluationrequest_submit').css('font-size','30px');
                    $('.uk-text-head-small').addClass('uk-text-head').removeClass('uk-text-head-small');
         }else{
                    var fwidth='350px';
                    if( $(window).width() < 350 ){
                      fwidth='300px';
                    }
                    $('#szf').css('width',fwidth);
                    $('#szm').css('width',fwidth);
                    $('#map').css('width',fwidth);
                    $('#pano').css('width',fwidth);
                    $('#mauticform_input_evaluationrequest_submit').css('font-size','20px');
                    $('.uk-text-head').addClass('uk-text-head-small').removeClass('uk-text-head');
         }
      });

      validateForm();

});

</script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXmmJE2W7c10R7LcGQOAH28N4Vbv30VKE&libraries=places&callback=initialize" async defer></script> 
 </body>

</html>
