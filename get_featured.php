<?php
$FEAT="FEATURED";
$showslide='Y';
$featured='Y';
  $sql="select * from $FEAT where disabled <> 'Y' order by lorder desc ";
#  $result = mysql_query($sql) or die(mysql_error());
   if( $stmt = $mysqli->prepare($sql) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }
   }


?>
<div class="uk-grid"  style="margin-top: 15px;"  >
  <div class="uk-width-medium-4-5">
     <div class="uk-grid"  style="margin-top: 15px;"  >
<?php
 while ($row = $result->fetch_array()) {

   $escapedListing=array_map('mysql_real_escape_string', $row);
   extract($escapedListing);
   $mactive="";
   $cactive="";
   $aactive='class="uk-active"';
   if ($nimages == 0 ) {$nimages = 20;};
   #$ipath=get_path_form_mln($ml_num);
   $ipath="/featimages/";
   $property_type=getPropertyType($type_own_srch) ;
   $is_maint = (  $s_r == 'Sale' && ( $property_type == 'condo' || $property_type=='townhouse'  ||  $type_tr == 'CND' ) );
 ?>
   <!-- PROPERTY START --!>
    <div class="uk-width-medium-1-1">
     <!-- Property GRID --!>
     <div class="uk-grid uk-grid-small" >
       <div class="uk-width-small-1-1 uk-width-medium-1-2" >
                            <div class="uk-panel uk-panel-box uk-panel-header" >
                                <div class="uk-panel-badge uk-badge uk-badge-danger uk-text-large"  style="margin-top: 8px;" ><?php if( $s_r == 'Sale' || $s_r == 'Lease' ){ echo 'For '.$s_r; }else { echo $s_r; } ?></div>
                                <h3 class="uk-panel-title"  >
                                <?php
                                  if( $is_in_mls == 'Y'  ){
                                ?>
<a href="<?php echo '/real-estate/'.$municipality."/".$addr; ?>"><b><?php if( $disp_addr == 'Y' ){ echo $apt_num != ''?$addr.' #'.$apt_num:$addr; }?></b> &nbsp;<i class="uk-icon-justify uk-icon-hand-o-right"></i></a>
                                <?php
                                 }else{
                                ?>
<b><?php if( $disp_addr == 'Y' ){ echo $apt_num != ''?$addr.' #'.$apt_num:$addr; }?></b> 
                                <?php
                                 }
                                ?>

                                   <ul class="uk-breadcrumb uk-link-muted" style="margin-bottom: 1px; margin-top: 1px;">
                                        <?php if($municipality != ''){ ?>
                                           <li <?php echo $mactive;?> ><a href="/<?php echo to_url($municipality);?>-real-estate/"><?php echo $municipality;?></a></li>
                                        <?php } ?> 
                                        <?php if($community != ''){ ?>
                                           <li  <?php echo $cactive;?> ><a href="/<?php echo to_url($municipality);?>-real-estate/<?php echo to_url($community);?>"><?php echo $community;?></a></li>
                                        <?php } ?> 
                                   </ul>

                                </h3>
                                   <div  class="uk-grid">
                                     <div class="uk-width-1-2" >
                                     <ul class="uk-list uk-list-line uk-list-space">
                                        <li><span class="uk-text-large uk-text-bold"><?php if( $s_r == 'Sale' || $s_r == 'Lease' ){ echo  money_format('%.0n',$lp_dol); }else { echo '&nbsp;' ; } ?></span></li>
                                        <li><i class="uk-icon-small uk-icon-bed"></i><p class="uk-text-large uk-text-bold"><?php echo $br; if($br_plus > 0 ){ echo "+".$br_plus;}; ?></p></li>
                                        <li><i class="uk-icon-small uk-icon-female"></i>|<i class="uk-icon-small uk-icon-male"></i><p class="uk-text-large uk-text-bold">&nbsp;<?php echo $bath_tot;?></p></li>
                                       <?php if(  $type_tr != 'CND'   ){ ?>
                                        <li><i class="uk-icon-small uk-icon-car"></i><p class="uk-text-large uk-text-bold"><?php printf("%.0f",$gar_spaces);?> </p></li>
                                       <?php }else{ ?>
                                        <li><i class="uk-icon-small uk-icon-car"></i><p class="uk-text-large uk-text-bold"><?php printf("%.0f",$park_spcs);?> </p></li>
                                       <?php } ?>

                                     </ul>
                                     </div>
                                     <div class="uk-width-1-2">
                                     <ul class="uk-list uk-list-line uk-list-space">
                                        <li><span class="uk-text-bold">Type:</span> <?php echo $type_own1_out;?><span class="uk-text-large"></span></li>
                                        <li><span class="uk-text-bold">Style:</span> <?php echo $style;?></li><span class="uk-text-large"></span>
                                        <?php if ($front_ft != '' || $depth != '') { ?>
                                        <li><span class="uk-text-bold">Lot: </span> <?php echo $front_ft." x ".$depth;?>&nbsp;<?php echo $lotsz_code;?><span class="uk-text-large"></span></li>
                                        <?php } ?>
                                        <?php if ($sqft != '' ) { ?>
                                        <li><span class="uk-text-bold">Square Feet: </span> <?php echo $sqft;?><span class="uk-text-large"></span></li>
                                        <?php } ?>
                                        <li><span class="uk-text-bold">Rooms:</span> <?php echo $rms."+".$rooms_plus;?></li>
                                        <li><span class="uk-text-bold">Age:</span> <?php if($yr_built != ''){ echo $yr_built;}else{ echo "N/A"; };?><span class="uk-text-large"></span></li>
                                        <li><span class="uk-text-bold">Days Listed:</span> <?php echo $dom;?><span class="uk-text-large"></span></li>
                                     </ul>
                                     </div>
                                   </div>
                            </div>
       </div>
       <div class="uk-width-small-1-1 uk-width-medium-1-2" >
          <div class="uk-thumbnail-large uk-responsive-width uk-responsive-height" style="margin-bottom: 5px;" data-uk-slideshow="{height:300,autoplay:false}" >
                 <div class="uk-slidenav-position">
                       <?php include 'slider_overlay.php' ?>
                 </div>
                 <div class="uk-slidenav-position uk-hidden-small" data-uk-slider>
                      <div class="uk-slider-container" style="margin-top: 2px; background-color: rgba(255,255,255,0.4); max-height: 65px;"  >
                       <?php include 'slidenav_overlay.php' ?>
                      </div>
                        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous"></a>
                        <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next"></a>
                </div>
          </div>
       </div> 
       <div class="uk-width-1-1" >
             <div class="uk-panel uk-panel-box  uk-panel-header"  >
             <h3 class="uk-panel-title"  ><b>Description</b></h3>
                <?php echo $ad_text."<br>"; 
                   if( $extras != ''){
                    echo  "<b>Extras</b><br>".$extras; 
                   }

?> 
             </div>
       </div>
     </div>
     <!-- Property GRID --!>

  </div>
  <!-- PROPERTY START --!>
 
   <div class="uk-width-small-1-1 uk-width-medium-1-1">
&nbsp;
   </div>
<?php
 }
 #  mysql_free_result($result);
 ?>
  </div>
  </div>
   
   <div class="uk-width-small-1-1 uk-width-medium-1-5">
           <div class="uk-grid">
               <div class="uk-width-small-1-1">
                 <?php include 'elza-general-email-form.php' ?>
               </div>
           </div>
   </div>
 </div>
