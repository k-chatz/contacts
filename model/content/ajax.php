<?php
$ms = microtime(true);

/*Force display errors/warnings*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include_once('../db/db.php');
include_once('../model.php');
include_once('../debug.php');
include_once('../../view/view.php');
include_once('../../view/alerts.php');

$ip = client_ip();

$userid 	= isset($_SESSION['userid'])	? $_SESSION['userid'] 		: 0;
$username 	= isset($_SESSION['username'])	? $_SESSION['username']		: 0;
$confid 	= isset($_POST['cnf'])			? trim($_POST['cnf'] )		: 0;
$timeout	= isset($_SESSION['timeout']) 	? $_SESSION['timeout']		: 0;
$isLoggedIn = isset($_SESSION['isLoggedIn'])? $_SESSION['isLoggedIn']	: 0;

//dump($_SESSION,"SESSION");
//dump($_POST,"POST");
//dump($userid,"userid");
//dump($username,"username");
//dump($confid,"confid");

if($isLoggedIn && $userid && $Records = user_is_online( $userid , $username , $confid , $ip , $_SERVER['HTTP_USER_AGENT'] , $timeout)){
	update_user_status($userid, $isLoggedIn, $ip , $_SERVER['HTTP_USER_AGENT'] );
	//dump($_SERVER,"SERVER");
	$action 	= isset($_POST['act'])	? $_POST['act'] : 0;
	$items 		= isset($_POST['itm'])	? $_POST['itm'] : 0;
	$page 		= isset($_POST['pg'])	? $_POST['pg']  : 0;
	$personid	= isset($_POST['pid'])	? $_POST['pid'] : 0;
	
	//dump($items,"items");
	
	switch( $action ){
		case 'get_persons':
			//insert_log_for_user($userid, $ip, $_SERVER['REMOTE_PORT'], $_SERVER['HTTP_USER_AGENT'], "Ajax.php: get_persons");
			include('../../view/content/persons.php');
			break;
		case 'get_person':
			//insert_log_for_user($userid, $ip , $_SERVER['REMOTE_PORT'], $_SERVER['HTTP_USER_AGENT'], "Ajax.php: get_person");
			include('../../view/content/person.php');
			break;
		default:
		    alert("<b>ajax.php:</b><br />Err::Ajax.php:No action here","warning");
	}
}
else
{
	//header("HTTP/1.0 400 Bad Request");
	alert("<b>ajax.php:</b><br />Session expired, <a href='index.php?p=login' title='System Login'>login</a> again!","warning");
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']);
}
	$ms = number_format( microtime(true) - $ms , 2);

	if($_SESSION['debug']){
		script_complete_time($ms);
	}

	unset($_SESSION['Queries']);
?>