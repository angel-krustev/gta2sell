<?php

include '../../config/config.php';
include '../../config/legacy_helpers.php';
$FEAT="FEATURED";
$ml_num = $_REQUEST['ml_num'];
$is_price_display = $_REQUEST['is_price_display'];
$msg1 = $_REQUEST['msg1'];
$msg2 = $_REQUEST['msg2'];
$disabled = $_REQUEST['disabled'];
$s_r = $_REQUEST['s_r'];

$sql = "update $FEAT set s_r='$s_r', disabled='$disabled', msg1='$msg1',msg2='$msg2', is_price_display='$is_price_display' where ml_num='$ml_num'";
     if ( $stmt = $mysqli->prepare($sql) ){
               if ( ! $stmt->execute()) {
        echo json_encode(array('msg'=>'Some errors occured.'));

               }
      }else{
        echo json_encode(array('msg'=>'Some errors occured.'));
      }
?>
