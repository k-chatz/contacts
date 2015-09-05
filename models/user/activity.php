<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/sel_user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/upt_user.php');

function logout(){

	$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;

	$ip = client_ip();

	update_user_status($_SESSION['userid'], 0, $ip , $_SERVER['HTTP_USER_AGENT'] );

	update_confid($userid , md5(mt_rand()));

	$dir = $_SERVER['DOCUMENT_ROOT'] . "/Contacts/views/user/temp/" . md5($userid);
	if (file_exists($dir)){
		removeDir($dir);
	}

	unset($_SESSION['userid']);
	unset($_SESSION['timeout']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']);
	unset($_SESSION['becomeLogin']);
}

$confid	= isset($_GET['cnf']) ? $_GET['cnf'] : 0;
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
$timeout = isset($_SESSION['timeout']) ? $_SESSION['timeout'] : 0;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 0;
$isLoggedIn	= isset($_SESSION['isLoggedIn']) ? $_SESSION['isLoggedIn'] : 0;
$becomeLogin = isset($_SESSION['becomeLogin']) ? $_SESSION['becomeLogin'] : 0;

$ip = client_ip();

if($becomeLogin){
	unset($_SESSION['becomeLogin']);
	$timeout = get_option( "timeout", $userid);
	$_SESSION['timeout'] = $timeout ? $timeout : 1;
	//dump($_SESSION,"SESSION");
}
else{
	if($isLoggedIn){
		if( NULL == $Records = user_is_online( $userid , $username , trim($confid) , $ip , $_SERVER['HTTP_USER_AGENT'] , $timeout )){
			/*Logout user*/
			logout();

			$isLoggedIn = 0;
			$userid		= 0;
			$username	= 0;
			$_SESSION['warning'] = "<b>activity.php:</b><br />The timeout of your connection has ended, you have disconnected automatically!";
		}
	}
}
?>
