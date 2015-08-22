<?php
if( NULL != $records = get_person_for_user( $userid , $personid )){
	if( $records[0]['birthday'] || $records[0]['photopath'] )
	put_info_for_person($records[0]);
	put_phones_for_person($records[0]['personid']);
	put_addresses_for_person($records[0]['personid']);
	put_comments_for_person( $records[0]['comments'] );

	//RELATIVES 
	//DO NOT DELETE THIS!!
	//********************
    $array = array();
	$stack = array();
	front_flashback_relatives( $array, $records[0], 0, $stack );
	//dump( $stack, "stack" );
}
else
	alert("Error: This contact does not exists!","warning");
?>