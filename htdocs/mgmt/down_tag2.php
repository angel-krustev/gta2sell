<?php

include '../../config/config.php';
include '../../config/legacy_helpers.php';
$FEAT="FEATURED";

$ml_num = $_REQUEST['ml_num'];
$lorder = $_REQUEST['lorder'];
$result=mysql_query("select ml_num , lorder as lorder from $FEAT where lorder < '$lorder' order by lorder desc limit 0,1 ;");
$row = mysql_fetch_array($result);
$up_ml_num = $row["ml_num"];
$loworder   = $row["lorder"];
if($loworder >= $lorder || $loworder == ''  ){
       echo json_encode(array('msg'=>'Reached the bottom.'));
} else{
       $sql = "update $FEAT set lorder='$lorder' where ml_num='$up_ml_num'";
       $result = @mysql_query($sql);
   if ($result){
       $sql = "update $FEAT set lorder='$loworder' where ml_num='$ml_num'";
       $result = @mysql_query($sql);
    	     if ($result){
		echo json_encode(array('success'=>true));
     	     } else {
		echo json_encode(array('msg'=>'Some errors occured.'));
	     } 
   } else {
		echo json_encode(array('msg'=>'Some errors occured.'));
   } 

}
?>
