<?php

function insert_relation($table1, $table2, $id1, $id2) {
	$relationid = 0;
	if (NULL == $relationid = exists_relation($table1, $table2, $id1, $id2))
		$relationid = Query("INSERT INTO `relations` (`table1`,`table2`,`id1`,`id2`) 
		VALUES('" . $table1 . "','" . $table2 . "','" . $id1 . "','" . $id2 . "')", debug_backtrace());
	return $relationid;
}

function insert_relation_reltype($relationid, $reltypeid) {
	if (NULL == exists_relation_reltype($relationid, $reltypeid)) {
		Query("INSERT INTO `relations_reltype` (`relationid`, `reltypeid`) VALUES('" . $relationid . "','" . $reltypeid . "')", debug_backtrace());
		return 1;
	} else
		return 0;
}

function insert_relationtype($reltype) 
{
	$reltypeid = 0;
	if (NULL == $reltypeid = exists_relationtype($reltype))
		$reltypeid = Query("INSERT INTO `reltypes` (`reltype`) VALUES ('" . $reltype . "')", debug_backtrace());
	return $reltypeid;
}

?>