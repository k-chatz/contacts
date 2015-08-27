<?php
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']){

	update_user_status($_SESSION['userid'], 0, $_SESSION['REMOTE_ADDR'] , $_SERVER['HTTP_USER_AGENT'] );

	update_confid( $userid , md5(mt_rand()) );

	unset($_SESSION['userid']);
	unset($_SESSION['timeout']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']);
	unset($_SESSION['becomeLogin']);
	unset($_SESSION['REMOTE_ADDR']);
	unset($_SESSION['HTTP_USER_AGENT']);

	$_SESSION['success'] = "<b>logout.php:</b><br />Now, you are disconnected from the system.";
}else{
	$_SESSION['notice'] = "<b>logout.php:</b><br />Already offline!";
}
?>