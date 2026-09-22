<!-- NAV --!>
        <nav style="z-index:2;" class="uk-navbar uk-navbar-attached" >
                 <a class="uk-navbar-brand uk-hidden-small uk-hidden-medium" href="/"><b>GTA2SELL.CA</b></a>
                 <a class="uk-navbar-brand uk-hidden-small uk-hidden-large uk-hidden-xlarge" href="/"><b><font size="-2">GTA2SELL.CA</font></b></a>
                 <div class="uk-navbar-flip uk-hidden-small">
                 <ul class="uk-navbar-nav uk-hidden-small">
                    <li   class="uk-hidden-medium uk-hidden-small">
                        <a href="/what-is-my-home-worth"><b>WHAT'S MY HOME WORTH?</b></a>
                    </li>
                    <li>
                        <a href="/real-estate-search" ><b>Map</b></a>
                    </li>
                    <li>
                        <a href="/real-estate-listings" ><b>Home Search</b></a>
                    </li>
                    <li class="uk-hidden-large uk-hidden-xlarge uk-hidden-medium uk-hidden-small">
                        <a href="/schools"><b>Schools</b></a>
                    </li>
                    <li aria-expanded="false" aria-haspopup="true" class="uk-parent" data-uk-dropdown="">
                                        <a href=""><b>Tools</b><i class="uk-icon-caret-down"></i></a>
                                        <div style="top: 40px; left: 0px;" class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom">
                                            <ul class="uk-nav uk-nav-navbar">
                                                <li><a href="/land-transfer-tax-calculator">Land Transfer Tax Calculator</a></li>
                                                <li class="uk-nav-divider"></li>
                                                <li><a href="/mortgage-payments-calculator">Mortgage Payment Calculator</a></li>
                                                <li class="uk-nav-divider"></li>
                                                <li><a href="/cmhc-calculator">CMHC calculator</a></li>
                                            </ul>
                                        </div>

                    </li>
                    <li>
                        <a href="/contact"><b>Contact</b></a>
                    </li>
                    <li aria-expanded="false" aria-haspopup="true" class="uk-parent" data-uk-dropdown="">
                                        <a href=""><b>Profile</b><i class="uk-icon-caret-down"></i></a>
                                        <div style="top: 40px; left: 0px;" class="uk-dropdown uk-dropdown-navbar uk-dropdown-bottom">
                                            <ul class="uk-nav uk-nav-navbar">
                                                <li class="uk-nav-divider"></li>
                                                <li><a href="/liked">My Saved Properties</a></li>
                                                <li class="uk-nav-divider"></li>
     <?php
                          if( isset($_COOKIE[$cookie_name]) ){
                        ?>
                               <li><a href="" id="mlogout" >Logout</a></li>
                        <?php
                        }else{
                        ?>
                              <li><a href="#login-modal" data-uk-modal={center:true} >Login/Sign Up</a> </li>
                        <?php
                        }
                        ?>

                                            </ul>
                                        </div>

                    </li>
                  </ul>
                 </div>
                <div id='modal-place'></div>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
        </nav>
<!-- NAV --!>
<script>
     $("document").ready(function() {
         $('#modal-place').html(loginModalList);
         $("#mlogout").click(function(){ deleteCookie("em");location.reload(); return false; });
         $("#mlogout-off").click(function(){ deleteCookie("em"); location.reload();  return false; });


     });

