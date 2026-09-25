<?php

require_once '../config/config.php';

// Start XML file, create parent node
if ($SEC_LEVEL1 && !verifyFormToken('fc')) {
    err_log("CSRF detected",__FILE__);
    exit;
}


$mlnum = $_POST['ml_num'];
$nelat = isset($_POST['nelat']) && is_float($_POST['nelat'])? $_POST['nelat']:'0';
$nelng = isset($_POST['nelng']) && is_float($_POST['nelng'])? $_POST['nelng']:'0';
$swlat = isset($_POST['swlat']) && is_float($_POST['swlat'])? $_POST['swlat']:'0';
$swlng = isset($_POST['swlng'])  && is_float($_POST['swlng'])? $_POST['swlng']:'0';
$ulat = isset($_POST['ulat']) && ( is_float($_POST['ulat']) || is_numeric($_POST['ulat']))?$_POST['ulat']:'';
$ulon = isset($_POST['ulon'])  && ( is_float($_POST['ulon']) || is_numeric($_POST['ulon']))?$_POST['ulon']:'';
$bed = isset($_POST['bed']) && is_numeric($_POST['bed'])?$_POST['bed']:'0';
$bath = isset($_POST['bath']) && is_numeric($_POST['bath'])?$_POST['bath']:'0';
$minp = isset($_POST['minp'])&& is_numeric($_POST['minp'])?$_POST['minp']:'0';
$maxp = isset($_POST['maxp'])&& is_numeric($_POST['maxp'])?$_POST['maxp']:'100000000';
$rtype = isset($_POST['rtype'])?$_POST['rtype']:'';
$s_r = isset($_POST['s_r'])?$_POST['s_r']:'';
$zoom = $_POST['z'];
$c = isset($_POST['c'])?$_POST['c']:'y';
$px = isset($_POST['px'])?$_POST['px']:'30';
$ir = isset($_POST['ir'])?'y':'';
$start = isset($_POST['s']) && is_numeric($_POST['s'])?$_POST['s']:'0';
$o = isset($_POST['order'])?$_POST['order']:'';
$radiusSearch = isset($_POST['nr'])&&is_numeric($_POST['nr'])?$_POST['nr']:$radiusSearch;
$municipality= isset($_POST['m'] )?$_POST['m']:'';
$community= isset($_POST['com'] )?$_POST['com']:'';
$currentPage = isset($_POST['s']) && is_numeric($_POST['s'])?$_POST['s']:'0';
$radiusSearch = isset($_POST['nr'])?$_POST['nr']:$radiusSearch;
//


err_log("RTYPE: ".$rtype);
err_log("Q:".$ulat);
//
    $total_rows ="";
    $twhere="";
include 'rtype.php';

  if( $s_r != null && $s_r != '' ){
      #$where="where  s_r= ? and bath_tot >= ? and br >= ? and (s_r = 'Lease' or (lp_dol >= ? and lp_dol <= ?) ) ";
      $where="where  s_r= ? and bath_tot >= ? and br >= ? and lp_dol >= ? and lp_dol <= ?  ";
  }else{
      #$where="where  bath_tot >= ? and br >= ? and (s_r = 'Lease' or (lp_dol >= ? and lp_dol <= ?) ) ";
      $where="where  bath_tot >= ? and br >= ? and lp_dol >= ? and lp_dol <= ?  ";
  }

$order="";
if( $o != '' ){
              if( $o == 'pl' ){
                  $order = "  order by lp_dol ";
              }else if( $o == 'ph' ){
                  $order = "  order by lp_dol desc";
              }else if( $o == 'dh' ){
                  $order = "  order by dom desc";
              }else if( $o == 'dl' ){
                  $order = "  order by dom ";
              }
}
#$where="where ";
if( $ulat !='' && $ulon != ''){
         if($c == 'n' && $ir == ''){
                  $cwhere = "and lat = ? and lon = ? "  ;
                  $query = "select  count(ml_num)  as total FROM $RES $where $cwhere  $twhere  ";
                  $stmt = $mysqli->prepare($query);
                if( $s_r != null && $s_r != '' ){
                  $stmt->bind_param("siiiidd",$s_r, $bath,$bed, $minp, $maxp,$ulat,$ulon);
                }else{
                  $stmt->bind_param("iiiidd",$bath,$bed, $minp, $maxp,$ulat,$ulon);
                }

         }else{
                  $query = "select count(distance)  as total from ( select ( 6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance  FROM $RES   $where  $twhere ) as c WHERE distance <= $radiusSearch";
                  $stmt = $mysqli->prepare($query);
                if( $s_r != null && $s_r != '' ){
                  $stmt->bind_param("siiii",$s_r, $bath,$bed, $minp, $maxp);
                }else{
                  $stmt->bind_param("iiii", $bath,$bed, $minp, $maxp);
                }

         }
}else{
                  $rwhere = "and lat >=  ? and lat <= ? and lon <= ? and lon >= ? "  ;
                  $query = "select count(ml_num) as total from $RES $where $rwhere $twhere  "  ;
                  $stmt = $mysqli->prepare($query);
                if( $s_r != null && $s_r != '' ){
                  $stmt->bind_param("siiiidddd",$s_r, $bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
                }else{
                  $stmt->bind_param("iiiidddd",$bath,$bed, $minp, $maxp, $swlat,$nelat,$nelng,$swlng);
                }

}
err_log("Q:".$query);

$todayd=date("Y-m-d H:i:s");
///////
header("Content-type: text/xml");
$stmt->execute();
$result = $stmt->get_result();
$ht = '';
$xmldom = new DOMDocument("1.0");
if ($row = $result->fetch_assoc() ){

   $currentPage  = $currentPage+1;
   $totalNumPage = ($row['total']==$limit)?1:intval ($row['total']/$limit)+1;
   $currentPage  = $currentPage > $totalNumPage?$totalNumPage:$currentPage;
   $currentPage  = $currentPage < 1?1:$currentPage;
   $rangePage = $rangePage > $totalNumPage?$totalNumPage:$rangePage;
   $startPage =  ($rangePage%$currentPage)*$currentPage;
   $endPage = $startPage+$rangePage;
   $endPage = $endPage <= $totalNumPage?$endPage:$totalNumPage;
   $startPage = $currentPage<$rangePage?1:$rangePage%$currentPage+1;


       if( $totalNumPage > 1){
                    $ht=$ht.'<ul class="uk-pagination">';
                 if($currentPage <= 1){
                    $ht=$ht.'<li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>';
                 }else{
                    $ht=$ht.'<li class="uk-active"><a href="#" onclick="loadPage('.($currentPage-2).')"><i class="uk-icon-angle-double-left"></i></a></li>';
                 }
                 for ($i = $startPage; $i <= $endPage; $i++) { 
                     if( $currentPage == $i){
                                $ht=$ht.'<li class="uk-active"><span>'.($i).'</span></li>';

                     }else{
                                $ht=$ht.'<li><a href="#" onclick="loadPage('.($i-1).')">'.($i).'</a></li>';
                    
                     }
                 }
                 if($currentPage == $totalNumPage){
                                $ht=$ht.'<li class="uk-disabled" ><span><i class="uk-icon-angle-double-right"></i></</span></li>';
                 }else{
                                $ht=$ht.'<li><a href="#" onclick="loadPage('.($currentPage).')" ><i class="uk-icon-angle-double-right"></i></a></li>';
                 }
                                $ht=$ht.'</ul>';
       }
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("pagination",$ht);
       $newnode->setAttribute("totals",'Found '.$row['total'].' properties in radius of '.$radiusSearch.'km ');
 }
       echo $xmldom->saveXML();
 
?>
