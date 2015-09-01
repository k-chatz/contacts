<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/controllers/db.php');

function insert_country($country = "", $phonecode = "") {
	if ($country) {
		$country   = ($country);
		$phonecode = ($phonecode);
		
		if (NULL != ($countryid = exists_country($country))) {
			//if(!$Result[0]['phonecode'] || ($Result[0]['phonecode'] != $phonecode))
			//Query("UPDATE `countries` SET `phonecode`='".$phonecode."' WHERE (`countryid`='".$countryid."')");
		} else {
			$countryid = Query("INSERT INTO `countries` (`country`, `phonecode`) 
			VALUES ('" . $country . "','" . $phonecode . "')", debug_backtrace());
		}
		return $countryid;
	}
	return 0;
}

function insert_region($region = "") {
	if ($region) {
		$region = ($region);
		
		if (NULL == ($regionid = exists_region($region)))
			$regionid = Query("INSERT INTO `regions` (`region`) VALUES ('" . $region . "')", debug_backtrace());
		return $regionid;
	}
	return 0;
}

function insert_city($city = "") {
	if ($city) {
		
		$city = ($city);
		
		if (NULL == $cityid = exists_city($city))
			$cityid = Query("INSERT INTO `cities` (`city`) VALUES ('" . $city . "')", debug_backtrace());
		return $cityid;
	}
	return 0;
}

function insert_location($location = "") {
	if ($location) {
		
		$location = ($location);
		
		if (NULL == $locationid = exists_location($location))
			$locationid = Query("INSERT INTO `locations` (`location`) VALUES('" . $location . "')", debug_backtrace());
		return $locationid;
	}
	return 0;
}

function insert_street($street = "") {
	if ($street) {
		
		$street = ($street);
		
		if (NULL == $streetid = exists_street($street))
			$streetid = Query("INSERT INTO `streets` (`street`) VALUES ('" . $street . "')", debug_backtrace());
		return $streetid;
	}
	return 0;
}

function insert_streetnum($relationid, $streetnum) {
	$streetnum = ($streetnum);
	
	if (NULL == exists_streetnum($relationid, $streetnum)) {
		Query("INSERT INTO `streetsnum` (`relationid`, `streetnum`) 
		VALUES ('" . $relationid . "','" . $streetnum . "')", debug_backtrace());
		return 1;
	} else
		return 0;
}

function insert_address_for_user($country = 0, $region = 0, $city = 0, $location = 0, $comments = 0, $streets = 0, $numbers = 0, $userid = 0) {
	$comments = ($comments);
	
	if ($userid) 
	{
		$not_null = 0;
		
		$countryid = 0;
		if ($country) 
		{
			$not_null  = 1;
			$countryid = insert_country($country);
		}
		
		$regionid = 0;
		if ($region) 
		{
			$not_null = 1;
			$regionid = insert_region($region);
		}
		
		$cityid = 0;
		if ($city) 
		{
			$not_null = 1;
			$cityid   = insert_city($city);
		}
		
		$locationid = 0;
		if ($location) 
		{
			$not_null   = 1;
			$locationid = insert_location($location);
		}
		
		if ( NULL != $addressid = exists_address_for_user($countryid, $regionid, $cityid, $locationid, $comments, $streets, $numbers, $userid)) 
		{
			$nextaddressid = get_next_auto_increment_for_table( "contacts" , "addresses" );
			
			for ($col = 0; $col < count($streets); $col++) 
			{
				$streetid = 0;
				if ($streets[$col]) 
				{
					$not_null   = 1;
					$streetid   = insert_street($streets[$col]);
					$relationid = insert_relation("addresses", "streets", $nextaddressid, $streetid);
					if ($numbers[$col])
						insert_streetnum($relationid, $numbers[$col]);
				}
			}
			
			if ($not_null)
				return Query("INSERT INTO addresses (`countryid`,`regionid`,`cityid`,`locationid`,`comments`) VALUES ('" . $countryid . "','" . $regionid . "','" . $cityid . "','" . $locationid . "','" . $comments . "')", debug_backtrace());
			else
				return NULL;
		}
		return $addressid;
	}
	else
		return NULL;
}

?>