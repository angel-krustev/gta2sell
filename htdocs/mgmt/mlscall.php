<?php
include '/wp/config/config.php';
include '/wp/config/legacy_helpers.php';

// print state select box
// convert country code to country name
$ml_num = $_GET['ml_num'];
$ml_num = 'C5901171';
$result='N/A:N/A';

if(isset( $ml_num ) &&  $ml_num != '' ){
       $sql= "SELECT addr,s_r FROM $RES WHERE ml_num= ?";
   if( $stmt = $mysqli->prepare($sql) ){
       $stmt->bind_param("s",$ml_num);
       $stmt->execute();
       $get_result = $stmt->get_result();
       if ($get_result !== NULL ) {
           if( $row = $get_result->fetch_assoc() ){
                  if ($row["addr"]) {
                   $result=$row['s_r'].":".$row['addr'];
                 }
           }
       }
   }
}

    echo $result;

?>
