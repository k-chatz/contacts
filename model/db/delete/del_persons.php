<?php
function deletePerson($personid) {
	$response = NULL;
	if ($personid) {
		$response = Query("DELETE FROM `persons` WHERE (`personid`= ". $personid .")", debug_backtrace());
	} else
		return NULL;
	return errorChecking($response);
}
?>