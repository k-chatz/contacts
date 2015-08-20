<?php
$msc = microtime(true);
include_once('model.php');

//Γενικές πληροφορίες***********************************************************************************************
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
if (isset($_POST['chk1']) && $userid) {
	
	$name         = isset($_POST['name']) ? $_POST['name'] : 0;
	$surname      = isset($_POST['surname']) ? $_POST['surname'] : 0;
	$aliases      = isset($_POST['aliases']) ? $_POST['aliases'] : 0;
	$sex          = isset($_POST['sex']) ? $_POST['sex'] : 0;
	$birthday     = isset($_POST['birthday']) ? $_POST['birthday'] : 0;
	$acquaintance = isset($_POST['acquaintance']) ? $_POST['acquaintance'] : 0;
	$comments     = isset($_POST['comments']) ? $_POST['comments'] : 0;

	if (NULL == $personid = exists_person_for_user($name, $surname, $sex, $birthday, $acquaintance, $userid))
		$personid = insert_person($name, $surname, $sex, $birthday, $acquaintance, $comments, $userid);
	
	// update_field_from_table( "persons" , "got_alias", 1 , "personid" , $personid );
	// update_field_from_table( "persons" , "got_phone", 1 , "personid" , $personid );
	// update_field_from_table( "persons" , "got_email", 1 , "personid" , $personid );
	// update_field_from_table( "persons" , "got_website", 1 , "personid" , $personid );	
	// update_field_from_table( "persons" , "got_address", 1 , "personid" , $personid );

	foreach ($aliases as $alias) {
		if ($alias && $personid)
			insert_relation("persons", "aliases", $personid, insert_alias($alias));
	}
	
	// $reltypes = isset($_POST['reltypes']) ? $_POST['reltypes'] : 0;
	// $persons  = isset($_POST['persons']) ? $_POST['persons'] : 0;
	
	// $row = 0;
	// foreach ($reltypes as $reltype) {
		// if ($reltype) {
			// $reltypeid = insert_relationtype($reltype);
			// foreach ($persons[$row] as $personid2) {
				// if (NULL != get_persons_for_user($personid2, $userid))
					// insert_relation_reltype(insert_relation("persons", "persons", $personid, $personid2), $reltypeid);
			// }
			// $row++;
		// }
	// }
	
	
	
	
	//Επικοινωνία*******************************************************************************************************
	
	if (isset($_POST['chk2'])) {
	
		$phonecountries = isset($_POST['phonecountries']) ? $_POST['phonecountries'] : 0;
		$code           = isset($_POST['codecountries']) ? $_POST['codecountries'] : 0;
		$phones         = isset($_POST['phones']) ? $_POST['phones'] : 0;
		$phonetypes     = isset($_POST['phonetypes']) ? $_POST['phonetypes'] : 0;
		$row            = 0;
		
		foreach ($phonecountries as $country) 
		{
			//$countryid = insert_country( $country , $code[$row] );
			$phoneid   = insert_phone_for_user( $phones[$row] , $phonetypes[$row] , $userid );
			if ( $phoneid )
				insert_relation( "persons" , "phones" , $personid, $phoneid );
			$row++;
		}

		$emails     = isset($_POST['emails']) ? $_POST['emails'] : 0;
		$emailtypes = isset($_POST['emailtypes']) ? $_POST['emailtypes'] : 0;
		$row        = 0;
		foreach ($emails as $email) {
			$emailid = insert_email($emails[$row], $emailtypes[$row]); //dimiourgia....
			if ($emailid)
				insert_relation("persons", "emails", $personid, $emailid);
			$row++;
		}

		$websites     = isset($_POST['websites']) ? $_POST['websites'] : 0;
		$websitetypes = isset($_POST['websitetypes']) ? $_POST['websitetypes'] : 0;
		$row          = 0;
		foreach ($websites as $website) {
			$websiteid = insert_website($websites[$row], $websitetypes[$row]);
			if ($websiteid)
				insert_relation("persons", "websites", $personid, $websiteid);
			$row++;
		}
	}
	
	//Διεύθυνση*********************************************************************************************************

	if (isset($_POST['chk3'])) {
		$address_num = isset($_POST['address_num']) ? $_POST['address_num'] : 0;
		
		$country  = isset($_POST['country']) ? $_POST['country'] : 0;
		$region   = isset($_POST['region']) ? $_POST['region'] : 0;
		$city     = isset($_POST['city']) ? $_POST['city'] : 0;
		$location = isset($_POST['location']) ? $_POST['location'] : 0;
		$comment  = isset($_POST['addresscomnt']) ? $_POST['addresscomnt'] : 0;
		$streets  = isset($_POST['streets']) ? $_POST['streets'] : 0;
		$numbers  = isset($_POST['numbers']) ? $_POST['numbers'] : 0;
		
		$exist_address = isset($_POST['existaddress']) ? $_POST['existaddress'] : 0;
		
		for ($row = 0; $row <= $address_num; $row++) {
			$addressid = insert_address_for_user($country[$row], $region[$row], $city[$row], $location[$row], $comment[$row], $streets[$row], $numbers[$row], $userid);
			if ($addressid)
				insert_relation("persons", "addresses", $personid, $addressid);
		}
	}
	
	//Απασχόληση********************************************************************************************************
	if (isset($_POST['chk4'])) {
		
		
	}
	//Σπουδές***********************************************************************************************************
	
	if (isset($_POST['chk5'])) {
		
		
	}

	$msc                 = microtime(true) - $msc;
	$msc                 = number_format($msc, 2);
	$_SESSION['message'] = "<b>insert.php:</b><br>Έγινε εισαγωγή της επαφής: " . $name . " " . $surname . ", αναγνωριστικό id: " . $personid . "<br />Χρόνος ολοκλήρωσης: $msc δευτερόλεπτα.";
} else
	$_SESSION['warnings'] = "<b>insert.php:</b><br>Δεν έγινε εισαγωγή επαφής!";


unset($_POST);
?>