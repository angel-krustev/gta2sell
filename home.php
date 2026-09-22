<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);

#require_once '../config/config.php';
#require_once '../config/func.php';
#require_once 'signup/includes/main.php';

use Geocoder\Model\AddressFactory;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\CurlHttpAdapter;
$region=$sourceCountry="CA";
$locale="en-CA";
$useSsl="no";
$version = 3;

#session_start();
$form_action="/list.php";
$is_radius=true;
         if(isset($_GET['addr']))
         {
         #   $addr =$_GET['addr'];
         }
?>

<html>
  <head lang="en-ca" dir="ltr">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elza Krusteva - Realtor - GTA - Toronto - Realtor in Toronto and GTA Area </title>
    <meta name="description" content="<?php echo $PageDescription ; ?>"/>
    <!-- Additional tags here -->
    <?php if (function_exists('customPageHeader')){
      customPageHeader();
    }?>

        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/uikit.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slideshow.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slider.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/slidenav.gradient.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/css/components/dotnav.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slider.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideshow-fx.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/sticky.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.25.0/js/components/slideset.min.js"></script>
        <script src="/js/jquery.maskedinput-1.3.1.min_.js"></script>
        <script src="/js/cookie.js"></script>
        <script src="/js/jquery.inputfocus-0.9.min.js"></script>



    </head>

    <body>

        <div class="uk-container uk-container-center uk-margin-top-remove uk-margin-large-bottom">
           <img src="images/home/header.png" title="Elza Krusteva - Realtor"   alt="Elza Krusteva - Realtor"  >
           <?php include 'nav-home.php';     ?>
           <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">

                    <div class="uk-vertical-align uk-text-center" style="background: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMTEzMHB4IiBoZWlnaHQ9IjQ1MHB4IiB2aWV3Qm94PSIwIDAgMTEzMCA0NTAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDExMzAgNDUwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSIxMTMwIiBoZWlnaHQ9IjQ1MCIvPg0KPC9zdmc+DQo=') 50% 0 no-repeat; height: 450px;">
                     <div class="uk-vertical-align-middle uk-width-1-1">
                       <div id="slideshow" data-uk-slideshow="{width:1000,height: 450,autoplay:true,autoplayInterval:4000}">
                        <div class="uk-slidenav-position">
                            <ul class="uk-slideshow">
                                <li><img src="images/home/home-5.jpg"  alt=""  ></li>
                                <li><img src="images/home/home-1.jpg"  alt=""  ></li>
                                <li><img src="images/home/home-2.jpg"  alt=""  ></li>
                                <li><img src="images/home/home-3.jpg"  alt=""  ></li>
                                <li><img src="images/home/home-4.jpg"  alt=""  ></li>
                                <li><img src="images/home/home-6.jpg"  alt=""  ></li>
                            </ul>
                            <a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                            <a href="#" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                        </div>
                       </div>
                     </div>
                    </div>
                </div>
            </div>
            <hr class="uk-grid-divider">

            <div class="uk-grid" data-uk-grid-margin>

                <div class="uk-width-medium-2-10">
                    <img width="130" height="176" src="/images/elza-home.jpg" alt="">
                </div>
                <div class="uk-width-medium-8-10">
                   <div class="uk-grid uk-margin-small-left">
                     <div class="uk-width-medium-1-1 uk-panel uk-panel-box uk-panel-box-primary">
                        <p class="uk-text-justify uk-text-large">
                         <strong>As your agent I can offer you dedication and loyalty.</strong><br>I promisse, I will give you the best advice and will help you make the best choice for you and your family.</p>
                        <p><a class="uk-button uk-button-primary uk-margin-left" href="/contact">Contact Me</a>
                    </div>
                   </div>
                </div>
                <div class="uk-width-medium-1-1">
                    <p class="uk-text-justify  uk-text-large">Trying to find your dream home? Use <a href="/real-estate-search">Map Search</a> to browse an up-to-date database list of all available properties in the area, or use my <a href="/real-estate-listings" >Home Finder Search Engine</a>. If you have any special requirements, please contact me and I'll conduct a personalized search for you.</p>
                    <p class="uk-text-justify  uk-text-large">If you're planning to sell your home in the next few months, nothing is more important than knowing a fair asking price. I would love to help you with a <a  class="uk-text-bold"  href="/what-is-my-home-worth" >FREE ONLINE PROPERTY VALUATION</a>. I will use comparable sold listings to help you determine the accurate market value of your home.</p>
                </div>
            </div>


                <?php include 'inc_openhouse.php';     ?>


            <hr class="uk-grid-divider">

            <h1 class="uk-text-center">Featured Properties</h1>
            <div class="uk-grid" data-uk-grid-margin>
                 <?php $start_mybroker=0     ?>
                 <?php include 'inc_mybroker.php';     ?>
                 <?php $start_mybroker=50     ?>
                 <?php include 'inc_mybroker.php';     ?>
                 <?php $start_mybroker=100     ?>
                 <?php include 'inc_mybroker.php';     ?>
            </div> 
            <h1 class="uk-text-center">Featured Listings</h1>
            <div class="uk-grid" data-uk-grid-margin>
                 <?php include 'inc_featured.php';     ?>
            </div>
            <hr class="uk-grid-divider">

            <div class="uk-grid" data-uk-grid-margin>

                <div class="uk-width-medium-1-1 uk-text-center">
                    <h1>Client’s testimonials</h1>
                </div>
                <div class="uk-width-medium-1-3">
                    <img width="300" height="200" src="/images/happy-newhomeowners.png" />
                </div>

                <div class="uk-width-medium-2-3">
                    <div style="overflow-y: scroll; height: 300;" >
