<?php
ini_set('display_errors', 1);
function update_field_from_table( $table , $field1 , $value1 , $field2 , $value2 ){
	if ($table && $field1 && $value1 && $field2 && $value2){
		return Query("UPDATE ". $table ." SET ". $field1 ." = ". $value1 ." WHERE ( ". $field2 ." = ". $value2 ." ) LIMIT 1", debug_backtrace());
	}
	else
		return NULL;
}
?>