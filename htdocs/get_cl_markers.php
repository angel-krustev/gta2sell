<?php

require_once '../config/config.php';


$todayd=date("Y-m-d H:i:s");

$emp_image='data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNi4wLjQsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iNjAwcHgiIGhlaWdodD0iNDAwcHgiIHZpZXdCb3g9IjAgMCA2MDAgNDAwIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2MDAgNDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxyZWN0IGZpbGw9IiNGNUY1RjUiIHdpZHRoPSI2MDAiIGhlaWdodD0iNDAwIi8+DQo8ZyBvcGFjaXR5PSIwLjciPg0KCTxwYXRoIGZpbGw9IiNEOEQ4RDgiIGQ9Ik0yMjguMTg0LDE0My41djExM2gxNDMuNjMydi0xMTNIMjI4LjE4NHogTTM2MC4yNDQsMjQ0LjI0N0gyNDAuNDM3di04OC40OTRoMTE5LjgwOEwzNjAuMjQ0LDI0NC4yNDcNCgkJTDM2MC4yNDQsMjQ0LjI0N3oiLz4NCgk8cG9seWdvbiBmaWxsPSIjRDhEOEQ4IiBwb2ludHM9IjI0Ni44ODEsMjM0LjcxNyAyNzEuNTcyLDIwOC43NjQgMjgwLjgyNCwyMTIuNzY4IDMxMC4wMTYsMTgxLjY4OCAzMjEuNTA1LDE5NS40MzQgDQoJCTMyNi42ODksMTkyLjMwMyAzNTQuNzQ2LDIzNC43MTcgCSIvPg0KCTxjaXJjbGUgZmlsbD0iI0Q4RDhEOCIgY3g9IjI3NS40MDUiIGN5PSIxNzguMjU3IiByPSIxMC43ODciLz4NCjwvZz4NCjwvc3ZnPg0K';
$xmldom = new DOMDocument("1.0");
$node = $xmldom->createElement("markers");
$parnode = $xmldom->appendChild($node);
$query = "";
#START PARAMS
#
#START
$mlnum = htmlspecialchars($_POST['ml_num'], ENT_QUOTES);
$nelat = htmlspecialchars(isset($_POST['nelat']) && is_numeric($_POST['nelat'])? $_POST['nelat']:'0', ENT_QUOTES);
$nelng = htmlspecialchars(isset($_POST['nelng']) && is_numeric($_POST['nelng'])? $_POST['nelng']:'0', ENT_QUOTES);
$swlat = htmlspecialchars(isset($_POST['swlat']) && is_numeric($_POST['swlat'])? $_POST['swlat']:'0', ENT_QUOTES);
$swlng = htmlspecialchars(isset($_POST['swlng'])  && is_numeric($_POST['swlng'])? $_POST['swlng']:'0', ENT_QUOTES);
$ulat = htmlspecialchars(isset($_POST['ulat']) &&  is_numeric($_POST['ulat'])?$_POST['ulat']:'', ENT_QUOTES);
$ulon = htmlspecialchars(isset($_POST['ulon'])  && is_numeric($_POST['ulon'])?$_POST['ulon']:'', ENT_QUOTES);
$bed = htmlspecialchars(isset($_POST['bed']) && is_numeric($_POST['bed'])?$_POST['bed']:'0', ENT_QUOTES);
$bath = htmlspecialchars(isset($_POST['bath']) && is_numeric($_POST['bath'])?$_POST['bath']:'0', ENT_QUOTES);
$minp = htmlspecialchars(isset($_POST['minp'])&& is_numeric($_POST['minp'])?$_POST['minp']:'0', ENT_QUOTES);
$maxp = htmlspecialchars(isset($_POST['maxp'])&& is_numeric($_POST['maxp'])?$_POST['maxp']:'100000000', ENT_QUOTES);
$rtype = htmlspecialchars(isset($_POST['rtype'])?$_POST['rtype']:'', ENT_QUOTES);
$typeos = htmlspecialchars(isset($_POST['typeos'])?$_POST['typeos']:'-', ENT_QUOTES);
$s_r = htmlspecialchars(isset($_POST['s_r'])?$_POST['s_r']:'', ENT_QUOTES);
$zoom = htmlspecialchars($_POST['z'], ENT_QUOTES);
$c = htmlspecialchars(isset($_POST['c'])?$_POST['c']:'y', ENT_QUOTES);
$px = htmlspecialchars(isset($_POST['px'])?$_POST['px']:'50', ENT_QUOTES);
$ir = htmlspecialchars(isset($_POST['ir'])?'y':'', ENT_QUOTES);
$start = htmlspecialchars(isset($_POST['s']) && is_numeric($_POST['s'])?$_POST['s']:'0', ENT_QUOTES);
$o = htmlspecialchars(isset($_POST['order'])?$_POST['order']:'', ENT_QUOTES);
$radiusSearch = htmlspecialchars(isset($_POST['nr'])&&is_numeric($_POST['nr'])?$_POST['nr']:$radiusSearch, ENT_QUOTES);
$municipality= htmlspecialchars(isset($_POST['m'] )?$_POST['m']:'', ENT_QUOTES);
$community= htmlspecialchars(isset($_POST['com'] )?$_POST['com']:'', ENT_QUOTES);
$street= htmlspecialchars(isset($_POST['st'] )?$_POST['st']:'', ENT_QUOTES);
$limit= htmlspecialchars(isset($_POST['lm'] )?$_POST['lm']:$limit, ENT_QUOTES);

