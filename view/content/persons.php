<?php
if( NULL != $records = get_persons( $userid, $items, $page )){
 //include('new_person.php');
	for ( $row = 0; $row <= count( $records ); $row++ ) {
		if( $row != count( $records ) ) {
			put_person( $records[$row]['personid'] , $records[$row]['sex'] , $records[$row]['name'] , $records[$row]['surname'] );
		}
	}
}
?>