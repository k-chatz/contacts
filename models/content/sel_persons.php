<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/db.php');

function get_names($userid) {
	if ($userid)
		return Query("SELECT DISTINCT persons.`name`
		FROM persons
		WHERE 
		persons.userid = " . $userid . "", debug_backtrace());
	else
		return 0;
}

function get_surnames($userid) {
	if ($userid)
		return Query("SELECT DISTINCT persons.`surname`
		FROM persons
		WHERE 
		persons.userid = ". $userid ."", debug_backtrace());
	else
		return 0;
}

function get_aliases($userid = 0 , $personid = 0) 
{
	if($userid)
	{
		return Query("SELECT aliases.alias 
		FROM aliases,persons,relations AS relalias,relations AS reluser 
		WHERE relalias.table1 = 'persons' 
		AND relalias.table2 = 'aliases' 
		AND relalias.id1 = reluser.id2 
		AND relalias.id2 = aliases.aliasid 
		AND reluser.table1 = 'users' 
		AND reluser.table2 = 'persons' 
		AND reluser.id1 = " . $userid . "
		AND reluser.id2 = persons.personid", debug_backtrace());
	}
	else if($personid)
	{
		return Query("SELECT DISTINCT aliases.alias
		FROM aliases,relations
		WHERE relations.table1 = 'persons'
		AND relations.table2 = 'aliases'
		AND relations.id1 = ". $personid ."
		AND relations.id2 = aliases.aliasid", debug_backtrace());
	}
}

function get_persons( $userid = 0 , $items = 1 , $page = 1 ) {
	if ( $userid ) {
        return Query("SELECT persons.personid, (SELECT content FROM upload WHERE fileId = persons.imgFileId) AS imageBase64  ,persons.name, persons.surname, persons.sex 
					FROM persons
					WHERE persons.userid = ". $userid." 
					ORDER BY persons.personid DESC
					LIMIT " . ($page-1) * $items . ", " . $items ."" , debug_backtrace());
	} else {
		return NULL;
    }
}

function get_result_for_persons( $userid = 0 , $items = 1 , $page = 1 ) {
	if ( $userid ) {
        return Query("SELECT persons.personid, persons.name, persons.surname, persons.sex 
					FROM persons
					WHERE persons.userid = ". $userid." 
					ORDER BY persons.personid DESC
					LIMIT " . ($page-1) * $items . ", " . $items ."" , debug_backtrace());
	} else {
		return NULL;
    }
}

function get_person( $userid = 0 , $personid = 0 ) {
	if ($userid)
		return Query("SELECT personid, userid, name, surname, 
			(SELECT content FROM upload WHERE fileId = persons.imgFileId) AS imageBase64, 
			sex, birthday, comments, number_of_childs, motherid, fatherid, got_alias, 
			got_address, got_phone FROM persons 
			WHERE persons.userid = ". $userid ." AND persons.personid = ". $personid ." ", debug_backtrace());
	else
		return NULL;
}

function exists_person( $name, $surname, $sex, $birthday, $acquaintance, $userid = 0) {
	if ($userid) {
		$Result = Query("SELECT `personid` 
		FROM persons
		WHERE 
		persons.userid = " . $userid . "
		AND `name` = '" . $name . "'
		AND `surname` = '" . $surname . "'
		AND `sex` = '" . $sex . "'", debug_backtrace());
		return $Result[0]['personid'];
	} else
		return NULL;
}

function get_parrents( $motherid = 0 , $fatherid = 0)
{
	return Query("SELECT persons.personid, persons.`name`, persons.surname, persons.sex, persons.number_of_childs , persons.motherid,
	persons.fatherid FROM persons WHERE persons.personid = ". $motherid ." OR persons.personid = ". $fatherid ." 
	ORDER BY persons.sex ASC", debug_backtrace());
}

function get_childs_from_parrent( $parrentid , $parrent_gender , $stack )
{
	$parrent = ($parrent_gender == "male") ? "fatherid" : "motherid";
	return Query("SELECT persons.personid,persons.`name`,persons.surname,persons.sex,persons.number_of_childs,persons.motherid,persons.fatherid
	FROM persons
	WHERE persons.".$parrent." = ". $parrentid ." AND persons.personid NOT IN (". implode(',', $stack ). ")", debug_backtrace());
}

function exists_alias($alias) {
	$Result = Query("SELECT `aliasid` FROM `aliases` WHERE `alias` = '" . $alias . "'", debug_backtrace());
	return $aliasid = $Result[0]['aliasid'];
}

function get_person_count( $userid = 0 ){
	if ( $userid ){
		$Result = Query("SELECT COUNT(*) AS count
		FROM persons
		WHERE userid = ". $userid ."" , debug_backtrace());
		return (int)$Result[0]['count'];
	}
	else
		return NULL;
}

?>