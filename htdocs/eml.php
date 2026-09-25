<?php
require_once '../config/config.php';
require_once '../config/legacy_helpers.php';
require_once 'signup/includes/main.php';


// Ensure required variables are defined
if (!isset($SEC_LEVEL2)) {
    $SEC_LEVEL2 = false;
}

if (!isset($fromEmail)) {
    $fromEmail = 'elzakrusteva@' . $_SERVER['SERVER_NAME'];
}

if (!isset($toEmail)) {
    $toEmail = 'angel.krustev@gmail.com;elzas2000@yahoo.com;angel@jobvolume.com';
}

// Check database connection early and provide better error messages
if (!isset($mysqli) || !$mysqli) {
    err_log('Database connection not available in eml.php - Connection object missing', __FILE__);
    die(json_encode(array(
        'error' => 1,
        'message' => 'System error. Please try again later.'
    )));
}

// Additional check to see if we can actually connect
try {
    // Try a simple query to verify connection works
    $test = $mysqli->query("SELECT 1");
    if ($test === false) {
        err_log('Database connection test failed in eml.php', __FILE__);
        die(json_encode(array(
            'error' => 1,
            'message' => 'System error. Please try again later.'
        )));
    }
} catch (Exception $e) {
    err_log('Database connection test exception in eml.php: ' . $e->getMessage(), __FILE__);
    die(json_encode(array(
        'error' => 1,
        'message' => 'System error. Please try again later.'
    )));
}

$msg = array();
#if($user->loggedIn()){
         
#}

/*--------------------------------------------------
	Handle submitting the login form via AJAX
---------------------------------------------------*/
try{
        err_log("DEBUG: eml.php script started, POST data size: " . count($_POST), __FILE__);
        
  // Check if this is a valid POST request (either AJAX or regular)
  if( !empty($_POST) ){
        err_log("DEBUG: Processing form submission", __FILE__);
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

                  err_log("CSRF validation check - SEC_LEVEL2: " . ($SEC_LEVEL2 ? 'true' : 'false') . ", frm value: " . $frm, __FILE__);
                  if ($SEC_LEVEL2 && !verifyFormToken($frm)) {
                       err_log("CSRF detected.",__FILE__);
                       die(json_encode(array(
                        'error' => 1,
                         'message' => 'Sorry. There was an error processing your request. Please try again later.'
                      )));
                  }


                if(!isset($tp) ){
                        err_log("Invalid request - tp not set", __FILE__);
                        throw new Exception('Invalid request.');
                }
                if(!isset($msg) || strlen($msg) < 6 ){
                        err_log("Please enter a message.", __FILE__);
                        throw new Exception('Please enter a message.');
                }
                if(!isset($fn) || strlen($fn) < 3 || strlen($fn) > 40  ){
                        err_log("Please enter your name.", __FILE__);
                        throw new Exception('Please enter your name.');
                }
                if(!isset($em) || !filter_var($em, FILTER_VALIDATE_EMAIL) || strlen($fn) > 30  ){
                        err_log("Please enter a valid email.", __FILE__);
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
                        $message .= "MLS: ".(isset($ml_num) ? $ml_num : "-")."\n";
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
       
       // Check if database connection exists before proceeding
       if (!isset($mysqli) || !$mysqli) {
           err_log("Database connection not available in eml.php - Connection object missing", __FILE__);
           throw new Exception('System error. Please try again later.');
       }
       
       // Additional safety check to ensure the connection is working properly
       if (method_exists($mysqli, 'prepare')) {
           err_log("Database connection verified - prepare method exists", __FILE__);
       } else {
           err_log("Database connection issue - prepare method missing", __FILE__);
           throw new Exception('System error. Please try again later.');
       }
       
       // Verify that we can prepare the statement (this is where "could not find driver" might come from)
       err_log("About to prepare tracker insert statement", __FILE__);
       $tracksql = "INSERT INTO tracker (session,ip_fw,ip_ra, cookie_email, email,full_name, phone, address, br,bath,gr,sqf,est_p,msg,type,landing) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
         $stmt = $mysqli->prepare($tracksql);
         err_log("Statement prepare result: " . ($stmt ? 'success' : 'failed'), __FILE__);
         if (!$stmt) {
             err_log("Database prepare error: " . $mysqli->error, __FILE__);
             // Don't throw exception here - just log and continue to send email
         } else {
             if (isset($stmt) && $stmt !== NULL){
                 $stmt->bind_param("ssssssssssssssss",$sid,$ip_fw,$ip_ra,$cem,$em,$fn,$cph,$addr_info,$bed,$bath,$max_gr,$sqf,$pred_avr,$message,$tp,$landing );
                 if ( ! $stmt->execute()) {
                     err_log("Error: ".$mysqli->error,__FILE__);
                     err_log("Error: ".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                 }
             }
         }


                       # $result = send_email($fromEmail, $toEmail, $subject, $message);

                        #if(!$result){
                         #      err_log("There was an error sending your email. Please try again.".":".$sid.":".$ip_fw.":".$ip_ra.":".$em.":".$fn.":".$cph.":".$addr_info.":".$bed.":".$bath.":".$max_gr.":".$sqf.":".$pred_avr.":".$message.":".$tp.":".$landing,__FILE__);
                         #      throw new Exception("There was an error sending your email. Please try again.");
                        # }        
                        $msg = array(
	 	           'error' => 0,
                           'message' => 'Your message has been sent. Thank You!'
                        );
                       die(json_encode($msg) );
     }

}
catch(Exception $e){          
        err_log("Missing POST or non AJAX request:". $e->getMessage().":".(isset($sid) ? $sid : '-').":".(isset($ip_fw) ? $ip_fw : '-').":".(isset($ip_ra) ? $ip_ra : '-').":".(isset($em) ? $em : '-').":".(isset($fn) ? $fn : '-').":".(isset($cph) ? $cph : '-').":".(isset($addr_info) ? $addr_info : '-').":".(isset($bed) ? $bed : '-').":".(isset($bath) ? $bath : '-').":".(isset($max_gr) ? $max_gr : '-').":".(isset($sqf) ? $sqf : '-').":".(isset($pred_avr) ? $pred_avr : '-').":".(isset($message) ? $message : '-').":".(isset($tp) ? $tp : '-').":".(isset($landing) ? $landing : '-'),__FILE__);
	die(json_encode(array(
		'error' => 1,
                'message' =>  'Sorry. There was an error processing your request. '

	)));
}

/*--------------------------------------------------
	Output the login form
---------------------------------------------------*/

?>
catch(Exception $e){          
        err_log("Missing POST or non AJAX request:". $e->getMessage().":".(isset($sid) ? $sid : '-').":".(isset($ip_fw) ? $ip_fw : '-').":".(isset($ip_ra) ? $ip_ra : '-').":".(isset($em) ? $em : '-').":".(isset($fn) ? $fn : '-').":".(isset($cph) ? $cph : '-').":".(isset($addr_info) ? $addr_info : '-').":".(isset($bed) ? $bed : '-').":".(isset($bath) ? $bath : '-').":".(isset($max_gr) ? $max_gr : '-').":".(isset($sqf) ? $sqf : '-').":".(isset($pred_avr) ? $pred_avr : '-').":".(isset($message) ? $message : '-').":".(isset($tp) ? $tp : '-').":".(isset($landing) ? $landing : '-'),__FILE__);
	die(json_encode(array(
		'error' => 1,
                'message' =>  'Sorry. There was an error processing your request. '

	)));
}

/*--------------------------------------------------
	Output the login form
---------------------------------------------------*/

?>
