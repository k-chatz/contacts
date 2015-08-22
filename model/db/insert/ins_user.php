<?php
function insert_user($username, $userpass, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $active) {
	$username = ($username);
	$userpass = ($userpass);
	 
	if (NULL == exists_user($username))
		return Query("INSERT INTO users(username,userpass,REGISTER_REMOTE_ADDR,REGISTER_REMOTE_PORT,REGISTER_HTTP_USER_AGENT,active) 
		Values ('" . $username . "','" . $userpass . "','" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "' ,'" . $active . "')");
	else
		return NULL;
}

function insert_log_for_user($userid = 0, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $REQUEST_URI) {
	if ($userid) {
		Query("INSERT INTO logs(userid,REMOTE_ADDR,REMOTE_PORT,HTTP_USER_AGENT,REQUEST_URI) VALUES(" . $userid . ",'" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "','" . $REQUEST_URI . "')", debug_backtrace());
		return 1;
	} else
		return NULL;
}
?>