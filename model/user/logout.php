<?php
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']){
	update_field_from_table( "users" , "lastactive" , "'Logout'" , "userid" , $userid );
	update_confid( $userid , md5(mt_rand()) );

	$_SESSION['success'] = "<b>logout.php:</b><br />Now, you are disconnected from the system.";
	unset($_SESSION['userid']);
	unset($_SESSION['timeout']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']);
	unset($_SESSION['becomeLogin']);
	unset($_SESSION['REMOTE_ADDR']);
	unset($_SESSION['HTTP_USER_AGENT']);
}else{
	$_SESSION['notice'] = "<b>logout.php:</b><br />Already offline!";
}
?>