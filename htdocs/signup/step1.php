<?php
require_once 'includes/main.php';

$user = new User();
$msg = array();
#if($user->loggedIn()){
         
#}


/*--------------------------------------------------
	Handle submitting the login form via AJAX
---------------------------------------------------*/
try{
	if(!empty($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        

                // Output a JSON header

                header('Content-type: application/json');

                // Is the email address valid?

                if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        throw new Exception('Please enter a valid email.');
                }

                // This will throw an exception if the person is above
                // the allowed login attempt limits (see functions.php for more):
                rate_limit($_SERVER['REMOTE_ADDR']);

                // Record this login attempt
                rate_limit_tick($_SERVER['REMOTE_ADDR'], $_POST['email']);

                    $cookie = base64_encode($_POST['email']);
                    if(!User::existsAndReg($_POST['email'])){
                      $msg = array(
		       'next' => 1,
		       'register' => 1,
                       'message' => '',
                       'cookie' => $cookie,
                       'email' => $_POST['email']
                      );
                     $user = User::loginOrRegister($_POST['email']);
                     $token = $user->generateToken();
                     }else{
                     $msg = array(
		       'next' => 0,
		       'register' => 0,
                       'message' => 'Welcome',
                       'cookie' => $cookie,
                       'email' => $_POST['email']
                      );
                     $user = User::loginOrRegister($_POST['email']);
                     $user->login();
                     }
            }
                    die(json_encode($msg) );

}
catch(Exception $e){
	die(json_encode(array(
		'error' => 1,
		'message' => $e->getMessage()
	)));
}

/*--------------------------------------------------
	Output the login form
---------------------------------------------------*/

?>
