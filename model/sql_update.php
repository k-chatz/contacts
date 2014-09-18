<?php
ini_set('display_errors', 1);
function update_field_from_table( $table , $field1 , $value1 , $field2 , $value2 ){
	if ($table && $field1 && $value1 && $field2 && $value2){
		return Query("UPDATE ". $table ." SET ". $field1 ." = ". $value1 ." WHERE ( ". $field2 ." = ". $value2 ." ) LIMIT 1", debug_backtrace());
	}
	else
		return NULL;
}

function activate_user($username, $activecode) {
	if ($username && $activecode) {
		return Query("UPDATE `users` SET `active` = 'Activated'
		WHERE (`username` = '" . $username . "' AND `active` = '" . $activecode . "')", debug_backtrace());
	} else
		return NULL;
}

function update_user_status($userid = 0, $loggedin, $REMOTE_ADDR ,$HTTP_USER_AGENT)
{ 
	if($userid)
	{
		//gia tin enimerosi tou xristi oti aposindethike tha xrisimopoiithei i update_field_from_table
		return Query("UPDATE users 
		SET lastactive = NOW() , CURRENT_REMOTE_ADDR = '".$REMOTE_ADDR."' , CURRENT_HTTP_USER_AGENT = '".$HTTP_USER_AGENT."'
		WHERE (userid = ".$userid.") LIMIT 1", debug_backtrace());
	}
} 
 



?>