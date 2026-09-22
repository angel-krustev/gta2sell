<?php
require_once '../config/config.php';
require_once 'includes/main.php';

$user = new User();
$msg = array();
#if($user->loggedIn()){
         
#}

/*--------------------------------------------------
	Handle submitting the login form via AJAX
---------------------------------------------------*/
try{








	#if( isset($_COOKIE[$cookie_name]) && !empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	if( isset($_POST['email']) && !empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){

                // Output a JSON header

                header('Content-type: application/json');

                // Is the email address valid?
                if(!isset($_POST['name']) || strlen($_POST['name']) < 3 ){
                        throw new Exception('Please enter a name with 3 or more letters.');
                }
                if(!isset($_POST['phone']) ){
                        throw new Exception('Please enter a valid phone.'.$_POST['phone']  );
                }
                // This will throw an exception if the person is above
                // the allowed login attempt limits (see functions.php for more):
                    rate_limit($_SERVER['REMOTE_ADDR']);

                // Record this login attempt
                    rate_limit_tick($_SERVER['REMOTE_ADDR'], $_POST['email']);
                    $cookie = base64_encode($_POST['email']);
                    if(User::exists($_POST['email'])){
                       $msg = array(
		        'error' => 0,
		        'next' => 1,
		        'registered' => 0,
                        'message' => '',
                        'cookie' => $cookie
                       );

                        $user = User::createFull($_POST['email'],$_POST['phone'],$_POST['name'],'C');
                        $token = $user->generateToken();

                // Send the message to the user

                        $message = '';
                        $email = $_POST['email'];
                        $subject = "Thank You For Registering!";
                        $message = "Thank you for registering at ".$this_site." !\n\n";

                        $message.= "You can validate your email from this URL:\n";
                        $message.= "http://".$_SERVER['HTTP_HOST']."/validate/".$token."\n\n";

                        $message.= "The link is going expire automatically after 24 hours.";

                        $result = send_email($fromEmail, $_POST['email'], $subject, $message);

                        if(!$result){
                               throw new Exception("There was an error sending your email. Please try again.");
                        }        

                     }else{
                       $msg = array(
		        'error' => 1,
		        'next' => 1,
		        'registered' => 1,
                        'message' => 'Error',
                        'cookie' => $cookie
                       );
                     }
            }
                    die(json_encode($msg) );

}
catch(Exception $e){
	die(json_encode(array(
		'error' => 1,
		'next' => 0,
		'register' => 0,
                'message' => $e->getMessage()
	)));
}

/*--------------------------------------------------
	Output the login form
---------------------------------------------------*/

?>
