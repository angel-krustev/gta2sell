<?php
 require_once("/wp/config/config.php");
 require_once("/wp/config/func.php");

 $fml_num='C3423544';
 $imgpath=get_path_form_mln($ml_num);
 $imgsrc = "$homedir/$rimages/$imgpath/image_{$ml_num}*.jpg";
 $photos = system('ls '.$imgsrc, $has_photos);

 if($has_photos){
     foreach ($photos as $photo) {
            $sql =  "insert into IMG_QUEUE set img='$photo' \n";
            $result = @mysql_query($sql);
            if (!$result){
                $success=false; 
            }
 }
    

#$photos = system('cp '.$imgsrc.' /wp/web/featimages/', $has_photos);
?>
