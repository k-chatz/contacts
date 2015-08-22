<?php
function get_next_auto_increment_for_table($db_name, $TABLE_NAME = "") {
	if ($TABLE_NAME) {
		$Result = Query("SELECT `AUTO_INCREMENT` FROM `TABLES` WHERE TABLE_SCHEMA = '" . $db_name . "' AND TABLE_NAME = '" . $TABLE_NAME . "'", debug_backtrace(), "information_schema");
		return $Result[0]['AUTO_INCREMENT'];
	} else
		return NULL; 
}

function exists_relation($table1, $table2, $id1, $id2) {
	$Result = Query("SELECT `relationid` FROM `relations` WHERE ( `table1` = '" . $table1 . "' AND `table2` = '" . $table2 . "' AND `id1` = '" . $id1 . "' AND `id2` = '" . $id2 . "' ) OR ( `table1` = '" . $table2 . "' AND `table2` = '" . $table1 . "' AND `id1` = '" . $id2 . "' AND `id2` = '" . $id1 . "' )", debug_backtrace());
	return $Result[0]['relationid'];
}

function exists_relation_reltype($relationid, $reltypeid) {
	return Query("SELECT * FROM `relations_reltype` WHERE `relationid` = '" . $relationid . "' AND `reltypeid` = '" . $reltypeid . "'", debug_backtrace());
}

function get_relation_id2($id1, $table1, $table2) {
	return Query("SELECT `id2` FROM `relations` WHERE `table1` = '" . $table1 . "' AND `table2` = '" . $table2 . "' AND `id1` = '" . $id1 . "'", debug_backtrace());
}

function exists_relationtype($reltype) {
	$Result = Query("SELECT `reltypeid` FROM `reltypes` WHERE `reltype` = '" . $reltype . "'", debug_backtrace());
	return $Result[0]['reltypeid'];
}

function get_relationtypes_for_user($userid = 0) {
	if ($userid)
		return Query("SELECT DISTINCT reltypes.reltype
		FROM relations AS UsersToPersons,persons,relations AS PersonsToPersons,relations_reltype,reltypes
		WHERE
		UsersToPersons.table1 = 'users'
		AND UsersToPersons.table2 = 'persons'
		AND UsersToPersons.id1 = " . $userid . "
		AND UsersToPersons.id2 = persons.personid
		AND PersonsToPersons.table1 = 'persons'
		AND PersonsToPersons.table2 = 'persons'
		AND PersonsToPersons.id1 = persons.personid
		AND relations_reltype.relationid = PersonsToPersons.relationid
		AND reltypes.reltypeid = relations_reltype.reltypeid", debug_backtrace());
	else
		return 0;
}
?>