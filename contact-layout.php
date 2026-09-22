                     <div class="uk-container uk-margin-bottom uk-margin-top">
                          <div class="uk-grid uk-grid-match" data-uk-grid-margin >
				<div class="uk-width-small-1-1 uk-width-medium-2-3 uk-width-large-2-3 uk-width-xlarge-2-3 uk-row-first" data-uk-grid-match="{target:'.uk-panel'}">
                                    <div class="uk-panel uk-panel-box uk-panel-header" id="ui" >
                                            <div class="uk-margin-large-left uk-margin-large-right" >
                                                 <h3 class="uk-panel-title uk-text-left" ><b>Call Back Request</b></h3>
                                                 <p class="uk-clearfix uk-text-medium uk-hidden-small uk-hidden-medium" >When you’re <span class="uk-text-large uk-text-danger uk-text-bold">ready to buy</span>, I can provide a free market analysis of the desired location for your new home. I can guide you to find "<b>hidden gems</b>" in locations where the best schools are,  or on convenience for commute with TTC or GO trains. Be advised that <span class="uk-text-danger uk-text-bold">the buyers don't pay a penny</span> when buying a property. I can help you navigate the home buying process and paperwork from start to finish. Last but not least, I can negotiate purchase price and contract terms and direct you through the whole home buying process.</p>
                                                 <p class="uk-clearfix uk-text-medium uk-hidden-small uk-hidden-medium" >When you’re <span class="uk-text-large uk-text-danger uk-text-bold">ready to sell</span>, nothing beats the first-hand experience and local knowledge of a Realtor. I can provide a free, professional estimate based on your home’s unique characteristics, including renovations, school ratings in the boundary and many other factors that adds to the price. Submit the form below and I will be happy to evaluate the price of your property <span class="uk-text-danger uk-text-bold">ABSOLUTELY FREE</span> and without any obligations from your side. In addition, you will get full registration and access to all listings on my website.</p>

                                                 <form class="uk-form" id="eform" name="eform" method="post" action="/eml" >
                                                         <div class="uk-form-row uk-width-1-1 uk-form-icon">

                                                                   <i class="uk-icon-male"></i><input class=" uk-width-1-1" name="fn" id="fn" type="text"  placeholder="Your Name" >
                                                         </div>
                                                         <div class="uk-form-row  uk-width-1-1 uk-form-icon">
                                                              <i class="uk-icon-envelope"></i><input class=" uk-width-1-1" name="em" id="em" type="text"  placeholder="email@email.com" >
                                                         </div>
                                                         <div class="uk-form-row  uk-width-1-1 uk-form-icon">
                                                              <i class="uk-icon-phone"></i><input class=" uk-width-1-1" name="cph" id="cph" type="text"  placeholder="Contact Phone" >
                                                         </div>
                                                          <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1 uk-text-muted" >Please contact me to discuss my interest in buying/selling property in Toronto and GTA.</textarea></div>


                                                         <div id="status">
                                                                 <div style="display: none;" aria-hidden="true" id="email-spinner"  class="uk-text-center">
                                                                               <i class="uk-icon uk-icon-spinner uk-icon-spin"></i>
                                                                 </div>
                                                         </div>
                                                         <div class="uk-form-row  uk-width-1-1 uk-form-icon">
                                                               <input id="landing" name="landing" type="hidden" value="<?php echo url_cooker($_SERVER['HTTP_REFERER']);?>" >
                                                               <input id="tp" name="tp" type="hidden" value="CF" >
                                                               <input id="frm" name="frm" type="hidden" value="eform" >
                                                               <input id="at" name="at" type="hidden" value="<?php echo generateFormToken('eform')?>" >
                                                               <button id="eform-submit" class="uk-button uk-button-large uk-button-primary uk-width-1-1 uk-margin-top">Request a Call Back</button>
                                                         </div>
                                                 </form>
                                            </div>

                                    </div>
                               </div>
                               <div class="uk-width-small-1-1 uk-width-medium-1-3 uk-width-large-1-3 uk-width-xlarge-1-3">
                                           <?php include 'elza-contact-v.php' ?>
                               </div>
                          </div>
                     </div>
<?php
include 'js-email.php';
?>

