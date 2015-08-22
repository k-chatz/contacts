<?php

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

function exists_address_for_user($countryid, $regionid, $cityid, $locationid, $comments, $streets, $numbers, $userid) 
{
	$exists = 0;

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

		foreach ($Result as $address) {
			foreach ($streets as $street) {

				if ($relationid = exists_street_of_address($address['addressid'], $street))
					$exists = 1;
				else
					$exists = 0;
			}
			
			if ($exists) {
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