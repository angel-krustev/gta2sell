<div class="uk-block">
           <div class="uk-grid"   style="margin-top: 5px;" >
                <div class="uk-width-2-4">
                    <div class="uk-panel uk-panel-box uk-panel-box-primary uk-panel-header">
                         <h3 class="uk-panel-title uk-text-danger"><b>Sell Your Home Fast and Get Top Price !!!</b></h3>
				<ul>
                                       <li>Your Home Advertised 24 Hours a Day Until Sold</li>
                                       <li>Full Colour Print & Digital Ads</li>
                                       <li>Newspapers, Magazines, Flyers, Radio, TV Plus Much More</li>
                                       <li>Your Home Advertised to Millions on the Internet</li>
                                       <li>Social Media Mass Exposure and Blasts</li>
                                       <li>Our Team of Professionals for the Same Price as Hiring a Single Broker</li>
                                       <li>Learn the Secrets of Selling Your Home Without Ineffective Open Houses</li>
                                       <li>Professional Photography & Virtual Tours</li>
                                       <li>Home Staging Consultation</li>
                                       <li>Contractors AvaliableTo Make Repairs & Improvements Easy</li>
                                       <li>Total Service Guaranteed in Writing</li>
                                       <li>Your Home Sold Guaranteed or I'll Buy It*</li>
                                       <li>Competitive Rates, Exceptional Service and Award Winning Results</li>
				</ul>
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <div class="uk-panel uk-panel-box uk-panel-box-primary uk-panel-header">
                         <h3 class="uk-panel-title uk-text-danger"><b>Request for Call Back</b></h3>
                             <form class="uk-form" id='eform' name="eform" method="post" action="eml.php" >
                                     <div class="uk-form-row uk-form-icon">
                                          <i class="uk-icon-male"></i><input class="uk-form-large uk-width-1-1" name="fn" id="fn" type="text"  placeholder="Your Name" >
                                     </div>
                                     <div class="uk-form-row uk-form-icon">
                                          <i class="uk-icon-envelope"></i><input class="uk-form-large uk-width-1-1" name="em" id="em" type="text"  placeholder="email@email.com" >
                                     </div>
                                     <div class="uk-form-row uk-form-icon">
                                          <i class="uk-icon-phone"></i><input class="uk-form-large uk-width-1-1" name="cph" id="cph" type="text"  placeholder="Contact Phone" >
                                     </div>
                                     <div class="uk-alert uk-text-danger">
                                       Submit this form and I will contact you to discuss the best selling strategy.
                                     </div>
                                     <input id="at" name="at" type="hidden" value="<?php echo generateFormToken('eform')?>" >
                                     <input id="msg" name="msg" type="hidden" value="Request for Call Back in regards of buying a home." >
                                     <input  name="request_type" id="sale" type='hidden' value="Sale Request">
                                     <div id="status">&nbsp;</div>
                                     <div class="uk-form-row">
                                       <button id="eform-submit" class="uk-button uk-button-large uk-button-primary uk-width-1-1">Get Started</button>
                                     </div>
                           </form>
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <div class="uk-panel uk-panel-box uk-panel-box-primary">

                    <img src="images/el-100x76.png" > 
                    </div>
                </div>
           </div>
</div>
<?php
include 'js-email.php';
?>
