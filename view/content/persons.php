<?php
if( NULL != $records = get_persons( $userid, $items, $page )){
	for ( $row = 0; $row <= count( $records ); $row++ ) {
		if( $row != count( $records ) ) {
			put_person( $records[$row]['personid'] , $records[$row]['sex'] , $records[$row]['name'] , $records[$row]['surname'] );
		}
	}
}
else{
	$_SESSION['notice'] = "<b>persons.php:</b><br />No contacts found. To add new contacts press 'add contact'.";
}
?>