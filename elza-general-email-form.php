                    <div class="uk-panel uk-panel-box  uk-responsive-width uk-responsive-height"  >
START
                        <form class="uk-form" id='eform' name="eform" method="post" action="/eml.php" >
                                <div class="uk-grid uk-margin-small-bottom">
                                   <div class="uk-width-1-2">
                                       <div class="uk-form-row">Elza Krusteva</div>
                                       <div class="uk-form-row">Realtor</div>
                                       <div class="uk-form-row"><i class="uk-icon-mobile">&nbsp;<a class="uk-text-bold" href="tel:6478900978">647-890-0978</a></i></div>
                                       <div class="uk-form-row"><i class="uk-icon-phone">&nbsp;<a class="uk-text-bold" href="tel:4167432000">416-391-3232</a></i></div>
                                   </div>
                                   <div class="uk-width-1-2 uk-valign-top uk-float-left"><img src="/images/el-50x66.png"/></div>
                                </div>
                                
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-male"></i><input class="uk-form-large uk-width-1-1" name="fn" id="fn" type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-envelope"></i><input class="uk-form-large uk-width-1-1 uk-text-small uk-text-muted" required name="em" id="em" type="text"></div>
                                <div class="uk-form-row uk-form-icon"><i class="uk-icon-phone"></i><input class="uk-form-large uk-width-1-1 uk-text-muted"  name="cph" id="cph" type="text"   ></div>
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
                                     <div id="status">
                                             <div style="display: none;" aria-hidden="true" id="email-spinner"  class="uk-text-center">
                                                           <i class="uk-icon uk-icon-spinner uk-icon-spin"></i>
                                             </div>
                                     </div>

                                <div class="uk-form-row"><button id="eform-submit" class="uk-button uk-button-large uk-button-primary uk-width-1-1 ">Request Details</button></div>

                        </form>
END
                    </div>
<?php
include 'js-email.php';
?>

