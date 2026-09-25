<?php 
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
?>
<!DOCTYPE html>
<html lang="en-us" dir="ltr" class="uk-height-1-1">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,height: 55px,initial-scale=1">
        <title>Track Your Market Value</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="/css/uikit.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/form-select.gradient.min.css" />
         <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>

        <style>
        .uk-panel-box {
             border: 0px;
         }
         .ifld  {
             display: none;
         } 
         div.uk-text-head{
           font-size: 46px;
           font-weight: bold;
           line-height: 100%;
           text-align: center;
         }
         
         div.uk-text-head-small{
           font-size: 28px;
           font-weight: bold;
           line-height: 100%;
           text-align: center;
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
           margin-left: -512px; }
         }
         .uk-button-large {
             min-height: 60px;
             padding: 0 15px;
             line-height: 58px;
          }

         #addr {
             height: 50px;
             font-size: 20px;
          }





        </style>

    </head>

  <body class="uk-height-1-1">
 <?php unset($_SESSION['what_it_worth']) ; ?>
    <img class="bg" src="/images/woman-tablet.jpg" >
    <div class="uk-height-1-1 uk-text-center uk-vertical-align-middle uk-margin-large-left uk-margin-large-top"  id="addr-space" >
                         <div id="szf" class="uk-panel uk-panel-box uk-vertical-align-middle" style="width: 500px;">
                               <div id='tf' class="uk-text-head uk-margin-bottom"><span style="color: #28B848;" >How Much</span> is your home worth ?</div>
                                  <div class="uk-panel uk-panel-box" style="background-color: #DFF2F6">
                                    <div id='sm' class="uk-text uk-text-large uk-margin-bottom uk-text-muted">Are you thinking about selling? Your home might be worth more than you think!
                                    </div>
                                    <form class="uk-form" id="addr-form" name="addr-form" method="post" action="/reg-what-is-my-home-worth"  >
                                       <div class="uk-form-row">
                                          <input type="text"  name="firstname" id="firstname" class="ifld">
                                          <input class="uk-width-1-1 uk-form-large" type="text" id="addr" name="addr" onchange="isChanged=true;" placeholder="Enter Property Address">
                                          <input id="at" name="at" type="hidden" value="<?php echo generateFormToken('addr-form')?>" >
                                          <input type="hidden"  name="ulat" id="ulat">
                                          <input type="hidden"  name="ulon" id="ulon">
                                          <input type="hidden"  name="street_number" id="street_number">
                                          <input type="hidden"  name="tk" value="<?php print sha1(get_encode_key());?>" >
                                          <input type="hidden"  name="street" id="street">
                                          <input type="hidden"  name="city" id="city">
                                          <input type="hidden"  name="province" id="province">
                                          <input type="hidden"  name="country" id="country">
                                          <input type="hidden"  name="postal_code" id="postal_code">
                                       </div>
                                       <div class="uk-form-row uk-margin-small">
                                          <a id="addr-button" class="uk-width-1-1 uk-margin-small uk-button uk-button-success" href="#" style="font-size: 30px; font-weight: bold;">Get my FREE Estimate</a>
                                       </div>
                                       <div class="uk-form-row"><span  class="uk-text">NO CALLS from Agents - It is an INSTANT ONLINE estimate!</span></div>
                                       <div class="uk-form-row uk-text-small" id="error"></div>
                                     </form>
                                  </div>
                          </div>
                          <div class="uk-block">
                               <p class="uk-text-small uk-text-left" style="margin: 10px;color:white;font-size: 10px; line-height:105%; ">
                                                 Elza Krusteva, Realtor , Direct: 647-890-0978 <br>Right at Home Realty, Brokerage,  1396 Don Mills Rd., #B121 Toronto, ON M3B 0A7<br>
                                                  © 2017 All rights Reserved | <a  style="color: #FFFFFF;  text-decoration: underline;"  href="#modal-p"  data-uk-modal="{center:true}">Privacy Policy</a> | <a style="color: #FFFFFF;  text-decoration: underline;"  href="#modal-d"  data-uk-modal="{center:true}">Disclaimer</a></p>
                          </div>

    </div>
