<?php

include('../../model/content/relatives.php');

if( NULL != $records = get_person( $userid , $personid )){
	if($records[0]['birthday'] || $records[0]['photopath'])
		put_info_for_person($records[0]);

	if($records[0]['got_phone']){
		put_phones_for_person($records[0]['personid']);
	}

	if($records[0]['got_address']){
		put_addresses_for_person($records[0]['personid']);
	}

	if($records[0]['comments']){
		put_comments_for_person($records[0]['comments']);
	}

	//RELATIVES
    $array = array();
	$stack = array();
	front_flashback_relatives( $array, $records[0], 0, $stack );
	//dump( $stack, "stack" );
}
else
	$_SESSION['error'] = "<b>ajax.php:</b><br />This contact does not exists!";
?>