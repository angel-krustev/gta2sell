                     <div class="uk-panel uk-panel-box uk-panel-box-primary " >
                        <div class="uk-grid">
                            <div class="uk-width-1-2 uk-clearfix">
                              <span class="uk-text-bold  uk-text-large uk-text-nowrap">Elza Krusteva</span><br>
                              <span class="uk-text-primary uk-text-nowrap">Realtor</span><br>
                              <span class="uk-text-primary uk-text-nowrap">Direct: 647-890-0978</span><br>
                              <span class="uk-text-primary uk-text-nowrap">Office: 416-391-3232</span>
                            </div>
                            <div class="uk-width-1-2 uk-clearfix">
                               <img class="uk-align-right" src="/images/el-100x76.png">
                            </div>
                            <div class="uk-width-1-1 uk-margin-remove">
<a href="https://twitter.com/intent/follow?original_referer=<?php echo urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])."®ion=follow_link&screen_name=elza_krusteva&tw_p=followbutton&variant=2.0"; ?>"><img  src="/images/follow-tw.png" /></a>

                            </div>
                            <div class="uk-width-1-1 uk-margin">
                                      <div class="uk-form-row" style="height: 1px; background-image: url(/images/bld.png);"  >  </div>
                            </div>

                           <div class="uk-width-1-1">

                        <form class="uk-form" id='eform' name="eform" method="post" action="/eml" >
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-male"></i><input class="uk-form-large uk-form-width-large uk-width-1-1" name="fn" id="fn"  placeholder="Your Name" type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-envelope"></i><input class="uk-form-large uk-form-width-large uk-width-1-1 uk-text-small uk-text-muted" name="em" id="em"  placeholder="email@email.com"   type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-phone"></i><input class="uk-form-large uk-form-width-large uk-width-1-1 uk-text-muted"  name="cph" id="cph"  placeholder="999-999-9999"  type="text"   ></div>
<?php 
if ( isset($featured) ){ 
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" >I would like more information regarding your featured properties.</textarea></div>
                                <input  name="est" id="est" type='hidden' value="Featured Request" >
<?php
}else if ( isset($estimation) ){
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" ></textarea></div>
                                <input  name="est" id="est" type='hidden' value="Estimation Request" >

<?php
}else{
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" >I would like more information regarding a property<?php echo " at ".$addr.", ".$municipality. "  MLS# ".$ml_num ?></textarea></div>
                                <input  name="est" id="est" type='hidden' value="MLS: <?php echo $ml_num ?> - property request" >
<?php
}
?>
                                     <input name="frm" id="frm" type="hidden" value="eform">
                                     <input id="at" name="at" type="hidden" value="<?php echo generateFormToken('eform')?>" >
                                     <input  name="ml_num" id="ml_num" type='hidden' value="<?php echo $ml_num;?>" >
                                     <input id="tp" name="tp" type="hidden" value="CP" >
                                     <input  name="addr_info" id="addr_info" type='hidden' value="<?php echo $addr;?>" >
                                     <div class="uk-form-row" id="status">
                                            &nbsp;
                                     </div>

                                <div class="uk-form-row"><button id="eform-submit" class="uk-button uk-button-large uk-button-primary uk-width-1-1 ">Request Details</button></div>

                        </form>
                           </div>
                        </div>
                      </div>
<?php if( 1==0 ){ ?>
                     <div class="uk-panel uk-panel-box uk-panel-box-primary uk-hidden-large uk-hidden-xlarge" >
                        <div class="uk-grid">
                           <div class="uk-width-2-5">
                              <div class="uk-grid">
                                <div class="uk-width-1-2">
                                  <span class="uk-text-bold uk-text-nowrap">Elza Krusteva</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Realtor</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Direct: 647-890-0978</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Office: 416-391-3232</span><br>
                                  <span class="uk-text-bold uk-text-small uk-text-nowrap">Right at Home Realty</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Brokerage</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap"></span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">1396 Don Mills Rd., #B121</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Toronto, ON M3B 0A7</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Phone: 416-391-3232</span><br>
                                  <span class="uk-text-primary uk-text-small uk-text-nowrap">Fax: 416-391-0319</span>
                                </div>
                                <div class="uk-width-1-2">
                                   <img class="uk-responsive" src="/images/el-100x76.png" >
                                </div>
                                <div class="uk-width-1-1">
                                   <img width="50%" src="/images/right-at-home-v2.png" >
                                </div>
                              </div>
                           </div>
                           <div class="uk-width-3-5">
                        <form class="uk-form" id='eform' name="eform" method="post" action="/eml" >
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-male"></i><input class="uk-form-large uk-form-width-large uk-width-1-1" name="fn" id="fn" type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-envelope"></i><input class="uk-form-large uk-form-width-large uk-width-1-1 uk-text-small uk-text-muted" name="em" id="em" type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-phone"></i><input class="uk-form-large uk-form-width-large uk-width-1-1 uk-text-muted"  name="cph" id="cph" type="text"   ></div>
<?php 
if ( isset($featured) ){ 
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" >I would like more information regarding your featured properties.</textarea></div>
                                <input  name="est" id="est" type='hidden' value="Featured Request" >
<?php
}else if ( isset($estimation) ){
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" ></textarea></div>
                                <input  name="est" id="est" type='hidden' value="Estimation Request" >

<?php
}else{
?>
                                <div class="uk-form-row uk-text-muted"><textarea name="msg" id="msg" rows="3" class="uk-width-1-1" >I would like more information regarding a property<?php echo " at ".$addr.", ".$municipality. "  MLS# ".$ml_num ?></textarea></div>
                                <input  name="est" id="est" type='hidden' value="MLS: <?php echo $ml_num ?> - property request" >
<?php
}
?>
                                     <input name="frm" id="frm" type="hidden" value="eform">
                                     <input id="at" name="at" type="hidden" value="<?php echo generateFormToken('eform')?>" >
                                     <input  name="ml_num" id="ml_num" type='hidden' value="<?php echo $ml_num;?>" >
                                     <input id="tp" name="tp" type="hidden" value="CP" >
                                     <input  name="addr_info" id="addr_info" type='hidden' value="<?php echo $addr;?>" >
                                     <div class="uk-form-row" id="status">
                                            &nbsp;
                                     </div>
                                <div class="uk-form-row"><button id="eform-submit" class="uk-button uk-button-large uk-button-primary uk-width-1-1 ">Request Details</button></div>

                           </div>
                        </div>
                      </div>
<?php } ?>

<?php
include 'js-email.php';
?>

