<?php
define( 'INCLUDE_DIR', dirname( __FILE__ ) . '/' );
require_once 'vendor/autoload.php';
require_once '../config/config.php';
require_once '../config/func.php';
require_once 'signup/includes/functions.php';
require_once 'signup/includes/main.php';
require_once '../config/global.php';

$FEAT="FEATURED";
$showslide='Y';
$featured='Y';
  $sql="select * from $FEAT where disabled <> 'Y' order by lorder desc ";
   if( $stmt = $mysqli->prepare($sql) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }
   }

?>

<div class="uk-width-medium-1-1 uk-container-center uk-margin" data-uk-slideset="{animation: 'scale', default: 3}">
            <div class="uk-slidenav-position uk-margin">
                <ul class="uk-slideset uk-grid uk-flex-center">

<?php
        $simgpath="/rs/550x400/r/featimages/" ;
 while ($row = $result->fetch_array()) {
   $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
   extract($escapedListing);
   $mactive="";
   $cactive="";
   $aactive='class="uk-active"';
   if ($nimages == 0 ) {$nimages = 20;};
   $property_type=getPropertyType($type_own_srch) ;
   $is_maint = (  $s_r == 'Sale' && ( $property_type == 'condo' || $property_type=='townhouse'  ||  $type_tr == 'CND' ) );
   $img=$simgpath."/image_".$ml_num."_1.jpg" ;
 ?>
               <li>
                    <figure class="uk-overlay uk-overlay-hover">
                        <img  width="450" height="300"  src="<?php echo $img ;?>" alt="<?php echo $addr;?>" title="<?php echo $addr;?>" />
                        <figcaption class="uk-overlay-panel uk-overlay-background uk-overlay-fade uk-flex uk-flex-center uk-flex-middle uk-text-center">
                           <div class="uk-panel-badge uk-badge uk-badge-danger"><?php echo $s_r; ?></div>
                           <div class="uk-text-small" ><?php echo $addr;?></div>
                        </figcaption>

                            <?php
                             if( $is_in_mls == 'Y'  ){
                                  $page_url = "";
                                  $full_addr = "";
                                  if( $disp_addr == 'Y' ){
                                      $full_addr=($apt_num != '')?$addr."_".$apt_num:$addr;
                                  }
                                  if( $disp_addr != 'Y' || $full_addr == '' ){
                                      #$page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($municipality)."/MLS/".$ml_num;
                                      $page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($municipality)."/MLS/".$ml_num;
                                   }else{
                                      #$page_url = "/".url_cooker($municipality)."-real-estate/".url_cooker($community)."/".url_cooker($full_addr) ;
                                      $page_url = '/my-new-featured-properties/MLS/'.$ml_num; 
                                   }
                                ?>
                                <a class="uk-position-cover" href="<?php echo $page_url; ?>"></a>
                                <?php
                             }else{
                                ?>
<a class="uk-position-cover" href="<?php echo '/my-featured-properties/MLS/'.$ml_num.'/'.url_cooker($municipality)."/".url_cooker($addr); ?>"></a>
                                <?php
                                 }
                                ?>
                    </figure>
               </li>

<?php
 }
   #mysql_free_result($result);
 ?>
               </ul>
            <a href="#" class="uk-slidenav uk-slidenav-previous" data-uk-slideset-item="previous"></a>
            <a href="#" class="uk-slidenav uk-slidenav-next" data-uk-slideset-item="next"></a>
            </div>
            <ul class="uk-slideset-nav uk-dotnav uk-flex-center"></ul>
        </div>
