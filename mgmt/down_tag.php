<?php

include '../../config/config.php';
include '../../config/func.php';
$FEAT="FEATURED";

$ml_num = $_REQUEST['ml_num'];
$lorder = $_REQUEST['lorder'];
$sql="select ml_num , lorder as lorder from $FEAT where lorder < '$lorder' order by lorder desc limit 0,1 ;";
if( $stmt = $mysqli->prepare($sql) ){
       $stmt->execute();
       $result = $stmt->get_result();
       if( $result === NULL ){
         err_log('Mysql: [' . $mysqli->error . '] :'.$sql ,__FILE__);
         include 'opps-page.php';
       }else{
         $row = $result->fetch_assoc();
         print_r($row);
         $down_ml_num = $row["ml_num"];
         $loworder   = $row["lorder"];
         print($loworder);
         print($lorder);
         if($loworder >= $lorder || $loworder == '' ){
           echo json_encode(array('msg'=>'Reached the bottom.'));
         } else{
            $sql = "update $FEAT set lorder='$lorder' where ml_num='$down_ml_num'";
            #$result1 = @mysql_query($sql);
               if( $stmt1 = $mysqli->prepare($sql) ){
                   $stmt1->execute();
                   $result1 = $stmt1->get_result();
                   if( $result1 !== NULL ){
                      $sql = "update $FEAT set lorder='$uporder' where ml_num='$ml_num'";
                      #$result = @mysql_query($sql);
                      if( $stmt2 = $mysqli->prepare($sql) ){
                          $stmt2->execute();
                          $result2 = $stmt2->get_result();
                          if ($result2 !== NULL ){
                               echo json_encode(array('success'=>true));
                          } else {
                               echo json_encode(array('msg'=>'Some errors occured.'));
                          }
                      }
                  }
               } else {
                       echo json_encode(array('msg'=>'Some errors occured.'));
               }
         }
      }
}
?>
