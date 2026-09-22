<?php
#include '../config/config.php';
#include '../config/func.php';
#require_once 'signup/includes/main.php';

$msg = array();
#if($user->loggedIn()){
         
#}

/*--------------------------------------------------
	Handle submitting the login form via AJAX
---------------------------------------------------*/
try{

  #if( !empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) ){
  if( !empty($_POST)  ){
        $tp =  htmlspecialchars($_POST['tp'], ENT_QUOTES);
        $em = htmlspecialchars(isset($_POST['em'])?$_POST['em']:'-', ENT_QUOTES);
        $fn = htmlspecialchars(isset($_POST['fn'])?$_POST['fn']:'-', ENT_QUOTES);
        $cph = htmlspecialchars(isset($_POST['cph'])?$_POST['cph']:'-', ENT_QUOTES);
        $addr_info = htmlspecialchars(isset($_POST['addr'])?$_POST['addr']:'-', ENT_QUOTES);
        $bed = htmlspecialchars(isset($_POST['br'])?$_POST['br']:'-', ENT_QUOTES);
        $bath = htmlspecialchars(isset($_POST['bath'])?$_POST['bath']:'-', ENT_QUOTES);
        $max_gr = htmlspecialchars(isset($_POST['gr'])?$_POST['gr']:'-', ENT_QUOTES);
        $sqf = htmlspecialchars(isset($_POST['sqf'])?$_POST['sqf']:'-', ENT_QUOTES);
        $pred_avr = htmlspecialchars(isset($_POST['est_p'])?$_POST['est_p']:'-', ENT_QUOTES);
        $msg = htmlspecialchars(isset($_POST['msg'])?$_POST['msg']:'-', ENT_QUOTES);
        $type = htmlspecialchars(isset($_POST['type'])?$_POST['type']:'-', ENT_QUOTES);
        $landing = htmlspecialchars(isset($_POST['landing'])?url2mysql( base64_decode(($_POST['landing']) )):'-', ENT_QUOTES);
        $frm = htmlspecialchars($_POST['frm'], ENT_QUOTES);
               header('Content-type: application/json', ENT_QUOTES);
                # $req_dump = print_r($_POST, TRUE);
                # err_log($req_dump,__FILE__);

                  if ($SEC_LEVEL2 && !verifyFormToken($frm)) {
                       err_log("CSRF detected.",__FILE__);
                       die(json_encode(array(
                        'error' => 1,
                         'message' => 'Sorry. There was an error processing your request. Please try again later.'
                      )));
                  }


                if(!isset($tp) ){
                        err_log("Invalid request.");
                        throw new Exception('Invalid request.');
                }
                if(!isset($msg) || strlen($msg) < 6 ){
                        err_log("Please enter a message.");
                        throw new Exception('Please enter a message.');
                }
                if(!isset($fn) || strlen($fn) < 3 || strlen($fn) > 40  ){
                        err_log("Please enter your name.");
                        throw new Exception('Please enter your name.');
                }
                if(!isset($em) || !filter_var($em, FILTER_VALIDATE_EMAIL) || strlen($fn) > 30  ){
                        err_log("Please enter a valid email.");
                        throw new Exception('Please enter a valid email.');
                }
                // This will throw an exception if the person is above
                // the allowed login attempt limits (see functions.php for more):
                   rate_limit($_SERVER['REMOTE_ADDR']);
                // Record this login attempt
                   rate_limit_tick($_SERVER['REMOTE_ADDR'], $em);

                        $message = '';
                        $subject  = "Customer Request - ".$fn;
                        $message  = get_page_url()."\n";
                        $message .= "MLS: ".$ml_num."\n";
                        $message .= $em."\n\n";
                        $message .= $fn."\n";
                        $message .= $cph."\n";
                        $message .= $addr_info."\n";
                        $message .= $msg;
       $cem="-";

       if( isset($_COOKIE[$cookie_name]) ){
           $cem=base64_decode($_COOKIE[$cookie_name]);
       }

       $sid=$_SESSION['tr'];
       $ip_ra=$_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:'-';
       $ip_fw=$_SERVER['HTTP_X_FORWARDED_FOR']!=''?$_SERVER['HTTP_X_FORWARDED_FOR']:'-';
       $tracksql = "INSERT INTO TRACKER (session,ip_fw,ip_ra, cookie_email, email,full_name, phone, address, br,bath,gr,sqf,est_p,msg,type,landing) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
         $stmt = $mysqli->prepare($tracksql);
           if (isset($stmt) && $stmt !== NULL){
               $stmt->bind_param("ssssssssssssssss",$sid,$ip_fw,$ip_ra,$cem,$em,$fn,$cph,$addr_info,$bed,$bath,$max_gr,$sqf,$pred_avr,$message,$tp,$landing );
               if ( ! $stmt->execute()) {
                   err_log("Error: ".$mysqli->error,__FILE__);
                   err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
               }
          }else{
                   err_log("Error: ".$mysqli->error,__FILE__);
                   err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
          }


                        $result = send_email($fromEmail, $toEmail, $subject, $message);

                        if(!$result){
                               err_log("There was an error sending your email. Please try again.".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                               throw new Exception("There was an error sending your email. Please try again.");
                        }        
                        $msg = array(
	 	           'error' => 0,
                           'message' => 'Your message has been sent. Thank You!'
                        );
                       die(json_encode($msg) );
     }else{
                       err_log("There was an error sending your email. Please try again.".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                       throw new Exception('There was an error processing your request.');
     }

}
catch(Exception $e){          
        err_log("Missing POST or non AJAX request:". $e->getMessage().":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
	die(json_encode(array(
		'error' => 1,
                'message' =>  'Sorry. There was an error processing your request. '

	)));
}

/*--------------------------------------------------
	Output the login form
---------------------------------------------------*/

?>