<p class="uk-panel uk-panel-box uk-panel-box-primary uk-text-muted uk-margin-right">
Dear Elza,
</br>
Our family and I would like to take a minute to acknowledge the outstanding service we received from you. 
</br>
From the moment you stepped into Mom’s home we felt as ease with you. Your confidence, honesty and positivity shone through. 
</br>
You and your team took great care of our home while it was being viewed. It didn’t take long for Mom’s home to sell, in fact it’s sold for over asking.
</br>
My Mother and family were elated, and very happy with the outstanding service you provided. 
</br>
Even though we haven’t known each other for long you felt more like family than a realtor.
</br>
I love that we still remain in touch and hope that you will stop by for coffee and a chat.
</br>
We miss seeing you.
</br>
Big hugs from our whole family
</br>
Stella, Irene, Diana and Rick
</p>
<p class="uk-panel uk-panel-box uk-panel-box-primary uk-text-muted uk-margin-right">
Elza, We want to thank you for your professional help: thorough search for the house within required range and defined geographic area, assistance through entire purchasing process from scheduling the house visits, offer process, home inspection, till the closing.
Thank you for your hard work and assistance in renting out the property. We really relied on your expertise, and we are happy that we've chosen you for both types of real estate needs.

<br>
- Yuri & Nina
</p>
<p class="uk-panel uk-panel-box uk-panel-box-primary uk-text-muted uk-margin-right">

Elza, we wanted to say a big Thank You for all your help with finding our new home. You are very patient,  professional and organized. We really appreciate that you always had everything under control - you appointed time convenient for us, you arranged for access in advance and we never had to wait. 
You have never pushed us to buy a home that we  didn't like as other agents did. We felt that you are on our side and always gave us your honest opinion. Next time we need help with buying/selling you are the one who we go to. :) We will recommend you to all our friends who are interested in buying/selling their home. 
Thanks for the positive experience with our first home buying.

<br>
- Irina and Khursh
</p> 
<p class="uk-panel uk-panel-box uk-panel-box-primary uk-text-muted uk-margin-right">
We would like to tank you once again for the amazing job you did for us and for your great services. You were in great help when it came to finding our first home. We are very pleased that we met you and worked with you. We  also  highly appreciate your professional services and we gladly would  recommend  you to all our friends. It has been a great pleasure working with you.  Thanks.
<br>
- Vili and Lachezar
</p> 

<p class="uk-panel uk-panel-box uk-panel-box-primary uk-text-muted uk-margin-right">
We bought our first house with Elza Krusteva. She is a very professional and a very nice person to do business with. We highly recommend her services to everyone who cannot find the house they desire, with Elza you will do this quickly and easily.
<br>
- Irina and Vladimir
</p> 
                            </div>
                    </div>

                </div>

            </div>

         <?php 
              include 'footer.php'; 
              include 'js-of.php';
         ?>

        </div>

        <div id="offcanvas" class="uk-offcanvas">
            <div class="uk-offcanvas-bar">
                <ul class="uk-nav uk-nav-offcanvas">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/real-estate-listings">Listings</a>
                    </li>
                    <li>
                        <a href="/real-estate-search">Map</a>
                    </li>
                    <li>
                        <a href="/what-is-my-home-worth">What is my Home Worth</a>
                    </li>
                    <li class="uk-active">
                        <a href="/tools">Tools</a>
                    </li>
                    <li>
                        <a href="/contact">Contact</a>
                    </li>
                    <li>
                        <a href="/profile">Profile</a>
                    </li>
                </ul>
            </div>
        </div>


    </body>
</html>
