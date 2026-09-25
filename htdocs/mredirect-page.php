<body  class="tm-background"  >
<?php
$name=$_GET['full_name'];
$email=$_GET['email'];
$phone=$_GET['phone'];
$g_addr=$_GET['g_addr'];
$g_datafield=explode(":",$_GET['g_datafield']);
$g_property_type=$g_datafield[0];
$g_beds=$g_datafield[1];
$g_baths=$g_datafield[2];
$g_garage=$g_datafield[3];
$g_sqft=$g_datafield[4];
$g_planing=$g_datafield[5];
$lat=$g_datafield[6];
$lon=$g_datafield[7];
$g_token=$_GET['g_token'];
rate_limit($_SERVER['REMOTE_ADDR']);
 if( isset($email) && $_SESSION['what_it_worth'] == $g_token ){
       rate_limit_tick($_SERVER['REMOTE_ADDR'], $_GET['email']);
       $cookie = base64_encode($email);
       $user = User::createFull($email,$phone,$name,'C');
?>
 <script>
     setCookie('em','<?php echo $cookie ;?>',5256000);
</script>
<?php 
       $query = "select count(*) c from evaluations where token = ? ";
       if ($cstmt = $mysqli->prepare($query) ){
           $cstmt->bind_param('s',$g_token);
       }
       $cstmt->execute();
       $result = $cstmt->get_result();
       if ($row = $result->fetch_assoc()) {
          err_log("Error Row: ".$row['c'] ,__FILE__);
          if( $row['c'] != 0 ){
              ?>
               <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/404' ?>'",10); </script>
              <?php
               die("");
          }

       }else{
             ?>
                <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/404' ?>'",10); </script>
             <?php
               die("");
       }
       $sid=$_SESSION['tr'];
       $pred_avr="";
       $message="";
       $landing="";
       $cem="-";
       $ip_ra=$_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:'-';
       $ip_fw=$_SERVER['HTTP_X_FORWARDED_FOR']!=''?$_SERVER['HTTP_X_FORWARDED_FOR']:'-';
       $tracksql = "INSERT INTO evaluations (session,ip_fw,ip_ra, cookie_email, email,full_name, phone, address, br,bath,gr,sqf,est_p,type,landing, token,lat,lon,planing) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
           if (  $stmt = $mysqli->prepare($tracksql) ){
               $stmt->bind_param("sssssssssssssssssss",$sid,$ip_fw,$ip_ra, $cem,$email,$name,$phone,$g_addr,$g_beds,$g_baths,$g_garage,$g_sqft,$pred_avr,$g_property_type,$landing,$g_token,$lat,$lon,$g_planing);
               if ( ! $stmt->execute()) {
                   err_log("Error: ".$mysqli->error,__FILE__);
                   err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$email.":".$name.":".$phone.":".$g_addr.":".$g_beds.":".$g_baths.":".$g_garage.":".$g_sqft.":".$pred_avr.":".$message.":".$g_property_type.":".$landing.":".$g_token.":".$lat.":".$lon,__FILE__);
               }
          }else{
                   err_log("Error: ".$mysqli->error,__FILE__);
                   err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$email.":".$name.":".$phone.":".$g_addr.":".$g_beds.":".$g_baths.":".$g_garage.":".$g_sqft.":".$pred_avr.":".$message.":".$g_property_type.":".$landing.":".$g_token.":".$lat.":".$lon,__FILE__);
          }
 }
$formsticky='';
$navsticky='data-uk-sticky';
include 'nav-main.php';
?>
<!-- NAV --!>
            <!-- #START FORM GRID --!>
            <div class="uk-grid" >
                <div id="fc-form" class="uk-width-1-1">
                </div>
            </div>

            <div class="uk-grid">
                <div  class="uk-width-1-1">
        
<?php
  if ($_SESSION['what_it_worth'] == $g_token) 
  {
          $d = urlencode(base64_encode(serialize(array(
               'page_url'   => 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
               'tags' => $g_addr
           ))));
          echo '<img src="https://email.nucondo.ca/mtracking.gif?d=' . $d . '" style="display: none;" />';
  }else{
                   err_log("Error SESSION: ".$_SESSION['what_it_worth']."  GT:".$g_token,__FILE__);
                   err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$email.":".$name.":".$phone.":".$g_addr.":".$g_beds.":".$g_baths.":".$g_garage.":".$g_sqft.":".$pred_avr.":".$message.":".$g_property_type.":".$landing.":".$g_token.":".$lat.":".$lon,__FILE__);
             ?>
                <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/404' ?>'",10); </script>
             <?php
               die("");
   }

 
?>
          <script type="text/javascript"> setTimeout("window.location='<?php echo $base_url.'/thank-you' ?>'",1500); </script>

                    <div class="uk-container uk-container-center uk-text-center">
                                                   <i class="uk-icon-large uk-icon-spinner uk-icon-spin"></i>
                    </div>


                </div>
            </div>
