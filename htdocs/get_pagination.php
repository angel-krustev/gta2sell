<?php

require_once '../config/config.php';

// Start XML file, create parent node

$nelng = isset($_GET['nelng'])?$_GET['nelng']:'-79.391693';
$nelat = isset($_GET['nelat'])?$_GET['nelat']:'43.67394';
$swlat = isset($_GET['swlat'])?$_GET['swlat']:'43.644';
$swlng = isset($_GET['swlng'])?$_GET['swlng']:'-79.447';
$lat = isset($_GET['lat'])?$_GET['lat']:'43.64325869280' ;
$lng = isset($_GET['lng'])?$_GET['lng']:'-79.3764034510' ;
$addr = isset($_GET['addr'])?$_GET['addr']:'';
$ip = isset($_GET['ip'])?$_GET['ip']:'';
$ulat = isset($_GET['ulat'])?$_GET['ulat']:'';
$ulon = isset($_GET['ulon'])?$_GET['ulon']:'';
$s_r = isset($_GET['s_r'])?$_GET['s_r']:'Sale';
$t = isset($_GET['t'])?$_GET['t']:'';
$start = isset($_GET['start'])?$_GET['start']:'0';
$zoom='14';
$start=0;
// Opens a connection to a MySQL server

$todayd=date("Y-m-d H:i:s");

header("Content-type: text/xml");

// Select all the rows in the markers table
if( $ulat !='' && $ulon != ''){
 $order = "";
 $query = "select count(distance)  as total from ( select  ( 6372 * acos( cos( radians($ulat) ) * cos( radians( lat ) )     * cos( radians(lon) - radians($ulon)) + sin(radians($ulat))     * sin( radians(lat)))) AS distance  FROM $RES ) c WHERE distance < $radiusSearch";

}else{
    $where = " where s_r='$s_r' and lat >  $swlat and lat < $nelat and lon < $nelng and lon > $swlng "  ;
    $order = $order = ''?' order by ':'';
    $query = "select count(ml_num) as total from $RES $where limit $size offset $start"  ;
}


#$where = " where s_r='$s_r' and lat >  $swlat and lat < $nelat and lon < $nelng and lon > $swlng "  ;
#$query = "select count(ml_num) as total from $RES $where"  ;
#$result = mysql_query($query);
#if (!$result) {
#  die('Invalid query: ' . mysql_error());
#}
   if( $stmt = $mysqli->prepare($query) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }
   }

$data=$result->fetch_assoc();
$numPage = intval ($data['total']/$size);
$curPage = intval ($start/$size)+1;
$startPage = $rangePage%$curPage;
$endPage = $numPage > $rangePage?$rangePage:$numPage;
 
       if( $numPage > 1){
        $ht='<ul class="uk-pagination">';
                 if($curPage == 1){
        $ht=$ht.'<li class="uk-disabled"><span><i class="uk-icon-angle-double-left"></i></span></li>';
                 }else{
        $ht=$ht.'<li><span><i class="uk-icon-angle-double-left"></i></span></li>';
                 }
                    for ($i = $startPage+1; $i <= $endPage; $i++) { 
                       if( $curPage == $i){
                                $ht=$ht.'<li class="uk-active"><span>'.$i.'</span></li>';

                       }else{
                                $ht=$ht.'<li><a href="#">'.$i.'</a></li>';
                    
                       }
                    }
                 if($curPage == $numPage){
                                $ht=$ht.'<li class="uk-disabled" ><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>';
                 }else{
                                $ht=$ht.'<li><a href="#"><i class="uk-icon-angle-double-right"></i></a></li>';
                 }
                                $ht=$ht.'</ul>';
       }
       $xmldom = new DOMDocument("1.0");
       $node = $xmldom->createElement("results");
       $parnode = $xmldom->appendChild($node);
       $node = $xmldom->createElement("result");
       $newnode = $parnode->appendChild($node);
       $newnode->setAttribute("pagination",$ht);
       $newnode->setAttribute("totals",'Found '.$data['total'].' properties in radius of '.$radiusSearch.'km np:'.$numPage );
       echo $xmldom->saveXML();
 
          ?>