err_log('RTYPE: '.$_POST['rtype'].' '.$rtype);
err_log('Req: '.$_POST['ulat'].' '.$_POST['ulon'].' '.$mlnum);
#err_log($_POST['nelat'].' '.$_POST['nelng'].' '.$_POST['swlat'].' '.$_POST['swlng']);
//
#$px=60;
#$zoom='15';
#$ulat='43.65564335539605';
#$ulon='-79.35932570794876';
#$c='n';
#$ir='y';
#$swlat='43.6276924579519';
#$swlng='-79.4602625975972';
#$bed='1';
#$bath='1';
#$minp='50.00';
#$maxp='4550.00';
#$rtype='condo';
#$s_r='Lease';
if ($SEC_LEVEL1 && !verifyFormToken('fc')) {
    err_log("CSRF detected".$_POST['at'],__FILE__);
    header("Content-type: text/xml");
    echo $xmldom->saveXML();
}
//
    $total_rows ="";
    $twhere="";
if( "$is_my_realtor" == "Y" ){
    $twhere=" and rltr ilike 'RIGHT AT HOME REALTY%' " ;
}
include 'rtype.php';
err_log('TWHERE: '.$twhere);
$order="";
$startFrom=$start*$limit;
$lmt=" limit $limit offset $startFrom ";
$validTypos="D. S. Y. K. L. 6. 7. E. W. 2. C. P. T. A7. A. P. L. M 5. V. G. R. A6.";
if (strpos($validTypos, $typeos) !== false) {
     $twhere .= " and type_own_srch = '$typeos' ";

}


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
#$where="where ";
if( isset($municipality) &&  $municipality != '' ){
             $c = 'n';
             $is_municipality = $is_community = $is_street = false;
             if(  isset($municipality) &&  $municipality != '' ){
                   $where = " where municipality = ? ";
                   $is_municipality = true;
             }
             if(  isset($community) &&  $community != '' ){
                   $where .= " and  community = ? ";
                   $is_community = true;
             }
             if(  isset($street) &&  $street != '' ){
                   $where .= " and st = ? ";
                   $is_street = true;
             }

                   $query = "select  *, 1 as distance  FROM $RES $where $cwhere  $twhere $order $lmt $total_rows";
             if ( $stmt = $mysqli->prepare($query) ){
                       if($is_street ){
                        $stmt->bind_param("sss",$municipality,$community,$street );
                       }else if($is_community){
                        $stmt->bind_param("ss",$municipality,$community );
                       }else{
                        $stmt->bind_param("s",$municipality );
                       } 
             }

}else{
		if( $s_r != null && $s_r != '' ){
		      #$where="where  s_r= ? and bath_tot >= ? and br >= ? and (s_r = 'Lease' or (lp_dol >= ? and lp_dol <= ?) ) ";
		      $where="where  s_r= ? and bath_tot >= ? and br >= ? and  lp_dol >= ? and lp_dol <= ?  ";
		}else{
		      #$where="where             bath_tot >= ? and br >= ? and (s_r = 'Lease' or (lp_dol >= ? and lp_dol <= ?) ) ";
		      $where="where             bath_tot >= ? and br >= ? and lp_dol >= ? and lp_dol <= ? ";
		}


		if( $ulat !='' && $ulon != ''){
			 if($radiusSearch == '0' || $ir == ''){
				  #$cwhere = "and lat = ? and lon = ? "  ;
		 		  #$query = "select  * FROM $RES $where $cwhere  $twhere $order $lmt $total_rows";
				  $query = "select * from ( select *, ( 6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance  FROM $RES   $where  $twhere ) sub WHERE distance <= 0.05 $order $lmt $total_rows";
			     if ( $stmt = $mysqli->prepare($query) ){
		                if( $s_r != null && $s_r != '' ){
		                  $stmt->bind_param("siiii",$s_r, $bath,$bed, $minp, $maxp);
		                  #$stmt->bind_param("siiiidd",$s_r, $bath,$bed, $minp, $maxp,$ulat,$ulon);
		                }else{
		                  #$stmt->bind_param("iiiidd",$bath,$bed, $minp, $maxp,$ulat,$ulon);
		                  $stmt->bind_param("iiii", $bath,$bed, $minp, $maxp);
		                }
                             }
		
			 }else{
				  $query = "select * from ( select *, ( 6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance  FROM $RES   $where  $twhere ) sub WHERE distance <= $radiusSearch $order $lmt $total_rows";
			     if ( $stmt = $mysqli->prepare($query) ){
		                if( $s_r != null && $s_r != '' ){
		                  $stmt->bind_param("siiii",$s_r, $bath,$bed, $minp, $maxp);
		                }else{
		                  $stmt->bind_param("iiii", $bath,$bed, $minp, $maxp);
		                }
                             }
		
			 }
		}else if(isset($swlat) && $swlat != 0 && isset($nelng) && $nelng != 0 && isset($nelat) && $nelat != 0 && isset($swlng) && $swlng != 0  ){
                                  $lmt="";
				  $rwhere = "and lat >=  ? and lat <= ? and lon <= ? and lon >= ? "  ;
			 	  $query = "select * from $RES $where $rwhere $twhere $order $lmt $total_rows"  ;
			     if ( $stmt = $mysqli->prepare($query) ){
		                if( $s_r != null && $s_r != '' ){
		                  $stmt->bind_param("siiiidddd",$s_r, $bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
		                }else{
		                  $stmt->bind_param("iiiidddd",$bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
		                }
	                     }	
		}
}
/*
*/
err_log( $query);
if (isset($stmt) && $stmt !== NULL){
	$stmt->execute();
	$result = $stmt->get_result();
	header("Content-type: text/xml");
	$clustered   = array();
	$condomarkers   = array();
	$housemarkers   = array();
	$townhousemarkers   = array();
	$parkingmarkers   = array();
	while ($row = $result->fetch_assoc()) {
	  // ADD TO XML DOCUMENT NODE
          $escapedListing = array_map(array($mysqli, 'real_escape_string'), $row);

	  extract($escapedListing);
	  $Dom=hDays($todayd,$updated);
	  #$dom=$Dom->format('%d')+$dom;
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
	
	 if($mlnum != $ml_num ){  
	   $p_type = getPropertyType($type_own_srch) ;
	   $ipath  = get_path_form_mln($ml_num);
	   $img  = get_property_image_url_or_placeholder($nimages, $media_listing_key, $ml_num, 1, 600, 400);
           err_log( $img );
	#END
	   if( $c  == 'y' ){
	       if( $p_type  == 'house' ){
	       $housemarkers[]=array(
	                   'id' => $ml_num,
	                   'img' => $img,
	                   'ipath' => $ipath,
	                   'lat' => $lat, 'lon' => $lon,
	                   'lp_dol' => $lp_dol,
	                   'addr' => $addr,
	                   'community' => $community,
	                   'dis_addr' => $disp_addr,
	                   'bed' => $br,
	                   'bath' => $bath_tot,
	                   'building' => $p_type,
	                   'type_own_srch' => $type_own_srch,
	                   'type_own1_out' => $type_own1_out,
	                   'rltr' => $rltr,
	                   'dom' => $dom,
	                   'updated' => $updated,
	                   'municipality' => $municipality,
	                   'ipath' => $ipath,
	                   'ml_num' => $ml_num,
	                   's_r' => $s_r,
	                   'page_url' => $page_url,
	                   'max' => 0,
	                   'min' => 0
	                  );
	       }else if ( $p_type == 'condo') {
	       $condomarkers[]=array(
	                   'id' => $ml_num,
	                   'img' => $img,
	                   'lat' => $lat, 'lon' => $lon,
	                   'lp_dol' => $lp_dol,
	                   'addr' => $addr,
	                   'addr' => $addr,
	                   'community' => $community,
	                   'dis_addr' => $disp_addr,
	                   'bed' => $br,
	                   'bath' => $bath_tot,
	                   'building' => $p_type,
	                   'type_own_srch' => $type_own_srch,
	                   'type_own1_out' => $type_own1_out,
	                   'rltr' => $rltr,
	                   'dom' => $dom,
	                   'updated' => $updated,
	                   'municipality' => $municipality,
	                   'ml_num' => $ml_num,
	                   'ipath' => $ipath,
	                   's_r' => $s_r,
	                   'page_url' => $page_url,
	                   'max' => 0,
	                   'min' => 0
	                  );
	       }else if ( $p_type == 'townhouse' ) {
	       $townhousemarkers[]=array(
	                   'id' => $ml_num,
	                   'img' => $img,
	                   'lat' => $lat, 'lon' => $lon,
	                   'lp_dol' => $lp_dol,
	                   'addr' => $addr,
	                   'community' => $community,
	                   'dis_addr' => $disp_addr,
	                   'bed' => $br,
	                   'bath' => $bath_tot,
	                   'building' => $p_type,
	                   'type_own_srch' => $type_own_srch,
	                   'type_own1_out' => $type_own1_out,
	                   'rltr' => $rltr,
	                   'dom' => $dom,
	                   'updated' => $updated,
	                   'municipality' => $municipality,
	                   'ml_num' => $ml_num,
	                   'ipath' => $ipath,
	                   's_r' => $s_r,
	                   'page_url' => $page_url,
	                   'max' => 0,
	                   'min' => 0
	                  );
	       }else if ( $p_type == 'parking' ) {
	       $parkingmarkers[]=array(
	                   'id' => $ml_num,
	                   'img' => $img,
	                   'lat' => $lat, 'lon' => $lon,
	                   'lp_dol' => $lp_dol,
	                   'addr' => $addr,
	                   'community' => $community,
	                   'dis_addr' => $disp_addr,
	                   'bed' => $br,
	                   'bath' => $bath_tot,
	                   'building' => $p_type,
	                   'type_own_srch' => $type_own_srch,
	                   'type_own1_out' => $type_own1_out,
	                   'rltr' => $rltr,
	                   'dom' => $dom,
	                   'updated' => $updated,
	                   'municipality' => $municipality,
	                   'ml_num' => $ml_num,
	                   'ipath' => $ipath,
	                   's_r' => $s_r,
	                   'page_url' => $page_url,
	                   'max' => 0,
	                   'min' => 0
	                  );
	       } #b type
	  }else{
	       $clustered[]=array(
	                   'id' => $ml_num,
	                   'img' => $img,
	                   'ipath' => $ipath,
	                   'lat' => $lat, 'lon' => $lon,
	                   'lp_dol' => $lp_dol,
	                   'addr' => $addr,
	                   'community' => $community,
	                   'dis_addr' => $disp_addr,
	                   'bed' => $br,
	                   'bath' => $bath_tot,
	                   'building' => $p_type,
	                   'type_own_srch' => $type_own_srch,
	                   'type_own1_out' => $type_own1_out,
	                   'rltr' => $rltr,
	                   'dom' => $dom,
	                   'updated' => $updated,
	                   'municipality' => $municipality,
	                   'ipath' => $ipath,
	                   'ml_num' => $ml_num,
	                   's_r' => $s_r,
	                   'page_url' => $page_url,
	                   'max' => 0,
	                   'min' => 0
	                  );
	
	  } # cluster check
	
	 }#mlnum check
	
	}# while
        if( $c  == 'y' ){
              $clustered = array_merge($townhousemarkers,$condomarkers);
              $clustered = array_merge($clustered,$housemarkers);
              $clustered = cluster($clustered, $px, $zoom);
        }
        $stmt->close();
}else{
         err_log("Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error );
}

	if (isset($mysqli)){
	    $mysqli->close();
	};

  // When $c != 'y' (e.g. municipality search) rows are pushed directly into
  // $clustered as flat marker arrays instead of grouped lists; normalize so
  // the rendering loop below always sees a list of 1+ marker arrays per entry.
  foreach ($clustered as $k => $entry) {
      if (is_array($entry) && !array_key_exists(0, $entry)) {
          $clustered[$k] = array($entry);
      }
  }

  $total=count($clustered);
  $mr=$total-$limit;
  while (count($clustered) > 0) {
       $marker  = array(); 
       $markers  = array(); 
       $markers = array_pop($clustered);
       if (empty($markers)) { continue; }
       $lats = array_column($markers, 'lat');
       $lons = array_column($markers, 'lon');
       if (empty($lats) || empty($lons)) { continue; }
       $minLat = min($lats);
       $maxLat = max($lats);
       $minLon = min($lons);
       $maxLon = max($lons);
       $s_r = max(array_column($markers, 's_r'));
       $count = count($markers);
       if(isset($markers[1]) ){
        $min = min(array_column($markers, 'lp_dol'));
        $max = max(array_column($markers, 'lp_dol'));
        $marker = array_pop($markers);
        $marker['min'] = bd_nice_number($min);
        $marker['max'] = bd_nice_number($max);
        $marker['count'] = $count;
        err_log("Addr: ".$marker['addr']." ". $minLat." ".$maxLat);
        if($minLat ==  $maxLat && $minLon == $maxLon){
          $marker['multiple']='y';
        }else{
          $marker['multiple']='n'; 
        }
       } else{
        $marker = $markers[0];
        $marker['count'] = 1;
       }
       $node = $xmldom->createElement("marker");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("lp_dol",$marker['lp_dol']);
       $newnode->setAttribute("asking",bd_nice_number($marker['lp_dol']));
       $newnode->setAttribute("addr", 'N/A');
       $newnode->setAttribute("bed", $marker['bed']);
       $newnode->setAttribute("bath", $marker['bath']);
       if( $marker['dis_addr'] == 'Y' ){ 
           $newnode->setAttribute("addr",  $marker['addr']) ;
           $newnode->setAttribute("apt_num",  $marker['apt_num']); 
       }else{
           $newnode->setAttribute("addr",  'N/A') ;
           $newnode->setAttribute("apt_num",  'N/A'); 
       }
           $newnode->setAttribute("lat", $marker['lat']);
           $newnode->setAttribute("lon", $marker['lon']);
           if( $marker['count'] > 1){
               $newnode->setAttribute("icon",'clusterhouse' );
               $newnode->setAttribute("min", $marker['min']);
               $newnode->setAttribute("max", $marker['max']);
               $newnode->setAttribute("asking","");
               $newnode->setAttribute("bed","");
               $newnode->setAttribute("bath","");
           }else{
               $newnode->setAttribute("icon", $marker['building'] );
           }
           $newnode->setAttribute("type_own_srch", $marker['type_own_srch']);
           $newnode->setAttribute("type_own1_out", $marker['type_own1_out']);
           $newnode->setAttribute("building", $marker['building']);
           $newnode->setAttribute("community", $marker['community']);
           $newnode->setAttribute("dom", $marker['dom']);
           $newnode->setAttribute("rltr", $marker['rltr']);
           $newnode->setAttribute("count", $marker['count']);
           $newnode->setAttribute("municipality", $marker['municipality']);
           $newnode->setAttribute("ml_num", $marker['ml_num']);
           $newnode->setAttribute("ipath", $marker['ipath']);
           $newnode->setAttribute("img", isset($marker['img']) ? $marker['img'] : $emp_image);
           $newnode->setAttribute("multiple", $marker['multiple']);
           $newnode->setAttribute("s_r",  $marker['s_r']);
           $newnode->setAttribute("page_url",  $marker['page_url']);
           $newnode->setAttribute("cluster", $c);
           $newnode->setAttribute("mr", $mr);
  //         $newnode->setAttribute("sql", $query);
  }
echo $xmldom->saveXML();
?>
