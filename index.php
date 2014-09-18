<?php
//var_dump($_REQUEST);

ini_set('display_errors', 1);
session_start();
include_once('view/head.php');
$microsecond = microtime(true);

if( isset($_GET['debug'])) $_SESSION['debug'] = $_GET['debug']; //Show or hide Queries for debugging

include_once('view/view.php');
include_once('model/model.php');

$userid 			= isset($_SESSION['userid']) 			? $_SESSION['userid'] 			: 0;
$username			= isset($_SESSION['username']) 			? $_SESSION['username'] 		: 0;
$login				= isset($_SESSION['login']) 			? $_SESSION['login']			: 0;
$loggedin			= isset($_SESSION['loggedin'])			? $_SESSION['loggedin'] 		: 0;
$REMOTE_ADDR		= isset($_SESSION['REMOTE_ADDR']) 		? $_SESSION['REMOTE_ADDR']		: 0;
$HTTP_USER_AGENT	= isset($_SESSION['HTTP_USER_AGENT']) 	? $_SESSION['HTTP_USER_AGENT']	: 0;

if (isset($_GET['logout']))
    include_once('model/logout.php');

if($login)
{
	$_SESSION['login'] = 0;
}
else
{
	if($loggedin)
	{				   
		if( $Records = user_is_online( $userid , $username , client_ip() , $HTTP_USER_AGENT , $minutes = 5 ) )
		{
			$_SESSION['userid']   			= $Records[0]['userid'];
			$_SESSION['username'] 			= $Records[0]['username'];
			$_SESSION['loggedin']			= 1;
			$_SESSION['REMOTE_ADDR']		= $Records[0]['CURRENT_REMOTE_ADDR'];
			$_SESSION['HTTP_USER_AGENT']	= $Records[0]['CURRENT_HTTP_USER_AGENT'];
		}
		else
		{
			unset($_SESSION['userid']);
			unset($_SESSION['username']);
			unset($_SESSION['loggedin']);
			$userid		= 0;
			$username	= 0;
			$_SESSION['warnings'] = "<b>index.php:</b><br />Το χρονικό όριο της σύνδεσης έληξε, έγινε αποσύνδεση αυτόματα!";
		}
	}
} 

include_once('view/header.php');

// echo "<pre>";
// var_dump(  $_SESSION  );
// echo "</pre>"; 

echo "<div class='contentplace'>";
alert();

if (isset($_GET['register']))
    include_once('view/register.php');
else
{ 
	
    if(  (! $loggedin) || (! $username) || isset($_GET['login']))
    {
        include_once('view/login.php');
    } 
    else 
    {
		update_user_status($userid, $loggedin, client_ip() , $_SERVER['HTTP_USER_AGENT'] );
		insert_log_for_user($userid, client_ip() , $_SERVER['REMOTE_PORT'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['REQUEST_URI']);
		
		$_SESSION['REMOTE_ADDR']		= client_ip();
		$_SESSION['HTTP_USER_AGENT']	= $_SERVER['HTTP_USER_AGENT'];

		if (isset($_GET['submit']))
		{
			include_once('model/insert.php');
			
			include_once('view/searchform.php');
			alert();
			include_once('view/content.php');
		}
		else
		{
			include_once('view/searchform.php');
			include_once('view/content.php');
		}
    }
}
echo "</div>"; 

// echo "<pre>";
// var_dump(  $_SESSION  );
// echo "</pre>";

$microsecond = microtime(true) - $microsecond;
$microsecond = number_format($microsecond, 2);

include_once('view/footer.php'); 
//include_once('../cpu.php');

?>