<?php
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']) {

	update_field_from_table( "users" , "lastactive" , "'Logout'" , "userid" , $userid );

	$_SESSION['info']  = "<b>logout.php:</b><br />Now, you are disconnected from the system.";
	$_SESSION['isLoggedIn'] = 0;
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']); 
	unset($_SESSION['REMOTE_ADDR']);
	unset($_SESSION['HTTP_USER_AGENT']);
	
	$userid 	 = 0;
	$username	 = 0;
	$becomeLogin = 0;
	$isLoggedIn	 = 0;
} else
	$_SESSION['warning'] = "<b>logout.php:</b><br />Already offline!";
	
//session_destroy();
?>