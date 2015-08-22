<?php
function insert_phone($phone, $type = 0, $userid = 0) {
	if ($userid){
		if ($phone){
			if (NULL == $phoneid = exists_phone_for_user($phone, $userid))
				return Query("INSERT INTO `phones` (`phone`,`type`) 
				VALUES ('" . $phone . "','" . $type . "')", debug_backtrace());
		}
	} else
		return 0;
}
?>