<script type=text/javascript>
 var isChanged=false;
 var placeSearch, autocomplete,bLat,bLon,bAddr,aLat,aLon,aAddr;
 var aChange = false;
 var kChange = false;
      var componentForm = {
        ulat: 'lat',
        ulon: 'lng',
        addr: 'formatted_address',
      };

      function initAutocomplete() {
            var defaultBounds = new google.maps.LatLngBounds(
                   new google.maps.LatLng(42.052522,-83.109741),
                   new google.maps.LatLng(45.626204,-74.864502)
                   )

              var options = {
                   componentRestrictions: {country: 'ca' },
                   bounds: defaultBounds
                  }

        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('addr')), options);

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);

      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
            aChange = true;
        var postal_code,route,city,province; 
        var location= place.geometry.location;
                       for (var i = 0; i < place.address_components.length; i++) {
                            for (var j = 0; j < place.address_components[i].types.length; j++) {

                                if (place.address_components[i].types[j] == "street_number") {
                                    street_number = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "route") {
                                    street = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "locality") {
                                    city = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "postal_code") {
                                    postal_code = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "country") {
                                    country = place.address_components[i].long_name;
                                }
                                if (place.address_components[i].types[j] == "administrative_area_level_1") {
                                    province = place.address_components[i].long_name;
                                }
                             }
                        }
                       //onSubmit(curFrm,5256000);
                       $("#ulat").val(location.lat());
                       $("#ulon").val(location.lng());
                       $("#street_number").val(street_number);
                       $("#street").val(street);
                       $("#city").val(city);
                       $("#postal_code").val(postal_code);
                       $("#province").val(province);
                       $("#country").val(country);
                       $("#error").html("");
                       validateForm();
      }

      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
      function isAddrOK() {
          var retOk = ( (kChange == aChange ) || aChange );
          kChange=aChange=false;
          return retOk;
      }
      function onChange(){
               kChange = true;
      }

      function validateForm(){
              
      //    $("#addr-button").on("click", function()
       //     {
              
              var addr = $("#addr").val();
              var ulat = $("#ulat").val();
              var ulon = $("#ulon").val();
              if (addr == "" || ulat == "" || ulon == ""  ){
                 if( isChanged ){
                  $("#error").html("<div class=\"uk-alert uk-alert-danger\">Please enter a valid address.</div>");
                 }
                  return true;
              }else{
                  document.getElementById("addr-form").submit();
                  return false;
              }
              
        //   });
       }

      function getScreenSize(){
              if ( $(window).width() < 768) {
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



$('document').ready(function() {

    // generateForm('#F74A27','uk-button-danger');
    // generateForm('#28B848','uk-button-success');
    //generateForm('#F74A27','uk-button-success');
    // generateForm('#28B848','uk-button-success');
         if( getScreenSize() != "small" ){
                    $('#szf').css('width', '500px');
                    $('#tf').addClass('uk-button-large').removeClass('uk-text-head-small')
                    $('#sm').addClass('uk-text-large').removeClass('uk-text')
                    $('#addr-space').addClass('uk-margin-large-left uk-margin-large-top').removeClass('uk-margin-top');
                    $('#addr').css('height','50px');
                    $('#addr').css('font-size','20px');
                    $('#addr-button').css('font-size','30px');
                    $('#addr-button').addClass('uk-button-large');
         }else{
                    var fwidth='350px';
                    if( $(window).width() < 350 ){
                      fwidth='300px';
                    }
                    $('#szf').css('width',fwidth);
                    $('#tf').addClass('uk-text-head-small').removeClass('uk-text-head');
                    $('#sm').addClass('uk-text').removeClass('uk-text-large');
                    $('#addr-space').addClass('uk-margin-top').removeClass('uk-margin-large-left uk-margin-large-top');
                    $('#addr-button').css('font-size','20px');
                    $('#addr-button').removeClass('uk-button-large');
                    $('#addr').css('height','30px');
                    $('#addr').css('font-size','18px');
         }
      $( window ).resize(function() {
         if( getScreenSize() != "small" ){
                    $('#szf').css('width', '500px');
                    $('#tf').addClass('uk-text-head').removeClass('uk-text-head-small')
                    $('#sm').addClass('uk-text-large').removeClass('uk-text')
                    $('#addr').css('height','50px');
                    $('#addr').css('font-size','20px');
                    $('#addr-space').addClass('uk-margin-large-left uk-margin-large-top').removeClass('uk-margin-top');
                    $('#addr-button').css('font-size','30px');
                    $('#addr-button').addClass('uk-button-large');
         }else{
                    var fwidth='350px';
                    if( $(window).width() < 350 ){
                      fwidth='300px';
                    }
                    $('#szf').css('width',fwidth);
                    $('#tf').addClass('uk-text-head-small').removeClass('uk-text-head');
                    $('#sm').addClass('uk-text').removeClass('uk-text-large')
                    $('#addr-space').addClass('uk-margin-top').removeClass('uk-margin-large-left uk-margin-large-top');
                    $('#addr-button').css('font-size','20px');
                    $('#addr-button').removeClass('uk-button-large');
                    $('#addr').css('height','30px');
                    $('#addr').css('font-size','18px');
         }
      });

     validateForm();
});

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXmmJE2W7c10R7LcGQOAH28N4Vbv30VKE&libraries=places&callback=initAutocomplete" async defer></script>

                        <div id="modal-p" class="uk-modal">
                            <div class="uk-modal-dialog uk-modal-dialog">
                                <button type="button" class="uk-modal-close uk-close"></button>
                                    <div class="uk-overflow-container">
<h1>Privacy Policy</h1>
<p>Your privacy is very important to us. Accordingly, we have developed this policy in order for you to understand how
we collect, use, communicate and make use of personal information. The following outlines our privacy policy.</p>
<p>When accessing the https://www.gta2sell.ca website, Elza Krusteva  - Realtor will learn certain
information
about you during your visit.</p>
<p>Similar to other commercial websites, our website utilizes a standard technology called "cookies" (see explanation
below) and server logs to collect information about how our site is used. Information gathered through cookies and
server logs may include the date and time of visits, the pages viewed, time spent at our site, and the websites
visited just before and just after our own, as well as your IP address.</p>
<h3 class="">Use of Cookies</h3>
<p>A cookie is a very small text document, which often includes an anonymous unique identifier. When you visit a
website, that site"s computer asks your computer for permission to store this file in a part of your hard drive
specifically designated for cookies. Each website can send its own cookie to your browser if your browser"s
preferences allow it, but (to protect your privacy) your browser only permits a website to access the cookies it has
already sent to you, not the cookies sent to you by other sites.</p>
<h3 class="">IP Addresses</h3>
<p>IP addresses are used by your computer every time you are connected to the Internet. Your IP address is a number that
is used by computers on the network to identify your computer. IP addresses are automatically collected by our web
server as part of demographic and profile data known as “traffic data” so that data (such as the Web pages you
request) can be sent to you.</p>
<h3 class="">Email Information</h3>
<p>If you choose to correspond with us through email, we may retain the content of your email messages together with
your email address and our responses. We provide the same protections for these electronic communications that we
employ in the maintenance of information received online, mail and telephone. This also applies when you register
for our website, sign up through any of our forms using your email address or make a purchase on this site. For
further information see the email policies below.</p>
<h3 class="">How Do We Use the Information That You Provide to Us?</h3>
<p>Broadly speaking, we use personal information for purposes of administering our business activities, providing
customer service and making available other items and services to our customers and prospective customers.</p>
<p>Elza Krusteva  - Realtor will not obtain personally-identifying information about you when you visit our
site,
unless you choose to provide such information to us, nor will such information be sold or otherwise transferred to
unaffiliated third parties without the approval of the user at the time of collection.</p>
<p>We may disclose information when legally compelled to do so, in other words, when we, in good faith, believe that the
law requires it or for the protection of our legal rights.</p>
<h3 class="">Email Policies</h3>
<p>We are committed to keeping your e-mail address confidential. We do not sell, rent, or lease our subscription lists
to third parties, and we will not provide your personal information to any third party individual, government
agency, or company at any time unless strictly compelled to do so by law.</p>
<p>We will use your e-mail address solely to provide timely information about Elza Krusteva  - Realtor.</p>
<p>We will maintain the information you send via e-mail in accordance with applicable federal law.</p>
<p><strong>CAN-SPAM Compliance</strong></p>
<p>In compliance with the CAN-SPAM Act, all e-mail sent from our organization will clearly state who the e-mail is from
and provide clear information on how to contact the sender. In addition, all e-mail messages will also contain
concise information on how to remove yourself from our mailing list so that you receive no further e-mail
communication from us.</p>
<p><strong>Choice/Opt-Out</strong></p>
<p>Our site provides users the opportunity to opt-out of receiving communications from us and our partners by reading
the unsubscribe instructions located at the bottom of any e-mail they receive from us at anytime.</p>
<p>Users who no longer wish to receive our newsletter or promotional materials may opt-out of receiving these
communications by clicking on the unsubscribe link in the e-mail.</p>
<h3 class="">Use of External Links</h3>
<p>http://gta2sell.ca may contain links to many other websites. Elza Krusteva  - Realtor cannot
guarantee
the accuracy of information found at any linked site. Links to or from external sites not owned or controlled
by Elza Krusteva  - Realtor	do not constitute an endorsement by Elza Krusteva  - Realtor or any of its employees of
the sponsors of these sites or the products or information presented therein.</p>
<p>By accessing this web site, you are agreeing to be bound by these web site Terms and Conditions of Use, all
applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws.
If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials
contained in this web site are protected by applicable copyright and trade mark law.</p>
<h3 class="">Intellectual Property Rights</h3>
<p>All copyrights, trademarks, patents and other intellectual property rights in and on our website and all content and
software located on the site shall remain the sole property of Elza Krusteva  - Realtor or its licensors.
The use
of our trademarks, content and intellectual property is forbidden without the express written consent
from Elza Krusteva  - Realtor.</p>
<p><strong>You must not:</strong></p>
<ul class="">
<li>Republish material from our website without prior written consent.</li>
<li>Sell or rent material from our website.</li>
<li>Reproduce, duplicate, create derivative, copy or otherwise exploit material on our website for any purpose.</li>
<li>Redistribute any content from our website, including onto another website.</li>
</ul>
<h3 class="">Acceptable Use</h3>
<p>You agree to use our website only for lawful purposes, and in a way that does not infringe the rights of, restrict or
inhibit anyone else"s use and enjoyment of the website. Prohibited behavior includes harassing or causing distress
or inconvenience to any other user, transmitting obscene or offensive content or disrupting the normal flow of
dialogue within our website.</p>
<p>You must not use our website to send unsolicited commercial communications. You must not use the content on our
website for any marketing related purpose without our express written consent.</p>
<h3 class="">Restricted Access</h3>
<p>We may in the future need to restrict access to parts (or all) of our website and reserve full rights to do so. If,
at any point, we provide you with a username and password for you to access restricted areas of our website, you
must ensure that both your username and password are kept confidential.</p>
<h3 class="">Use of Testimonials</h3>
<p>In accordance to with the FTC guidelines concerning the use of endorsements and testimonials in advertising, please
be aware of the following:</p>
<p>Testimonials that appear on this site are actually received via text, audio or video submission. They are individual
experiences, reflecting real life experiences of those who have used our products and/or services in some way. They
are individual results and results do vary. We do not claim that they are typical results. The testimonials are not
necessarily representative of all of those who will use our products and/or services.</p>
<p>The testimonials displayed in any form on this site (text, audio, video or other) are reproduced verbatim, except for
correction of grammatical or typing errors. Some may have been shortened. In other words, not the whole message
received by the testimonial writer is displayed when it seems too lengthy or not the whole statement seems relevant
for the general public.</p>
<p style="">Elza Krusteva  - Realtor is not responsible for any of the opinions or comments posted
on https://www.gta2sell.ca. Elza Krusteva  - Realtor is not a forum for testimonials, however provides testimonials as a means for
customers to share their experiences with one another. To protect against abuse, all testimonials appear after they
have been reviewed by management of Elza Krusteva  - Realtor. Elza Krusteva  - Realtor does not
share the
opinions, views or commentary of any testimonials on https://www.gta2sell.ca - the opinions are strictly
the
views of the testimonial source.</p>
<p>The testimonials are never intended to make claims that our products and/or services can be used to diagnose, treat,
cure, mitigate or prevent any disease. Any such claims, implicit or explicit, in any shape or form, have not been
clinically tested or evaluated.</p>
<h3 class="">How Do We Protect Your Information and Secure Information Transmissions?</h3>
<p>Email is not recognized as a secure medium of communication. For this reason, we request that you do not send private
information to us by email. However, doing so is allowed, but at your own risk. Some of the information you may
enter on our website may be transmitted securely via a secure medium known as Secure Sockets Layer, or SSL. Credit
Card information and other sensitive information is never transmitted via email.</p>
<p>Elza Krusteva  - Realtor may use software programs to create summary statistics, which are used for such
purposes
as assessing the number of visitors to the different sections of our site, what information is of most and least
interest, determining technical design specifications, and identifying system performance or problem areas.</p>
<p>For site security purposes and to ensure that this service remains available to all
users, Elza Krusteva  - Realtor	uses software programs to monitor network traffic to identify unauthorized attempts to upload or change
information, or otherwise cause damage.</p>
<h3 class="">Disclaimer and Limitation of Liability</h3>
<p>Elza Krusteva  - Realtor makes no representations, warranties, or assurances as to the accuracy, currency or
completeness of the content contain on this website or any sites linked to this site.</p>
<p>All the materials on this site are provided "as is" without any express or implied warranty of any kind, including
warranties of merchantability, noninfringement of intellectual property or fitness for any particular purpose. In no
event shall Elza Krusteva  - Realtor or its agents or associates be liable for any damages whatsoever
(including,
without limitation, damages for loss of profits, business interruption, loss of information, injury or death)
arising out of the use of or inability to use the materials, even if Elza Krusteva  - Realtor has been
advised of
the possibility of such loss or damages.</p>
<h3 class="">Policy Changes</h3>
<p>We reserve the right to amend this privacy policy at any time with or without notice. However, please be assured that
if the privacy policy changes in the future, we will not use the personal information you have submitted to us under
this privacy policy in a manner that is materially inconsistent with this privacy policy, without your prior
consent.</p>
<p>We are committed to conducting our business in accordance with these principles in order to ensure that the
confidentiality of personal information is protected and maintained.</p>
<h3 class="">Contact</h3>
<p>If you have any questions regarding this policy, or your dealings with our website, please contact us
here: elzarusteva@gta2sell.ca</p>
<p>Elza Krusteva  - Realtor	<br>
Right at Home Realty
<br>
Brokerage<br>

1396 Don Mills Rd., #B121<br>
Toronto, ON M3B 0A7<br>
Direct: 647-890-0978<br>
Phone: 416-391-3232<br>
Fax: 416-391-0319<br></p>


                                   </div>
                              </div>
                         </div>


                        <div id="modal-d" class="uk-modal">
                            <div class="uk-modal-dialog uk-modal-dialog">
                                <button type="button" class="uk-modal-close uk-close"></button>
                                    <div class="uk-overflow-container">
                                             <h1>Disclaimer</h1>
                                             <p>https://www.gta2sell.ca is owned and operated by Elza Krusteva  - Realtor and may contain
                                             advertisements,
                                             sponsored content, paid insertions, affiliate links or other forms of monetization.</p>
                                             <p>https://www.gta2sell.ca abides by word of mouth marketing standards. We believe in honesty of relationship,
                                             opinion and identity. The compensation received may influence the advertising content, topics or posts made in this
                                             blog. That content, advertising space or post will be clearly identified as paid or sponsored content.</p>
                                             <p>Elza Krusteva  - Realtor is never directly compensated to provide opinion on products, services, websites
                                             and
                                             various other topics. The views and opinions expressed on this website are purely those of the authors. If we claim
                                             or appear to be experts on a certain topic or product or service area, we will only endorse products or services
                                             that we believe, based on our expertise, are worthy of such endorsement. Any product claim, statistic, quote or
                                             other representation about a product or service should be verified with the manufacturer or provider.</p>
                                             <p>This site does not contain any content which might present a conflict of interest.</p>
                                             <p>Elza Krusteva  - Realtor makes no representations, warranties, or assurances as to the accuracy, currency or
                                             completeness of the content contain on this website or any sites linked to or from this site.</p>
                                             <h3 class="">Contact</h3>
                                             <p>If you have any questions regarding this policy, or your dealings with our website, please contact us
                                             here: elzakrusteva@gta2sell.ca</p>
                                             <p>Elza Krusteva  - Realtor        <br>
                                             Right at Home Realty
                                             <br>
                                             Brokerage<br>
                                             
                                             1396 Don Mills Rd., #B121<br>
                                             Toronto, ON M3B 0A7<br>
                                             Direct: 647-890-0978<br>
                                             Phone: 416-391-3232<br>
                                             Fax: 416-391-0319<br></p>
                                             <h3 class="">Contact</h3>
                                             <p>If you have any questions regarding this policy, or your dealings with our website, please contact us
                                             here: elzakrusteva@gta2sell.ca</p>
               
                                   </div>
                              </div>
                         </div>
               
                </body>
               
               </html>
