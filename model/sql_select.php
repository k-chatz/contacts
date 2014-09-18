<?php
ini_set('display_errors', 1);
function get_next_auto_increment_for_table($db_name, $TABLE_NAME = "") {
	if ($TABLE_NAME) {
		$Result = Query("SELECT `AUTO_INCREMENT` FROM `TABLES` WHERE TABLE_SCHEMA = '" . $db_name . "' AND TABLE_NAME = '" . $TABLE_NAME . "'", debug_backtrace(), "information_schema");
		return $Result[0]['AUTO_INCREMENT'];
	} else
		return NULL; 
}

function user_is_online($userid,$username,$REMOTE_ADDR,$HTTP_USER_AGENT,$minutes = 5) 
{
	if ($userid && $username) 
	{
		return Query("SELECT users.userid , users.username , users.CURRENT_REMOTE_ADDR , users.CURRENT_HTTP_USER_AGENT
		FROM `users` WHERE lastactive + INTERVAL ".$minutes." MINUTE > NOW()
		AND users.userid = ".$userid." 
		AND users.username = '".$username."' 
		AND users.active = 'Activated' 
		AND users.CURRENT_REMOTE_ADDR = '".$REMOTE_ADDR."'
		AND users.CURRENT_HTTP_USER_AGENT = '".$HTTP_USER_AGENT."' ", debug_backtrace());
	} else
		return NULL;
} 

function exists_user($userid,$username) 
{
	if ($userid && $username) 
	{
		return Query("SELECT users.lastactive,users.active,users.got_person,
		users.got_company,users.got_school
		FROM users
		WHERE users.userid = ". $userid ." AND users.username = '". $username ."'", debug_backtrace());
	}
	else
	{
		return Query("SELECT users.userid,users.lastactive,users.active,users.got_person,
		users.got_company,users.got_school
		FROM users
		WHERE users.username = '". $username ."'", debug_backtrace());	
	}
	return NULL;
}

function exists_password_for_user($userid, $userpass) {
	if($userid && $userpass)
		return Query("SELECT userid FROM users
		WHERE userid = '".$userid."' AND userpass = '".$userpass."'", debug_backtrace());
	else
		return NULL;
}

function exists_activecode_for_user($username, $active) {
	if ($username) {
		return Query("SELECT userid FROM users 
		WHERE username = '".$username."' AND active = '".$active."'", debug_backtrace());
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

function get_names_for_user($userid) {
	if ($userid)
		return Query("SELECT DISTINCT persons.`name`
		FROM persons,relations
		WHERE relations.table1 = 'users' 
		AND relations.table2 = 'persons' 
		AND relations.id1 = " . $userid . " 
		AND relations.id2 = persons.personid", debug_backtrace());
	else
		return 0;
}

function get_surnames_for_user($userid) {
	if ($userid)
		return Query("SELECT DISTINCT persons.`surname`
		FROM persons,relations
		WHERE relations.table1 = 'users' 
		AND relations.table2 = 'persons' 
		AND relations.id1 = " . $userid . " 
		AND relations.id2 = persons.personid", debug_backtrace());
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

function exists_alias($alias) {
	$Result = Query("SELECT `aliasid` FROM `aliases` WHERE `alias` = '" . $alias . "'", debug_backtrace());
	return $aliasid = $Result[0]['aliasid'];
}

function get_persons_for_user($userid = 0) {
	if ($userid)
			return Query("SELECT * FROM persons WHERE persons.userid = ". $userid ."", debug_backtrace());
	else
		return NULL;
}

function exists_person_for_user($name, $surname, $sex, $birthday, $acquaintance, $userid = 0) {
	if ($userid) {
		$Result = Query("SELECT `personid` 
		FROM persons,relations
		WHERE `name` = '" . $name . "'
		AND `surname` = '" . $surname . "'
		AND `sex` = '" . $sex . "'
		AND `birthday` = " . ($birthday ? " '$birthday' " : 0) . "
		AND `acquaintance` = " . ($acquaintance ? " '$acquaintance' " : 0) . "
		AND relations.table1 = 'users'
		AND relations.table2 = 'persons' /*Userid*/
		AND relations.id1 = " . $userid . " 
		AND relations.id2 = persons.personid", debug_backtrace());
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

function get_childs_from_parrent( $parrentid , $parrent_gender , $personid , $stack )
{
	$parrent = ($parrent_gender == "male") ? "fatherid" : "motherid";
	return Query("SELECT persons.personid,persons.`name`,persons.surname,persons.sex,persons.number_of_childs,persons.motherid,persons.fatherid
	FROM persons
	WHERE persons.".$parrent." = ". $parrentid ." AND persons.personid NOT IN (". implode(',', $stack ). ")", debug_backtrace());
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

function exists_phone_for_user($phone, $userid) {
	if ($userid) {
		$Result = Query("SELECT `phoneid` FROM `phones` WHERE `phone` = '" . $phone . "'", debug_backtrace());
		return $Result[0]['phoneid'];
	} else
		return 0;
}

function exists_email($email) {
	$Result = Query("SELECT `emailid` FROM `emails` WHERE `email` = '" . $email . "'", debug_backtrace());
	return $Result[0]['emailid'];
}

function exists_website($website) {
	$Result = Query("SELECT `websiteid` FROM `websites` WHERE `website` = '" . $website . "'", debug_backtrace());
	return $Result[0]['websiteid'];
}

function get_phones( $userid = 0 , $personid = 0) {
	if ($userid)
	{
		return Query("SELECT DISTINCT phones.phone
		FROM relations AS RELUSERS,phones,relations AS RELPHONES
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELPHONES.table2 = 'phones' AND
		phones.phoneid = RELPHONES.id2 AND
		RELPHONES.table1 = RELUSERS.table2 AND
		RELPHONES.id1 = RELUSERS.id2
		ORDER BY phones.phoneid DESC", debug_backtrace());
	}
	else if($personid)
	{
		return Query("SELECT phones.phone,phones.phonetype,phones.operator,phones.packet
		FROM relations,phones
		WHERE relations.table1 = 'persons' AND relations.table2 = 'phones'
		AND relations.id1 = ". $personid ." AND relations.id2 = phones.phoneid", debug_backtrace());
	}
	else
		return 0;
}

function get_phonetypes_for_user($userid = 0) {
	if ($userid)
		return Query("SELECT DISTINCT phones.phonetype
		FROM relations AS RELUSERS,phones,relations AS RELPHONES
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELPHONES.table2 = 'phones' AND
		phones.phoneid = RELPHONES.id2 AND
		RELPHONES.table1 = RELUSERS.table2 AND
		RELPHONES.id1 = RELUSERS.id2
		ORDER BY phones.phoneid DESC", debug_backtrace());
	else
		return 0;
}

function get_emails_for_user($userid = 0) {
	if ($userid) {
		return Query("SELECT DISTINCT emails.email
		FROM relations AS RELUSERS,relations AS RELEMAILS,emails
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		emails.emailid = RELEMAILS.id2 AND
		RELEMAILS.table2 = 'emails' AND
		RELEMAILS.table1 = RELUSERS.table2 AND
		RELEMAILS.id1 = RELUSERS.id2
		ORDER BY emails.emailid DESC", debug_backtrace());
	} else
		return 0;
}

function get_emailtypes_for_user($userid = 0) {
	if ($userid) {
		return Query("SELECT DISTINCT emails.emailtype
		FROM relations AS RELUSERS,relations AS RELEMAILS,emails
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		emails.emailid = RELEMAILS.id2 AND
		RELEMAILS.table2 = 'emails' AND
		RELEMAILS.table1 = RELUSERS.table2 AND
		RELEMAILS.id1 = RELUSERS.id2
		ORDER BY emails.emailid DESC", debug_backtrace());
	} else
		return 0;
}

function get_websites_for_user($userid) {
	if ($userid)
		return Query("SELECT DISTINCT websites.website
		FROM relations AS RELUSERS,relations AS RELWEBSITES,websites
		WHERE RELUSERS.id1 = " . $userid . "
		AND (RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%persons%'
		OR RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%companies%'
		OR RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%schools%'
		)AND websites.websiteid = RELWEBSITES.id2
		AND RELWEBSITES.table2 = 'websites'
		AND RELWEBSITES.table1 = RELUSERS.table2
		AND RELWEBSITES.id1 = RELUSERS.id2
		ORDER BY websites.websiteid DESC", debug_backtrace());
	else
		return 0;
}

function get_websitetypes_for_user($userid) {
	if ($userid)
		return Query("SELECT DISTINCT websites.websitetype
		FROM relations AS RELUSERS,relations AS RELWEBSITES,websites
		WHERE RELUSERS.id1 = " . $userid . "
		AND (RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%persons%'
		OR RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%companies%'
		OR RELUSERS.table1 LIKE '%users%'
		AND RELUSERS.table2 LIKE '%schools%'
		)AND websites.websiteid = RELWEBSITES.id2
		AND RELWEBSITES.table2 = 'websites'
		AND RELWEBSITES.table1 = RELUSERS.table2
		AND RELWEBSITES.id1 = RELUSERS.id2
		ORDER BY websites.websiteid DESC", debug_backtrace());
	else
		return 0;
}

function exists_country($country = "") {
	$Result = Query("SELECT `countryid` FROM `countries` WHERE `country` = '" . $country . "'", debug_backtrace());
	return $Result[0]['countryid'];
}


function exists_region($region = "") {
	$Result = Query("SELECT `regionid` FROM `regions` WHERE `region` = '" . $region . "'", debug_backtrace());
	return $Result[0]['regionid'];
}

function exists_city($city = "") {
	$Result = Query("SELECT `cityid` FROM `cities` WHERE `city` = '" . $city . "'", debug_backtrace());
	return $Result[0]['cityid'];
}

function exists_location($location = "") {
	$Result = Query("SELECT `locationid` FROM `locations` WHERE `location` = '" . $location . "'", debug_backtrace());
	return $Result[0]['locationid'];
}

function exists_street($street = "") {
	$Result = Query("SELECT `streetid` FROM `streets` WHERE `street` = '" . $street . "'", debug_backtrace());
	return $Result[0]['streetid'];
}

function exists_streetnum($relationid, $streetnum) {
	return Query("SELECT * FROM `streetsnum` WHERE `relationid` = '" . $relationid . "' AND `streetnum` = '" . $streetnum . "'", debug_backtrace());
}


/*Διεύθυνση*********************************************************************************************************/

function exists_address_for_user($countryid, $regionid, $cityid, $locationid, $comments, $streets, $numbers, $userid) {
	$exists = 0;
	//echo "<br />Υπάρχει η διεύθυνση με τα παραπάνω στοιχεία για το χρήστη: $userid ;";
	if ($userid && (NULL != $Result = Query("SELECT DISTINCT addresses.addressid
	FROM relations AS RELUSERS,relations AS RELADDRESSES,addresses
	WHERE RELUSERS.id1 = " . $userid . " AND (
	RELUSERS.table1 LIKE '%users%'
	AND RELUSERS.table2 LIKE '%persons%'
	OR RELUSERS.table1 LIKE '%users%'
	AND RELUSERS.table2 LIKE '%companies%'
	OR RELUSERS.table1 LIKE '%users%'
	AND RELUSERS.table2 LIKE '%schools%' )
	AND addresses.addressid = RELADDRESSES.id2
	AND RELADDRESSES.table2 = 'addresses'
	AND RELADDRESSES.table1 = RELUSERS.table2
	AND RELADDRESSES.id1 = RELUSERS.id2
	AND ( addresses.countryid = '" . $countryid . "'
	AND addresses.regionid = '" . $regionid . "'
	AND addresses.cityid = '" . $cityid . "'
	AND addresses.locationid = '" . $locationid . "'
	AND addresses.comments = '" . $comments . "')
	ORDER BY addresses.addressid ASC", debug_backtrace()))) {
		//echo "Υπάρχει<br />";
		foreach ($Result as $address) {
			foreach ($streets as $street) {
				//echo "<br />Υπάρχει ο δρόμος $street στην διεύθυνση ".$address['addressid']."";
				if ($relationid = exists_street_of_address($address['addressid'], $street))
					$exists = 1;
				else
					$exists = 0;
				//if($exists) echo "Υπάρχει<br />"; else echo "Δεν υπάρχει!<br />"; 
			}
			
			if ($exists) {
				//echo "<br/>line:473: return ". $address['addressid'].";<br/>";
				return $address['addressid'];
			}
		}
	} else
		return NULL;
}

function exists_street_of_address($addressid, $street) {
	$Result = Query("SELECT `relationid`
	FROM relations,streets
	WHERE table1 = 'addresses'
	AND table2 = 'streets'
	AND id1 = '" . $addressid . "'
	AND id2 = streetid
	AND street = '" . $street . "'", debug_backtrace());
	return $Result[0]['relationid'];
}

function get_countries_for_user($countryid = "", $userid = 0) {
	if ($countryid)
		return Query("SELECT `country` FROM `countries` WHERE `countryid` = " . $countryid . "", debug_backtrace());
	else if ($userid)
		return Query("SELECT DISTINCT countries.countryid,countries.country,countries.phonecode
		FROM relations AS RELUSERS,relations AS RELADDRESSES,addresses,countries
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELADDRESSES.table1 = RELUSERS.table2 AND
		RELADDRESSES.id1 = RELUSERS.id2 AND
		addresses.addressid = RELADDRESSES.id2 AND
		countries.countryid = addresses.countryid
		ORDER BY addresses.locationid DESC", debug_backtrace());
	else
		return NULL;
}

function get_cities_for_user($cityid = "", $userid = 0) {
	if ($cityid)
		return Query("SELECT `city` FROM `cities` WHERE `cityid` = " . $cityid . "", debug_backtrace());
	else if ($userid)
		return Query("SELECT DISTINCT cities.cityid,cities.city
		FROM relations AS RELUSERS,relations AS RELADDRESSES ,addresses ,cities
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELADDRESSES.table1 = RELUSERS.table2 AND
		RELADDRESSES.id1 = RELUSERS.id2 AND
		addresses.addressid = RELADDRESSES.id2 AND
		cities.cityid = addresses.cityid
		ORDER BY cities.cityid DESC", debug_backtrace());
	else
		return NULL;
}

function get_regions_for_user($regionid = "", $userid = 0) {
	if ($regionid)
		return Query("SELECT `region` FROM `regions` WHERE `regionid` = " . $regionid . "", debug_backtrace());
	else if ($userid)
		return Query("SELECT DISTINCT regions.regionid,regions.region
		FROM relations AS RELUSERS,relations AS RELADDRESSES,addresses,regions
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELADDRESSES.table1 = RELUSERS.table2 AND
		RELADDRESSES.id1 = RELUSERS.id2 AND
		addresses.addressid = RELADDRESSES.id2 AND
		regions.regionid = addresses.regionid
		ORDER BY regions.regionid DESC", debug_backtrace());
	else
		return NULL;
}

function get_locations_for_user($locationid = 0, $userid = 0) {
	if ($locationid)
		return Query("SELECT `location` FROM `locations` WHERE `locationid` = " . $locationid . "", debug_backtrace());
	else if ($userid)
		return Query("SELECT DISTINCT
		addresses.locationid,locations.location
		FROM relations AS RELUSERS,relations AS RELADDRESSES,addresses,locations
		WHERE RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELADDRESSES.table1 = RELUSERS.table2 AND
		RELADDRESSES.id1 = RELUSERS.id2 AND
		addresses.addressid = RELADDRESSES.id2 AND
		locations.locationid = locations.locationid AND
		locations.locationid = addresses.locationid
		ORDER BY addresses.locationid DESC", debug_backtrace());
	else
		return NULL;
}

function get_streets_for_user($userid) {
	if ($userid)
		return Query("SELECT DISTINCT streets.streetid,streets.street
		FROM relations AS RELUSERS,relations AS RELADDRESSES,relations,streets
		WHERE
		RELUSERS.id1 = " . $userid . " AND
		(RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%persons%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%companies%' OR
		RELUSERS.table1 LIKE '%users%' AND
		RELUSERS.table2 LIKE '%schools%') AND
		RELADDRESSES.table2 = 'addresses' AND
		RELADDRESSES.table1 = RELUSERS.table2 AND
		RELADDRESSES.id1 = RELUSERS.id2 AND
		relations.table1 = 'addresses' AND
		relations.table2 = 'streets' AND
		relations.id1 = RELADDRESSES.id2 AND
		streets.streetid = relations.id2
		ORDER BY
		relations.id2 DESC", debug_backtrace());
	else
		return NULL;
}

function get_streets_numbers_of_address($addressid) {
	if ($addressid)
		return $streets = Query("SELECT streets.street,streetsnum.streetnum AS number
		FROM streets,relations
		LEFT JOIN streetsnum ON relations.relationid = streetsnum.relationid
		WHERE relations.table1 = 'addresses'
		AND relations.table2 = 'streets'
		AND relations.id1 = " . $addressid . "
		AND relations.id2 = streets.streetid
		ORDER BY streets.street ASC", debug_backtrace());
	else
		return NULL;
}

function get_addresses( $userid = 0 , $personid = 0 ) 
{
	/*Επιστρέφει διευθύνσεις που ανήκουν σε εναν χρήστη ή διευθύνσεις που ανήκουν σε μια επαφή..*/
	if( $userid )
	{
		$address = Query("SELECT DISTINCT addresses.addressid,countries.country,cities.city,
		regions.region,locations.location,addresses.comments,addresses.added
		FROM relations AS RELUSERS,relations AS RELADDRESSES,addresses
		INNER JOIN countries ON countries.countryid = addresses.countryid
		INNER JOIN cities ON cities.cityid = addresses.cityid
		INNER JOIN regions ON regions.regionid = addresses.regionid
		INNER JOIN locations ON locations.locationid = addresses.locationid
		WHERE RELUSERS.id1 = ". $userid ." AND ( RELUSERS.table1 = 'users' AND RELUSERS.table2 = 'persons'
		OR RELUSERS.table1 = 'users' AND RELUSERS.table2 = 'companies' OR RELUSERS.table1 = 'users'
		AND RELUSERS.table2 = 'schools' ) AND addresses.addressid = RELADDRESSES.id2 
		AND RELADDRESSES.table2 = 'addresses' AND RELADDRESSES.table1 = RELUSERS.table2
		AND RELADDRESSES.id1 = RELUSERS.id2 ORDER BY addresses.addressid DESC", debug_backtrace()); 
	}
	else if( $personid )
	{
		$address = Query("SELECT DISTINCT addresses.addressid,countries.country,cities.city,
		regions.region,locations.location,addresses.comments,addresses.added
		FROM relations,addresses
		INNER JOIN countries ON countries.countryid = addresses.countryid
		INNER JOIN cities ON cities.cityid = addresses.cityid
		INNER JOIN regions ON regions.regionid = addresses.regionid
		INNER JOIN locations ON locations.locationid = addresses.locationid
		WHERE relations.table1 = 'persons' AND relations.table2 = 'addresses' 
		AND relations.id1 = ". $personid ." AND relations.id2 = addresses.addressid", debug_backtrace());	
	}
	
	if( NULL != $address )
	{
		for ($row = 0; $row < count($address); $row++) 
			$address[$row]['streets'] = get_streets_numbers_of_address($address[$row]['addressid']);
		return $address;
	}
	else
		return NULL;
}
?>