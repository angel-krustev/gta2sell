<?php
        // Local image mirror is gone post-migration; photos now come from the feed/placeholder helper.
        $galleryCount = $nimages > 0 ? $nimages : 1;
   if( $my_broker == $rltr  ){ $showslide ='Y' ;};
   if( isset($_COOKIE[$cookie_name]) || isset($showslide) ){ 
?>
    <div id="slideshow" data-uk-slideshow="{autoplay:true,autoplayInterval:5000}">
           <div class="uk-slidenav-position" >
               <div class="uk-grid">
                  <div class="uk-width-1-1" >

                      <ul class="uk-slideshow">
                       <?php for ($i = 1; $i <= $galleryCount; $i++) { ?>
                              
                                <li ><img onerror="imgError(this);" class="uk-responsive-width uk-responsive-height" src="<?php echo get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, $i, 600, 400) ;?>"  alt="">
                                </li>
                       <?php } ; ?>
                      </ul>
                  </div>
                  <div class="uk-width-1-1" >
                      <ul>
                                   <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slideshow-item="previous"></a>
                                   <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slideshow-item="next"></a>
                      </ul>
                  </div>
               </div>
          </div>
          <div id="slider" class="uk-slidenav-position uk-hidden-small"  data-uk-slider="{center:true}">
               <div class="uk-slider-container"  style="margin-top: 1px; background-color: rgba(255,255,255,0.4); max-height: 100px;" >
                      <ul class="uk-slider uk-grid-width-medium-1-4">
                             <?php for ($i = 1; $i <= $galleryCount; $i++) { ?>
                                  <li data-uk-slideshow-item="<?php echo $i-1; ?>"><img onerror="imgError(this);"  class="uk-responsive-width uk-responsive-height" src="<?php echo get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, $i, 150, 180) ;?>"  alt=""></li>
                             <?php } ; ?>
                      </ul>
                                  <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                                  <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
               </div>
          </div>
      </div>

<?php }else { ?>
                       <?php for ($i = 1; $i <= $galleryCount; $i++) { ?>
                                               <div class="uk-grid">
                                                 <div class="uk-width-medium-1-1">
                                                   <figure class="uk-overlay">
                                                      <img  onerror="imgError(this);"  width="600" height="400"  class="uk-responsive-width uk-responsive-height" src="<?php echo get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, $i, 600, 400) ;?>"  alt="">
                                                         <figcaption class="uk-overlay-panel uk-overlay uk-overlay-background">
                                                             <div id="first_step_<?php echo $ml_num; ?>">
                                                                <form class="uk-form-large" id="s1-<?php echo $ml_num ?>" method="post" action="/step1" >
                                                                 <div class="form">
                                                                    <fieldset>
                                                                        <div class="uk-width-1-1 uk-hidden-small">
                                                                            <b>FREE Account Required For Full Access</b><br/>
                                                                               MLS® and the Real Estate Board require you sign up to see full details, including photos. It"s Free!
                                                                         </div>
                                                                         <div class="uk-width-1-1">&nbsp;</div>
                                                                         <label class="uk-form-label" for="email"><b>Email Address</b></label>
                                                                         <div class="uk-width-1-1 uk-form-icon"><i class="uk-icon-envelope"></i>
                                                                               <input class="uk-form-large uk-width-1-1"  name="email" id="email" placeholder="email@email.com"   type="text" >
                                                                         </div>
                                                                         <div class="uk-width-1-1">&nbsp;</div>
                                                                         <div class="uk-width-1-1">
                                                                               <input class="uk-button uk-button-large uk-button-primary uk-width-1-1" type="submit" name="submit_first_<?php echo $ml_num;?>" id="submit_first_<?php echo $ml_num;?>" value="Sign In / Sign Up">
                                                                         </div>
                                                                         <div class="uk-width-1-1">&nbsp;</div>
                                                                        <div class="uk-width-1-1 uk-hidden-medium uk-hidden-large uk-hidden-xlarge">
                                                                            <b>FREE Account Required For Full Access</b><br/>
                                                                               MLS® and the Real Estate Board require you sign up to see full details, including photos. It"s Free!
                                                                         </div>

                                                                    </fieldset>
                                                                 </div>
                                                                <span  class="uk-text-bold"></span>
                                                                </form>
                                                             </div>
                                                             <div id="second_step_<?php echo $ml_num;?>" style="display: none;" aria-hidden="true" >
                                                                 <form class="uk-form-large" id="s2-<?php echo $ml_num ?>" method="post" action="/step2"  >
                                                                    <div class="form">
                                                                       <fieldset>
                                                                           <div class="uk-width-1-1">&nbsp;</div>
                                                                            <label class="uk-form-label" for="name"><b>Name</b></label>
                                                                            <div class="uk-width-1-1 uk-form-icon"><i class="uk-icon-male"></i><input class="uk-form-large uk-width-1-1"  name="name" id="name" placeholder="Your Name"  type="text" ></div>
                                                                            <label class="uk-form-label" for="phone"><b>Phone</b></label>
                                                                            <div class="uk-width-1-1 uk-form-icon"><i class="uk-icon-phone"></i><input class="uk-form-large uk-width-1-1" name="phone_<?php echo $ml_num;?>" id="phone_<?php echo $ml_num;?>" type="text">
                                                                            </div>
                                                                            <div class="uk-width-1-1">&nbsp;</div>
                                                                            <div class="uk-width-1-1">
                                                                                 <input class="uk-button uk-button-large uk-button-primary uk-width-1-1" name="submit_second_<?php echo $ml_num;?>" id="submit_second_<?php echo $ml_num;?>" value="Submit" type="submit">
                                                                            </div>
                                                                            <div class="uk-width-1-1">&nbsp;</div>
                                                                       </fieldset>
                                                                    </div>
                                                                    <span class="uk-text-bold"></span>
                                                                 </form>
                                                              </div>
                                                         </figcaption>
                                                   </figure>
                                                  </div>
                                               </div>
                     <?php  break; } ; ?>
                     <script type="text/javascript">
                       $("document").ready(function() {
                            of("<?php echo $ml_num?>","<?php echo $page_url ?>");
                       }); 
                     </script>

<?php  } ; ?>
