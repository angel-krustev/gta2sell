<?php
include '/wp/config/config.php';
include '/wp/config/func.php';
$FEAT="FEATURED";
 $result = array();
 $items = array();


	$sql="select ml_num,addr,disabled,lorder,s_r,msg1,msg2 from $FEAT order by lorder DESC";

       if( $stmt = $mysqli->prepare($sql) ){
         $stmt->execute();
         $rs = $stmt->get_result();
         while ($row = $rs->fetch_array()) {
	        array_push($items, $row);
	        $result["rows"] = $items;
         }
       }
	$result["rows"] = $items;
	echo json_encode($result);

?>
