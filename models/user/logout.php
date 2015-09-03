<?php
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']){

	$ip = client_ip();

	update_user_status($_SESSION['userid'], 0, $ip , $_SERVER['HTTP_USER_AGENT'] );

	update_confid( $userid , md5(mt_rand()) );

	$dir = $_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid);
	if (file_exists($dir)){
		removeDir($dir);   
	}

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

redirect("", $debug);

die();

?>