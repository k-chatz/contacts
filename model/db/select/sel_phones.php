<?php
function exists_phone_for_user($phone, $userid) {
	if ($userid) {
		$Result = Query("SELECT `phoneid` FROM `phones` WHERE `phone` = '" . $phone . "'", debug_backtrace());
		return $Result[0]['phoneid'];
	} else
		return 0;
}

function get_phones( $userid = 0 , $personid = 0) {
	if ($userid)
	{
		return Query("SELECT DISTINCT phones.phone
		FROM relations AS RELUSERS,phones,relations AS RELPHONES
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELPHONES.table2 = 'phones' AND
		phones.phoneid = RELPHONES.id2 AND
		RELPHONES.table1 = RELUSERS.table2 AND
		RELPHONES.id1 = RELUSERS.id2
		ORDER BY phones.phoneid DESC", debug_backtrace());
	}
	else if($personid)
	{
		return Query("SELECT phones.phone,phones.type
		FROM relations,phones
		WHERE relations.table1 = 'persons' AND relations.table2 = 'phones'
		AND relations.id1 = ". $personid ." AND relations.id2 = phones.phoneid", debug_backtrace());
	}
	else
		return 0;
}

function get_phonetypes_for_user($userid = 0) {
	if ($userid)
		return Query("SELECT DISTINCT phones.phonetype
		FROM relations AS RELUSERS,phones,relations AS RELPHONES
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELPHONES.table2 = 'phones' AND
		phones.phoneid = RELPHONES.id2 AND
		RELPHONES.table1 = RELUSERS.table2 AND
		RELPHONES.id1 = RELUSERS.id2
		ORDER BY phones.phoneid DESC", debug_backtrace());
	else
		return 0;
}


?>