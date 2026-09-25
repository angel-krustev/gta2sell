<?php

$cid = intval($_GET['cid']);
include '../connect.php';


$sql = "delete from feed_map  where cid=$cid";
$result = @mysql_query($sql);
$sql = "insert into feed_map select "","$cid",template_name,name,tagname,mandatory,maintable from feed_map_template";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>'Some errors occured.'));
}
?>
