<?php
$userid 			= isset($_SESSION['userid']) 			? $_SESSION['userid'] 			: 0;
$username			= isset($_SESSION['username']) 			? $_SESSION['username'] 		: 0;
$confid				= isset($_GET['cnf']) 					? $_GET['cnf'] 		    		: 0;
$becomeLogin		= isset($_SESSION['becomeLogin']) 		? $_SESSION['becomeLogin']		: 0;
$timeout			= isset($_SESSION['timeout']) 			? $_SESSION['timeout']			: 0;
$isLoggedIn			= isset($_SESSION['isLoggedIn'])		? $_SESSION['isLoggedIn'] 		: 0;

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