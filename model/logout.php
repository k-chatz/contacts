<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

	update_field_from_table( "users" , "lastactive" , "'Logout'" , "userid" , $userid );

	$_SESSION['message']  = "<b>logout.php:</b><br />Έγινε αποσύνδεση του χρήστη: " . $_SESSION['username'] . ".";
	$_SESSION['loggedin'] = 0;
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['loggedin']); 
	unset($_SESSION['REMOTE_ADDR']);
	unset($_SESSION['HTTP_USER_AGENT']);
	
	$userid 	= 0;
	$username	= 0;
	$login		= 0;
	$loggedin	= 0;
} else
	$_SESSION['warnings'] = "<b>logout.php:</b><br />Είσαι ήδη εκτός σύνδεσης!";
	
//session_destroy();
?>