<?php
$showslide='Y';
$rtype ='Detached';
include 'rtype.php';

$sql="select * from $RES where rltr ilike 'RIGHT AT HOME REALTY%' and area_code in ('01','02') and s_r='Sale' and lp_dol >'800000' $twhere  order by dom asc limit $start_mybroker,25 ";
#$sql="select *, ( 6372 * acos( cos( radians(43.744726109419) ) * cos( radians( lat ) )     * cos( radians(lon) - radians(-79.512057102803)) + sin(radians(43.744726109419))     * sin( radians(lat)))) AS distance  FROM RES   where  s_r= 'Sale' and bath_tot >= 2 and br >= 3 and  lp_dol >= 700000 and lp_dol <= 3000000     HAVING distance <= 1   order by lp_dol   limit 0, 24";
# vvvv saved on 16/05/2020
#$sql="select *, ( 6372 * acos( cos( radians(43.6573378) ) * cos( radians( lat ) )     * cos( radians(lon) - radians(-79.55770129999996)) + sin(radians(43.6573378))     * sin( radians(lat)))) AS distance  FROM RES   where  s_r= 'Sale' and bath_tot >= 0 and br >= 0 and  lp_dol >= 500000 and rltr='$my_broker'  HAVING distance <= 10 order by dom asc   limit ".$start_mybroker.", 12";
#$sql="select *, ( 6372 * acos( cos( radians(43.6573378) ) * cos( radians( lat ) )     * cos( radians(lon) - radians(-79.55770129999996)) + sin(radians(43.6573378))     * sin( radians(lat)))) AS distance  FROM RES   where  s_r= 'Sale' and bath_tot >= 0 and br >= 0 and  lp_dol >= 500000 and rltr='$my_broker'  HAVING distance <= 20 order by distance asc   limit ".$start_mybroker.", 25";
# err_log($sql,__FILE_);
   if( $stmt = $mysqli->prepare($sql) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }
   }


if( $result !== NULL ){

?>

<div class="uk-width-medium-1-1 uk-container-center uk-margin" data-uk-slideset="{animation: 'scale', default: 3}">
            <div class="uk-slidenav-position uk-margin">
                <ul class="uk-slideset uk-grid uk-flex-center">
<?php
  $simgpath="/rs/500x400/r/$rimages/" ;
# err_log($simgpath,__FILE_);

 while ($row = $result->fetch_array()) {

   $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);

   extract($escapedListing);
   $mactive="";
   $cactive="";
   $aactive='class="uk-active"';
   if ($nimages == 0 ) {$nimages = 20;};
     $property_type=getPropertyType($type_own_srch) ;
     $is_maint = (  $s_r == 'Sale' && ( $property_type == 'condo' || $property_type=='townhouse'  ||  $type_tr == 'CND' ) );
     $ipath  = get_path_form_mln($ml_num);
     $img=$simgpath.$ipath."/image_".$ml_num."_1.jpg" ;
     err_log($ipath."/image_".$ml_num."_1.jpg",__FILE_);
     if ( ! file_exists("/wp/web/retsimages/".$ipath."/image_".$ml_num."_1.jpg") ){
                  continue;
     }
  
 ?>
               <li>
                    <figure class="uk-overlay uk-overlay-hover uk-thumbnail-large">
                        <img  width="500" height="400"  src="<?php echo $img ;?>" alt="<?php echo $addr;?>" title="<?php echo $addr;?>" />
                        <figcaption class="uk-overlay-panel uk-overlay-background uk-overlay-fade uk-flex uk-flex-center uk-flex-middle uk-text-center">
                           <div class="uk-grid" data-uk-grid-margin>
                                  <div class="uk-width-medium-1-1">
                                        <div class="uk-panel-badge uk-badge uk-badge-danger"><?php echo $s_r; ?>
                                        </div>
                                  </div>
                                  <div class="uk-width-medium-1-1 uk-text-left ">
                                      <font size="-4">  <?php echo $rltr;?> </font>
                                  </div>
                                  <div class="uk-width-medium-2-3 uk-text-left ">
                                        <div class="uk-text-small" ><?php echo $addr;?></div>
                                  </div>
                                  <div class="uk-width-medium-1-3 uk-text-right uk-text-bottom">
                                        <div class="uk-text-small" ><?php echo bd_nice_number($lp_dol);?></div>
                                  </div>
                            </div>
                        </figcaption>

                              <?php
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
                                <a class="uk-position-cover" href="<?php echo $page_url; ?>"></a>
                    </figure>
               </li>

<?php
 }
 #  mysql_free_result($result);
 ?>
                </ul>
            <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
            <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
            </div>
            <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
        </div>

<?php
 }
 ?>
