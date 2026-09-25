<?php
include '/wp/config/config.php';
include '/wp/config/legacy_helpers.php';
$FEAT="FEATURED";
$success=true;
$ml_num = $_REQUEST['ml_num'];
if(!isset($ml_num) || !ctype_alnum($ml_num) ){
    echo json_encode(array('msg'=>'Some errors occured. '.$ml_num));
    exit;
}

$sql = "delete from $FEAT  where ml_num='$ml_num'";
$result = @mysql_query($sql);
if ($result){
        $imgsrc = "$homedir/$featimages/image_{$ml_num}*.jpg";
        $photos = array();
        $photos = glob($imgsrc);
        if(count($photos) > 0 ){
            foreach ($photos as $photo) {
                $sql =  "insert into IMG_QUEUE set img='$photo',action='D' \n";
                @mysql_query($sql);
                if (mysql_affected_rows() < 1){
                    $success=false;
                }
            }
        }else{
                    $success=false;
        }
        if ($success){
	    echo json_encode(array('success'=>true));
        } else {
            echo json_encode(array('msg'=>'Some errors occured with the images. 2'));
        }
} else {
	echo json_encode(array('msg'=>'Some errors occured. 3'));
}
?>
