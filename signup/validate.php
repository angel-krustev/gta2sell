<?php

require_once '../../config/config.php';
require_once '../../config/func.php';
require_once 'includes/main.php';

/*--------------------------------------------------
	Handle visits with a login token. If it is
	valid, log the person in.
---------------------------------------------------*/

if(isset($_GET['tkn'])){
	// Is this a valid login token?
	$user = User::findByToken($_GET['tkn']);

	if($user){

		// Yes! Login the user and redirect to the protected page.

		$user->login();
	        redirect('/valid-thx');
	}

	// Invalid token. Redirect back to the login form.
	redirect('/notvalidtk');
}



/*--------------------------------------------------
	Handle logging out of the system. The logout
	link in protected.php leads here.
---------------------------------------------------*/


if(isset($_GET['logout'])){

	$user = new User();

	if($user->loggedIn()){
		$user->logout();
	}

	redirect('logout-thx.php');
}
