<?php
$userid 			= isset($_SESSION['userid']) 			? $_SESSION['userid'] 			: 0;
$username			= isset($_SESSION['username']) 			? $_SESSION['username'] 		: 0;
$confid				= isset($_GET['cnf']) 					? $_GET['cnf'] 		    		: 0;
$becomeLogin		= isset($_SESSION['becomeLogin']) 		? $_SESSION['becomeLogin']		: 0;
$isLoggedIn			= isset($_SESSION['isLoggedIn'])		? $_SESSION['isLoggedIn'] 		: 0;
$REMOTE_ADDR		= isset($_SESSION['REMOTE_ADDR']) 		? $_SESSION['REMOTE_ADDR']		: 0;
$HTTP_USER_AGENT	= isset($_SESSION['HTTP_USER_AGENT']) 	? $_SESSION['HTTP_USER_AGENT']	: 0;
$ip = client_ip();

if($becomeLogin)
{
	$_SESSION['becomeLogin'] = 0;
}
else
{
	if($isLoggedIn)
	{		   
		if( $Records = user_is_online( $userid , $username , trim($confid) , $ip , $HTTP_USER_AGENT , $minutes = 5 ) )
		{
			$_SESSION['userid']   			= $Records[0]['userid'];
			$_SESSION['username'] 			= $Records[0]['username'];
			$_SESSION['isLoggedIn']			= 1;
			$_SESSION['REMOTE_ADDR']		= $Records[0]['CURRENT_REMOTE_ADDR'];
			$_SESSION['HTTP_USER_AGENT']	= $Records[0]['CURRENT_HTTP_USER_AGENT'];
		}
		else
		{
			unset($_SESSION['userid']);
			unset($_SESSION['username']);
			unset($_SESSION['isLoggedIn']);
			$isLoggedIn = 0;
			$userid		= 0;
			$username	= 0;
			$_SESSION['warning'] = "<b>activity.php:</b><br />The timeout of your connection has ended, you have disconnected automatically!";
		}
	}
}
?>