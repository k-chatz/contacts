<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/db.php');

function insert_user($username, $userpass, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $active) {
	$username = ($username);
	$userpass = ($userpass);
	 
	if (NULL == exists_user($username))
		return Query("INSERT INTO users(username,userpass,REGISTER_REMOTE_ADDR,REGISTER_REMOTE_PORT,REGISTER_HTTP_USER_AGENT,active) 
		Values ('" . $username . "','" . $userpass . "','" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "' ,'" . $active . "')");
	else
		return NULL;
}

function insertOption($userid, $optionName, $optionValue = NULL){
	if($userid && $optionName){
		$response = Query("INSERT INTO `contacts`.`settings` (`userid`, `option_name`, `option_value`) 
			VALUES (". $userid .", '". $optionName ."', '". $optionValue ."');", debug_backtrace());
		return errorChecking($response);
	}
	else
		return NULL;
}

function insert_log($userid = 0, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $REQUEST_URI) {
	if ($userid) {
		Query("INSERT INTO logs(userid,REMOTE_ADDR,REMOTE_PORT,HTTP_USER_AGENT,REQUEST_URI) VALUES(" . $userid . ",'" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "','" . $REQUEST_URI . "')", debug_backtrace());
		return 1;
	} else
		return NULL;
}
?>