<?php
function user_is_online($userid,$username,$confid,$REMOTE_ADDR,$HTTP_USER_AGENT,$minutes = 5) 
{
	if ($userid && $username) 
	{
		return Query("SELECT users.userid , users.username ,users.confid ,users.CURRENT_REMOTE_ADDR , users.CURRENT_HTTP_USER_AGENT
		FROM `users` WHERE lastactive + INTERVAL ".$minutes." MINUTE > NOW()
		AND users.userid = ".$userid." 
		AND users.username = '".$username."'
		AND users.confid = '".$confid."' 
		AND users.active = 'Activated' 
		AND users.CURRENT_REMOTE_ADDR = '".$REMOTE_ADDR."'
		AND users.CURRENT_HTTP_USER_AGENT = '".$HTTP_USER_AGENT."' ", debug_backtrace());
	} else
		return NULL;
} 

function exists_user($userid,$username) 
{
	if ($userid && $username) 
	{
		return Query("SELECT users.lastactive,users.active,users.got_person
		FROM users
		WHERE users.userid = ". $userid ." AND users.username = '". $username ."'", debug_backtrace());
	}
	else
	{
		return Query("SELECT users.userid,users.lastactive,users.active,users.got_person
		FROM users
		WHERE users.username = '". $username ."'", debug_backtrace());	
	}
	return NULL;
}

function exists_password_for_user($userid, $userpass) {
	if($userid && $userpass)
		return Query("SELECT userid FROM users
		WHERE userid = '".$userid."' AND userpass = '".$userpass."'", debug_backtrace());
	else
		return NULL;
}

function exists_activecode_for_user($username, $active) {
	if ($username) {
		return Query("SELECT userid FROM users 
		WHERE username = '".$username."' AND active = '".$active."'", debug_backtrace());
	} else
		return NULL;
}

function get_option( $var_name, $user_id = 0)
{
	if($user_id)
	{
		//Επιστροφή ρυθμίσεων που αφορούν έναν συγκεκριμένο χρήστη.
		$Result = Query("SELECT option_value 
					  FROM settings
					  WHERE
					  option_name = '$var_name' AND userid = '$user_id'", debug_backtrace());
		return $Result[0]['option_value'];
	}
	else
	{
		//Επιστροφή γενικών ρυθμίσεων που αφορούν όλους τους χρήστες..
	}
}

?>