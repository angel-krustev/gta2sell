<?php

require_once '../config/config.php';

$start = isset($_GET['s']) && is_numeric($_GET['s'])?$_GET['s']:'0';
$o = isset($_GET['order'])?$_GET['order']:'';
$radiusSearch = isset($_GET['nr'])?$_GET['nr']:$radiusSearch;
$total_rows ="";
$twhere="";
$are_all_param=false;
if( isset($municipality) &&  $municipality != '' ){
	$where="where municipality = ? ";  
	if( isset($community) &&  $community != '' ){
	      $where .=" and community = ? ";
              $are_all_param = true;
	}else if( isset($street) &&  $street != '' ){


        }
	
	  $order="";
	  $startFrom=$start*$limit;
	  $lmt=" limit $limit offset $startFrom ";
	if( $o != '' ){
	              if( $o == 'pl' ){
			  $order = "  order by lp_dol ";
	              }else if( $o == 'ph' ){
			  $order = "  order by lp_dol desc";
	              }else if( $o == 'lc' ){
			  $order = "  order by distance";
	              }else if( $o == 'dh' ){
			  $order = "  order by dom desc";
	              }else if( $o == 'dl' ){
			  $order = "  order by dom ";
	              }
	} 
		 	  $query = "select * from $RES $where $order $lmt $total_rows"  ;
	if ( !$are_all_param   ){
	    if ($stmt = $mysqli->prepare($query) ){
	                $stmt->bind_param('s',$municipality);
	    }
         }else{
	    if ($stmt = $mysqli->prepare($query) ){
	                $stmt->bind_param('ss',$municipality,$community);
	    }
         }
	
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
          $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);
	  extract($escapedListing);
	  $Dom=hDays($todayd,$updated);
	  $page_url = "";
	  $full_addr = "";
	  if( $disp_addr == 'Y' ){
	      $full_addr=($apt_num != '')?$addr."_".$apt_num:$addr;
	  }
	  if( $disp_addr != 'Y' || $full_addr == '' ){ 
	      $page_url = '/real-estate/'.url_cooker($municipality)."/MLS/".url_cooker($ml_num);
	   }else{
	      $page_url = '/real-estate/'.url_cooker($municipality)."/".url_cooker($full_addr);
	   }
	
	 if($mlnum != $ml_num ){  
	   $p_type = getPropertyType($type_own_srch) ;
	   $ipath  = get_path_form_mln($ml_num);
	   $img  = get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, 1, 600, 400);
	 }
	}
}
// NOTE: this endpoint is unused/unreferenced elsewhere in the app and was left
// unfinished (no output/response was ever written after the loop above).
