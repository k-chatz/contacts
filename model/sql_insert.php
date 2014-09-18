<?php
ini_set('display_errors', 1);

function insert_user($username, $userpass, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $active) {
	$username = ($username);
	$userpass = ($userpass);
	 
	if (NULL == exists_user($username))
		return Query("INSERT INTO users(username,userpass,REGISTER_REMOTE_ADDR,REGISTER_REMOTE_PORT,REGISTER_HTTP_USER_AGENT,active) 
		Values ('" . $username . "','" . $userpass . "','" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "' ,'" . $active . "')");
	else
		return NULL;
}

function insert_log_for_user($userid = 0, $REMOTE_ADDR, $REMOTE_PORT, $HTTP_USER_AGENT, $REQUEST_URI) {
	if ($userid) {
		Query("INSERT INTO logs(userid,REMOTE_ADDR,REMOTE_PORT,HTTP_USER_AGENT,REQUEST_URI) VALUES(" . $userid . ",'" . $REMOTE_ADDR . "','" . $REMOTE_PORT . "','" . $HTTP_USER_AGENT . "','" . $REQUEST_URI . "')", debug_backtrace());
		return 1;
	} else
		return NULL;
}

function insert_relation($table1, $table2, $id1, $id2) {
	$relationid = 0;
	if (NULL == $relationid = exists_relation($table1, $table2, $id1, $id2))
		$relationid = Query("INSERT INTO `relations` (`table1`,`table2`,`id1`,`id2`) VALUES('" . $table1 . "','" . $table2 . "','" . $id1 . "','" . $id2 . "')", debug_backtrace());
	return $relationid;
}

function insert_relation_reltype($relationid, $reltypeid) {
	if (NULL == exists_relation_reltype($relationid, $reltypeid)) {
		Query("INSERT INTO `relations_reltype` (`relationid`, `reltypeid`) VALUES('" . $relationid . "','" . $reltypeid . "')", debug_backtrace());
		return 1;
	} else
		return 0;
}

function insert_person($name, $surname, $sex, $birthday, $acquaintance, $comments, $userid) {
	$name     = ($name);
	$surname  = ($surname);
	$comments = ($comments);
	
	$personid = 0; 
	if (NULL == $personid = exists_person_for_user($name, $surname, $sex, $birthday, $acquaintance, $userid))
		$personid = Query("INSERT INTO `persons` (`userid`,`name`,`surname`,`sex`,`birthday`,`acquaintance`,`comments`) VALUES ('". $userid ."','" . $name . "','" . $surname . "','" . $sex . "','" . $birthday . "','" . $acquaintance . "','" . $comments . "')", debug_backtrace());
	return $personid;
}

function insert_alias($alias) {
	$alias = ($alias);
	
	$aliasid = 0;
	if (NULL == $aliasid = exists_alias($alias))
		$aliasid = Query("INSERT INTO `aliases` (`alias`) VALUES ( '" . $alias . "' )", debug_backtrace());
	return $aliasid;
}

function insert_relationtype($reltype) {
	$reltypeid = 0;
	if (NULL == $reltypeid = exists_relationtype($reltype))
		$reltypeid = Query("INSERT INTO `reltypes` (`reltype`) VALUES ('" . $reltype . "')", debug_backtrace());
	return $reltypeid;
}

function insert_phone_for_user($countryid, $phone = "", $phonetype = "", $userid = 0) {
	if ($userid) {
		$phoneid = 0;
		if ($phone) {
			$phone     = ($phone);
			$phonetype = ($phonetype);
			
			if (NULL == $phoneid = exists_phone_for_user($phone, $userid))
				$phoneid = Query("INSERT INTO `phones` (`countryid`,`phone`,`phonetype`) VALUES ('" . $countryid . "','" . $phone . "','" . $phonetype . "')", debug_backtrace());
		}
		return $phoneid;
	} else
		return 0;
}

function insert_email($email = "", $emailtype = "") {
	$emailid = 0;
	if ($email) {
		$email     = ($email);
		$emailtype = ($emailtype);
		
		if (NULL == $emailid = exists_email($email))
			$emailid = Query("INSERT INTO `emails` (`email`, `emailtype`) VALUES ( '" . $email . "','" . $emailtype . "' )", debug_backtrace());
	}
	return $emailid;
}

function insert_website($website = "", $websitetype = "") {
	$websiteid = 0;
	if ($website) {
		$website     = ($website);
		$websitetype = ($websitetype);
		
		if (NULL == $websiteid = exists_website($website))
			$websiteid = Query("INSERT INTO `websites` (`website`, `websitetype`) VALUES ('" . $website . "','" . $websitetype . "')", debug_backtrace());
	}
	return $websiteid;
}

function insert_country($country = "", $phonecode = "") {
	if ($country) {
		$country   = ($country);
		$phonecode = ($phonecode);
		
		if (NULL != ($countryid = exists_country($country))) {
			//if(!$Result[0]['phonecode'] || ($Result[0]['phonecode'] != $phonecode))
			//Query("UPDATE `countries` SET `phonecode`='".$phonecode."' WHERE (`countryid`='".$countryid."')");
		} else {
			$countryid = Query("INSERT INTO `countries` (`country`, `phonecode`) VALUES ('" . $country . "','" . $phonecode . "')", debug_backtrace());
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
		Query("INSERT INTO `streetsnum` (`relationid`, `streetnum`) VALUES ('" . $relationid . "','" . $streetnum . "')", debug_backtrace());
		return 1;
	} else
		return 0;
}

function insert_address_for_user($country = 0, $region = 0, $city = 0, $location = 0, $comments = 0, $streets = 0, $numbers = 0, $userid = 0) {
	$comments = ($comments);
	
	if ($userid) {
		$not_null = 0;
		
		$countryid = 0;
		if ($country) {
			$not_null  = 1;
			//echo "<br />Υπάρχει η χώρα $country;";
			$countryid = insert_country($country);
			//echo "countryid: $countryid<br />";
		}
		
		$regionid = 0;
		if ($region) {
			$not_null = 1;
			//echo "<br />Υπάρχει ο νομός $region;";
			$regionid = insert_region($region);
			//echo "countryid: $countryid<br />";
		}
		
		$cityid = 0;
		if ($city) {
			$not_null = 1;
			//echo "<br />Υπάρχει η πόλη $city;";
			$cityid   = insert_city($city);
			//echo "cityid: $cityid<br />";
		}
		
		$locationid = 0;
		if ($location) {
			$not_null   = 1;
			//echo "<br />Υπάρχει η περιοχή $location;";
			$locationid = insert_location($location);
			//echo "locationid: $locationid<br />";
		}
		
		if (!$addressid = exists_address_for_user($countryid, $regionid, $cityid, $locationid, $comments, $streets, $numbers, $userid)) {
			$nextaddressid = get_next_auto_increment_for_table("kostis_mycnts", "addresses");
			
			for ($col = 0; $col < count($streets); $col++) {
				$streetid = 0;
				if ($streets[$col]) {
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
	} else
		return NULL;
}
?>