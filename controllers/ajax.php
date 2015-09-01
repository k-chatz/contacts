<?php
$ms = microtime(true);

/*Force display errors/warnings*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/model.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/debug.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/views/alerts.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/sel_user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/upt_user.php');

$debug = (isset($_SESSION['debug']) && $_SESSION['debug'] == "on") ? 1 : 0;

if($debug){
	//dump($_SESSION,"SESSION");
	dump($_POST,"POST");
}

$ip = client_ip();

$userid 	= isset($_SESSION['userid'])	? $_SESSION['userid'] 		: 0;
$username 	= isset($_SESSION['username'])	? $_SESSION['username']		: 0;
$confid 	= isset($_POST['cnf'])			? trim($_POST['cnf'] )		: 0;
$timeout	= isset($_SESSION['timeout']) 	? $_SESSION['timeout']		: 0;
$isLoggedIn = isset($_SESSION['isLoggedIn'])? $_SESSION['isLoggedIn']	: 0;

if($isLoggedIn && $userid && $Records = user_is_online( $userid , $username , $confid , $ip , $_SERVER['HTTP_USER_AGENT'] , $timeout)){
	update_user_status($userid, $isLoggedIn, $ip , $_SERVER['HTTP_USER_AGENT'] );

	$action = isset($_POST['act'])	? $_POST['act'] : 0;

	switch($action){
		case 'get_persons':
			$items = isset($_POST['itm']) ? $_POST['itm'] : 0;
			$page  = isset($_POST['pg'])  ? $_POST['pg']  : 0;
			include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/views/content/persons.php');
			break;
		case 'get_person':
			$personid = isset($_POST['pid']) ? $_POST['pid'] : 0;
			include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/views/content/person.php');
			break;
		case 'add_person':
			echo "Add person code here!";
			include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/ins_person.php');
			put_person( 0 , "male", "Name", "Surname" );
			break;
		case 'upload_file':
			include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/upload.php');
			break;
		case 'download_file':
			$fileId  = isset($_POST['fid'])  ? $_POST['fid']  : 0;
			$fileName = isset($_POST['fn'])  ? $_POST['fn']  : "";
			include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/download.php');
			break;
		default:
			$_SESSION['error'] = "<b>ajax.php:</b><br />Err:: Not selected operation !";
	}
}
else
{
	//header("HTTP/1.0 400 Bad Request");
	$_SESSION['warning'] = "<b>ajax.php:</b><br />Session expired, <a href='index.php?p=login' title='System Login'>login</a> again!";
	unset($_SESSION['userid']);
	unset($_SESSION['username']);
	unset($_SESSION['isLoggedIn']);
}

/*To display alert messages (if these exists)*/
session_alert();

$ms = number_format( microtime(true) - $ms , 2);

if($debug){
	script_complete_time($ms);
}

unset($_SESSION['Queries']);

//header("HTTP/1.0 400 Bad Request");
?>