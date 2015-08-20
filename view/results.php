<?php

if( NULL != $records = get_result_for_persons( $userid = 3, $items = 10, $page = 1 )){
 //include('new_person.php');
	for ( $row = 0; $row <= count( $records ); $row++ ) {
		if( $row != count( $records ) ) {
			put_person( $records[$row]['personid'] , $records[$row]['sex'] , $records[$row]['name'] , $records[$row]['surname'] );
		}
	}
}
?>