function goBack() {
    window.history.back();
}
                    var login="login";
                    var bimg = "/images/home/home-6.jpg"
                    var loginModalList  = "        <div id=\"login-modal\" class=\"uk-modal\" >\r";
                        loginModalList += "             <div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">\r";
                        loginModalList += "                                            <a href=\"#\" style=\"z-index:1;\"   class=\"uk-modal-close uk-close uk-close-alt\"></a>\r";
                        loginModalList += "                                               <div class=\"uk-grid\" >\r";
                        loginModalList += "                                                 <div class=\"uk-width-medium-1-1\">\r";
                        loginModalList += "                                                   <figure class=\"uk-overlay\">\r";
                        loginModalList += "                                                     <img width=\"600\" height=\"400\" src=\""+bimg+"\" onerror=\"imgError(this);\"  alt=\"\">\r";
                        loginModalList += "                                                         <figcaption class=\"uk-overlay-panel uk-overlay uk-overlay-background\">\r";
                        loginModalList += "                                                             <div id='first_step_"+login+"'>\r";
                        loginModalList += "                                                                <form class=\"uk-form-large\" id=\"s1-"+login+"\" method=\"post\" action=\"/step1\" >\r";
                        loginModalList += "                                                                 <div class=\"form\">\r";
                        loginModalList += "                                                                    <fieldset>\r";
                        loginModalList += "                                                                        <div class=\"uk-width-1-1\">\r";
                        loginModalList += "                                                                              <h3>Sign Up Screen</h3>";
                        loginModalList += "                                                                         </div>\r";
                        loginModalList += "                                                                         <label class=\"uk-form-label\" for=\"email\"><b>Email Address</b></label>\r";
                        loginModalList += "                                                                         <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-envelope\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"email\" id=\"email\" placeholder=\"email@email.com\"   type='text' ></div>\r";
            if( typeof ispass !== 'undefined' && ispass == 'Y'){
                        loginModalList += "                                                                         <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-lock\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"pass\" id=\"pass\" placeholder=\"password\" type='password' ></div>\r";
            }
                        loginModalList += "                                                                         <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        loginModalList += "                                                                         <div class=\"uk-width-1-1\"><input class=\"uk-button uk-button-large uk-button-primary uk-width-1-1\" type=\"submit\" name=\"submit_first_"+login+"\" id=\"submit_first_"+login+"\" value=\"Sign In / Sign Up\"></div>\r";
                        loginModalList += "                                                                         <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        loginModalList += "                                                                            <input id=\"at\" name=\"at\" type=\"hidden\" value=\"<?php echo generateFormToken('first_step')?>\" >";
                        loginModalList += "                                                                    </fieldset>\r";
                        loginModalList += "                                                                 </div>\r";
                        loginModalList += "                                                                <span  class=\"uk-text-bold\"></span>\r";
                        loginModalList += "                                                                </form>\r";
                        loginModalList += "                                                             </div>\r";
                        loginModalList += "\r";
                        loginModalList += "                                                             <div id='second_step_"+login+"' style=\"display: none;\" aria-hidden=\"true\">\r";
                        loginModalList += "                                                                 <form class=\"uk-form-large\" id=\"s2-"+login+"\" method=\"post\" action=\"/step2\"  >\r";
                        loginModalList += "                                                                    <div class=\"form\">\r";
                        loginModalList += "                                                                       <fieldset>\r";
                        loginModalList += "                                                                           <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        loginModalList += "                                                                            <label class=\"uk-form-label\" for=\"name\"><b>Name</b></label>\r";
                        loginModalList += "                                                                            <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-male\"></i><input class=\"uk-form-large uk-width-1-1\"  name=\"name\" id=\"name\" placeholder=\"Your Name\"  type='text' ></div>\r";
                        loginModalList += "                                                                            <label class=\"uk-form-label\" for=\"phone\"><b>Phone</b></label>\r";
                        loginModalList += "                                                                            <div class=\"uk-width-1-1 uk-form-icon\"><i class=\"uk-icon-phone\"></i><input class=\"uk-form-large uk-width-1-1\" name=\"phone\" id=\"phone_login\" type='text'>\r";
                        loginModalList += "                                                                            </div>\r";
                        loginModalList += "                                                                            <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        loginModalList += "                                                                            <div class=\"uk-width-1-1\">\r";
                        loginModalList += "                                                                           <input class=\"uk-button uk-button-large uk-button-primary uk-width-1-1\" name=\"submit_second_login\" id=\"submit_second_login\" value=\"Submit\" type=\"submit\">\r";
                        loginModalList += "                                                                            </div>\r";
                        loginModalList += "                                                                            <div class=\"uk-width-1-1\">&nbsp;</div>\r";
                        loginModalList += "                                                                            <input id=\"at\" name=\"at\" type=\"hidden\" value=\"<?php echo generateFormToken('second_step')?>\" >";
                        loginModalList += "                                                                       </fieldset>\r";
                        loginModalList += "                                                                    </div>\r";
                        loginModalList += "                                                                    <span class=\"uk-text-bold\"></span>\r";
                        loginModalList += "                                                                 </form>\r";
                        loginModalList += "                                                              </div>\r";
                        loginModalList += "                                                         </figcaption>\r";
                        loginModalList += "                                                   </figure>\r";
                        loginModalList += "                                                  </div>\r";
                        loginModalList += "                                               </div>\r";
                        loginModalList += "                                  </div>\r";
                        loginModalList += "                              </div>\r";
                        loginModalList += "<script type=\"text/javascript\">";
                        loginModalList += "$(\"#login-modal\").on('display.uk.check', function(){";
                        loginModalList += "       of(\"login\",\"/\");";
                        loginModalList += " });";
                        loginModalList += "<\/script>";
</script>
