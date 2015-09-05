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

$ip = client_ip();

if($becomeLogin)
{
	unset($_SESSION['becomeLogin']);
	$_SESSION['timeout'] = get_option( "timeout", $userid);
	//dump($_SESSION,"SESSION");
}
else
{
	if($isLoggedIn)
	{
		if( NULL == $Records = user_is_online( $userid , $username , trim($confid) , $ip , $_SERVER['HTTP_USER_AGENT'] , $timeout ))
		{
			unset($_SESSION['userid']);
			unset($_SESSION['timeout']);
			unset($_SESSION['username']);
			unset($_SESSION['isLoggedIn']);
			unset($_SESSION['becomeLogin']);

			$isLoggedIn = 0;
			$userid		= 0;
			$username	= 0;
			$_SESSION['warning'] = "<b>activity.php:</b><br />The timeout of your connection has ended, you have disconnected automatically!";
		}
	}
}
?>