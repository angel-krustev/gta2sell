<?php
include '/wp/config/config.php';
include '/wp/config/legacy_helpers.php';
$FEAT="FEATURED";
$success=true;
$ml_num = $_REQUEST['ml_num'];
$ml_num='C5901171';
#$ml_num='W5763683';
if(!isset($ml_num) || !ctype_alnum($ml_num) ){
    echo json_encode(array('msg'=>'Invalid MLS#'));
    exit;
}
        $sql="select max(lorder) as max from $FEAT;";

       if( $stmt = $mysqli->prepare($sql) ){
         $stmt->execute();
         $rs = $stmt->get_result();
       }
$row = $rs->fetch_array();
$max = $row["max"] +1;
echo $max;
$sql = "insert into $FEAT select *,'$max','','','','N','','','' from $RES where ml_num='$ml_num';";
if ( $stmt = $mysqli->prepare($sql) ){
     if ( ! $stmt->execute()) {
        $imgpath=get_path_form_mln($ml_num);
        $imgsrc = "$homedir/$rimages/$imgpath/image_{$ml_num}*.jpg";
        #$photos = system('ls '.$imgsrc, $has_photos);
        $photos = array();
        $photos = glob($imgsrc);
        if(count($photos) > 0 ){
            foreach ($photos as $photo) {
                $sql =  "insert into IMG_QUEUE set img='$photo' \n";
                if( $stmt1 = $mysqli->prepare($sql) ){
                if (mysql_affected_rows() < 1){
                    $success=false;
                }
            }
        }else{
                    $success=false;

        }
        if (!$success) {
	     echo json_encode(array('msg'=>'Couldn\'t copy the images.'));
        }
	echo json_encode(array('success'=>true));
    }else{
   echo 1;
	echo json_encode(array('success'=>false));

    }
} else {
	echo json_encode(array('msg'=>"Coudn\'t save the info. $sql"));
}
?>
