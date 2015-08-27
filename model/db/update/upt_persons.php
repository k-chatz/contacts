<?php

function updatePerson($personid,$name){
	if ($personid) {
		return Query("UPDATE `persons` SET `name`= '". $name ."' WHERE (`personid`= ". $personid .")", debug_backtrace());
	} else
		return NULL;
}

?>