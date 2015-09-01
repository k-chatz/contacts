<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/db.php');

function user_is_online($userid,$username,$confid,$REMOTE_ADDR,$HTTP_USER_AGENT,$minutes = 5) 
{
	$response = NULL;
	if ($userid && $username) 
	{
		$response = Query("SELECT users.userid , users.username ,users.confid ,users.CURRENT_REMOTE_ADDR , users.CURRENT_HTTP_USER_AGENT
		FROM `users` WHERE lastactive + INTERVAL ". $minutes ." MINUTE > NOW()
		AND users.userid = ". $userid ." 
		AND users.username = '". $username ."'
		AND users.confid = '". $confid ."' 
		AND users.active = 'Activated' 
		AND users.CURRENT_REMOTE_ADDR = '". $REMOTE_ADDR ."'
		AND users.CURRENT_HTTP_USER_AGENT = '". $HTTP_USER_AGENT ."' ", debug_backtrace());
	}
	return errorChecking($response);
}

function exists_user($userid,$username) 
{
	$username = addcslashes( $username ,"'");
	$response = NULL;
	if ($userid && $username) 
	{
		$response = Query("SELECT users.lastactive,users.active,users.got_person
		FROM users
		WHERE users.userid = ". $userid ." AND users.username = '". $username ."'", debug_backtrace());
	}
	else
	{
		$response = Query("SELECT users.userid,users.lastactive,users.active,users.got_person
		FROM users
		WHERE users.username = '". $username ."'", debug_backtrace());	
	}
	return errorChecking($response);
}

function exists_password($userid, $userpass) {
	$response = NULL;
	if($userid && $userpass){
		$response = Query("SELECT userid FROM users
		WHERE userid = '". $userid ."' AND userpass = '". $userpass ."'", debug_backtrace());
	}
	return errorChecking($response);
}

function exists_activecode($username, $active) {
	$response = NULL;
	if ($username) {
		$response = Query("SELECT userid FROM users 
		WHERE username = '". $username ."' AND active = '". $active ."'", debug_backtrace());
	} else
		return NULL;
	return errorChecking($response);
}

function get_option( $var_name, $user_id = 0){
	$response = NULL;
	if($user_id){
		//Επιστροφή ρυθμίσεων που αφορούν έναν συγκεκριμένο χρήστη.
		$response = Query("SELECT option_value 
		FROM settings
		WHERE option_name = '$var_name' AND userid = '$user_id'", debug_backtrace());
	}
	else
	{
		//Επιστροφή γενικών ρυθμίσεων που αφορούν όλους τους χρήστες..
	}
	if(errorChecking($response) != NULL){
		return $response[0]['option_value'];
	}
	else{
		return NULL;
	}
}
?>
