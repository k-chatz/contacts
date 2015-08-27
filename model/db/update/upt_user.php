<?php
function activate_user($username, $activecode) {
	if ($username && $activecode) {
		return Query("UPDATE `users` SET `active` = 'Activated'
		WHERE (`username` = '" . $username . "' AND `active` = '" . $activecode . "')", debug_backtrace());
	} else
		return NULL;
}

function update_confid($userid, $confid) {
	if ($userid && $confid) {
		return Query("UPDATE users
		SET confid = '". $confid ."'
		WHERE
		userid = ". $userid ."", debug_backtrace());
	} else
		return NULL;
}

function update_user_status($userid = 0, $isLoggedIn, $REMOTE_ADDR ,$HTTP_USER_AGENT)
{
	if($userid)
	{
		return Query("UPDATE users 
		SET lastactive = " . ($isLoggedIn ?  "NOW()" : "Logout") . ", CURRENT_REMOTE_ADDR = '".$REMOTE_ADDR."' , CURRENT_HTTP_USER_AGENT = '".$HTTP_USER_AGENT."'
		WHERE (userid = ".$userid.") LIMIT 1", debug_backtrace());
	}
}
?>