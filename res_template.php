<?php
if(isset( $ml_num ) &&  $ml_num != '' ){
  $ml_num = htmlspecialchars($ml_num, ENT_QUOTES);
  $sql="select * from $RES where ml_num = ?  ";
   if( $stmt = $mysqli->prepare($sql) ){
       $stmt->bind_param("s",$ml_num);
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include '404.php';
       }
   }
}else if(isset( $addr ) && $addr != '' ){
    $addr = htmlspecialchars($addr, ENT_QUOTES);
   if (stristr($addr, '_') !== false){
       $full_address = explode("_", $addr);
       $addr=$full_address[0]; // piece1
       $apt_num=$full_address[1]; // piece1
       $where = " where municipality ilike ?  and community ilike ? and addr ilike ? and ( apt_num = ? or apt_num  = CONCAT('#',?::text) ) ";
       $sql="select * from $RES $where limit 1 ";
      if( $stmt = $mysqli->prepare($sql) ){
          $stmt->bind_param("sssss",url2mysql($municipality), url2mysql($community), url2mysql($addr), url2mysql($apt_num), url2mysql($apt_num));
          $stmt->execute();
          $result = $stmt->get_result();
          if( $result === NULL ){
             err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
             include '404.php';
          }
     }

   }else{
       $where = " where municipality ilike ? and community ilike ? and addr ilike ? ";
       $sql="select * from $RES $where limit 1 ";
            err_log(url2mysql($addr));
        if( $stmt = $mysqli->prepare($sql) ){
           $stmt->bind_param("sss",url2mysql($municipality), url2mysql($community), url2mysql($addr));
           $stmt->execute();
           $result = $stmt->get_result();
       }

   }
}else{
 err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
 include '404.php';
}
if( $row = $result->fetch_assoc() ){
   $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
   extract($escapedListing);
   $mactive="";
   $cactive="";
   $aactive='class="uk-active"';
   if ($nimages == 0 ) {$nimages = 20;};
   $ipath=get_path_form_mln($ml_num);
   $property_type=getPropertyType($type_own_srch) ;
   $is_maint = (  $s_r == 'Sale' && ( $property_type == 'condo' || $property_type=='townhouse'  ||  $type_tr == 'CND' ) );
          $page_url = "";
          $full_addr = "";
          if( $disp_addr == 'Y' ){
              $full_addr=($apt_num != '')?$addr."_".$apt_num:$addr;
          }
          if( $disp_addr != 'Y' || $full_addr == '' ){
              $page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($municipality)."/MLS/".$ml_num;
           }else{
              $page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($community)."/".url_cooker($full_addr);
           }

 ?>
<div class="uk-grid uk-margin-right uk-margin-left"  style="margin-top: 5px;" >
  <!-- breadcrumb--!>
      <div class="uk-hidden-small uk-width-medium-2-4 uk-width-large-2-4 uk-width-xlarge-2-4">
                                   <ul class="uk-breadcrumb uk-link-muted" style="margin-bottom: 1px; margin-top: 1px;">
                                        <?php if($municipality != ''){ ?>
                                           <li <?php echo $mactive;?> ><a href="/<?php echo to_url($municipality);?>-real-estate"><?php echo $municipality;?></a></li>
                                        <?php } ?>
                                        <?php if($community != ''){ ?>
                                           <li  <?php echo $cactive;?> ><a href="/<?php echo to_url($municipality);?>-real-estate/<?php echo to_url($community);?>"><?php echo $community;?></a></li>
                                        <?php } ?>
                                        <?php if($st != '' &&  $disp_addr == 'Y'  ){
                                              $strt_name = $st." ".$st_sfx." ".$st_dir;
                                        ?>
                                              <li  class="uk-active" ><a href="/<?php echo to_url($municipality).'-home/'.to_url($community).'/'.to_url($st) ;?>"><?php echo $strt_name;?></a></li>
                                        <?php } ?>
                                   </ul>
  </div>
  <!-- breadcrumb--!>
  <!-- social--!>
  <div class="uk-hidden-small uk-hidden-medium uk-width-large-1-4 uk-width-xlarge-1-4 uk-text-right" >
   <?php include 'social-line.php' ?>
  </div>
  <div class="uk-width-small-1-1 uk-width-medium-1-4 uk-hidden-large uk-hidden-xlarge uk-text-left" >
   <?php include 'social-line.php' ?>
  </div>
  <!-- social--!>
  <div class="uk-hidden-small  uk-width-medium-1-4 uk-width-large-1-4 uk-width-xlarge-1-4  uk-text-right">
               <a href="#" class="uk-text-muted" onclick="goBack()">&lt;&lt;Go Back</a>
  </div>
  <!-- maincontent--!>
  <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-4 uk-width-xlarge-4-4" >
     <div class="uk-grid uk-grid-small" style="margin-top: 5px;">
            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-2-5">
                 <div class="uk-panel uk-panel-box uk-panel-header">
                                <div class="uk-panel-badge uk-badge uk-badge-danger">For <?php echo $s_r; ?></div>
                                <h2 class="uk-panel-title"  ><b><?php if( $disp_addr == 'Y' ){ echo $apt_num != ''?$addr.' #'. str_replace('#','',$apt_num):$addr; }?></b> </h2>
                                   <div  class="uk-grid" data-uk-grid-match>
                                     <div class="uk-width-1-2" >
                                     <ul class="uk-list uk-list-line uk-list-space">
                                        <li><span class="uk-text-large uk-text-bold"><?php echo money_format('%.0n',$lp_dol);?></span></li>
                                        <li><i class="uk-icon-small uk-icon-bed"></i><p class="uk-text-large uk-text-bold"><?php echo $br; if($br_plus > 0 ){ echo "+".$br_plus;}; ?></p></li>
                                        <li><i class="uk-icon-small uk-icon-female"></i>|<i class="uk-icon-small uk-icon-male"></i><p class="uk-text-large uk-text-bold">&nbsp;<?php echo $bath_tot;?></p></li>
                                       <?php if(  $type_tr != 'CND'   ){ ?>
                                        <li><i class="uk-icon-small uk-icon-car"></i><p class="uk-text-large uk-text-bold"><?php printf("%.0f",$gar_spaces);?> </p></li>
                                       <?php }else{ ?>
                                        <li><i class="uk-icon-small uk-icon-car"></i><p class="uk-text-large uk-text-bold"><?php printf("%.0f",$park_spcs);?> </p></li>
                                       <?php } ?>
                                        <li><p class="uk-text-bold">MLS# <?php echo $ml_num;?> </p></li>
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
                                        <li><span class="uk-text-bold">Taxes:</span> <?php echo ($s_r=='Sale')?money_format('%.0n',$taxes)." / ".$yr:'N/A';?><span class="uk-text-large"></span></li>

                                     </ul>
                                     </div>
                                     <div class="uk-width-1-1">
                                     <ul class="uk-list uk-list-line uk-list-space">
                                        <li>&nbsp;</li>
                                        <li><span class="uk-text"><?php echo $rltr;?> </span></li>
                                     </ul>
                                     </div>
                                   </div>
                 </div> <!--panel --!>

            </div> <!--2-5 --!>
            <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-3-5">
                 <div class="uk-responsive-width uk-responsive-height" style="margin-bottom: 5px;" >
                       <?php include 'slider_overlay.php' ?>
                 </div>
            </div>
                               <div class="uk-width-1-1">&nbsp;</div>
                                            <div class="uk-width-1-1">
                                                 <div class="uk-alert uk-text-large">
                                                  Do you own property in the same area?
                                                  &nbsp;
                                                  &nbsp;
                                                  &nbsp;
                                                  <a href="/what-is-my-home-worth"><b>Check What is Your Home Worth $$$</b></a>
                                                </div>
                                            </div>
                       <div class="uk-width-1-1"> &nbsp; </div>


            <div class="uk-width-1-1 uk-row-first uk-margin-top" >
                    <ul class="uk-tab" data-uk-tab="{connect:'#tab-1', animation:'fade'}">
                        <li class="uk-active" ><a class="uk-text-primary" href="#">Description</a></li>
                        <li class="" ><a class="uk-text-primary" href="#">Demographic</a></li>
                        <li class="" ><a class="uk-text-primary" href="#">Schools</a></li>
                        <li class="" ><a class="uk-text-primary" href="#">Map</a></li>
                        <li class="" ><a class="uk-text-primary" href="#">Transportation</a></li>
                    </ul>
            </div>
            <div class="uk-width-1-1"> &nbsp; </div>
            <div class="uk-width-1-1">
                     <ul id="tab-1" class="uk-switcher uk-margin">
                         <li class="uk-active">
                             <div class="uk-grid uk-grid-divider" >
                                       <?php include 'description.php' ?>
                             </div>
                         </li>
                         <li class="uk-active">
                             <div class="uk-grid uk-grid-divider" >
                                       <?php include 'demographic.php' ?>
                             </div>
                         </li>
                         <li class="uk-active">
                    	     <div class="uk-panel uk-panel-box">
                                   <h3 class="uk-panel-title"><b>Schools nearby</b></h3>
                                       <?php include 'get_near_schools.php' ?>
                             </div>
                         </li>
                         <li class="uk-active">
                         </li>
                         <li class="uk-active">
                    	     <div class="uk-panel uk-panel-box">
                              <h3 class="uk-panel-title"><b>Transit directions</b></h3>
	                       <div class="uk-guard"> 
                                    <form class="uk-form uk-margin-remove uk-form-medium" name='fc' id='fc'  action="<?php echo $form_action ?>" method="post" >

					        <div  class="uk-width-2-6" >
					          <label>From:</label>
                                                </div>
					        <div  class="uk-width-4-6" >
					          <input class="uk-form-medium uk-width-1-1" id="from" type="text" size="40" value="<?php echo $addr.", ".$municipality.", ON Canada" ?>">
					        </div>
					        <div  class="uk-width-2-6" >
					          <label>To:</label>
                                                </div>
					        <div  class="uk-width-4-6" >
                                                <input class="uk-form-medium uk-width-1-1" id="to" type="text" size="40"  value="Union Station, Toronto">
					        </div>
                                   </form>
					        <div   class="uk-width-1-1 btn">
					          <button  id="go"  class="uk-button uk-button-small uk-width-4-6">Get Directions</button>
					        </div>
					      <div  class="uk-width-1-1" id="panel"></div>
                              </div>
                          </div>
                         </li>
                     </ul>


            </div>
            <div class="uk-width-1-1"> &nbsp; </div>

            <div class="uk-width-1-1"> 
                    <div class="uk-panel uk-panel-box" >
                           <h3 class="uk-panel-title"  ><b>Map</b></h3>
                                       <?php include 'ttc.php' ?>
                    </div>
            </div>
      </div><!-- grid --!>
  <!-- maincontent--!>
    </div><!-- div --!>
    <div class="uk-width-small-1-1 uk-width-medium-1-1 uk-width-large-1-4 uk-width-xlarge-1-4">
                       <?php include 'elza-contact-email.php' ?>
                       <div class="uk-grid uk-hidden-small uk-text-center" style="margin-top: 5px;" id="list"> 
                       </div>
                       <div id="modalList"></div> 
    </div>
  <!-- maincell--!>
  </div>
<!-- main grid --!>
                       <?php include 'get_side_list.php' ?>
<?php
}else{
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include '404.php';
}
if (isset($stmt)){ 
    $stmt->close();
}; 
if (isset($mysqli)){
    $mysqli->close();
};
?>
