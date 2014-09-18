<!--
<head>
<style>
.varbox{
background-color: rgba(0, 0, 0, 0.05);
padding: 5px;
border-style: solid;
border-width: 1px;
border-color: rgba(0, 0, 0, 0.05);
border-radius: 0.2em;
/* margin: 20px 0px 20px 0px; */
/* width: 30%; */
/* float: left; */
}	

.box{
background-color: rgba(0, 0, 0, 0.05);
padding: 5px;
border-style: solid;
border-width: 1px;
border-color: rgba(0, 0, 0, 0.05);
border-radius: 0.2em;
margin: 0px 0px 0px 0px;
}

h4{
font-size:90%;
font-family:Arial Black;
margin: 0px;
color:black;
}
</style>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
</head>
-->
<?php

$msc = microtime(true);
include_once('model.php');

/*Γενικές πληροφορίες***********************************************************************************************/
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
if (isset($_POST['chk1']) && $userid) {
	
	//echo "<div class='varbox'>";
	//echo "<b>POST:</b><br><pre>";
	//var_dump($_POST);
	//echo "</pre></div>";
	
	
	//echo "<div class='box'>";
	//echo "<b>PERSON:</b>";
	$name         = isset($_POST['name']) ? $_POST['name'] : 0;
	$surname      = isset($_POST['surname']) ? $_POST['surname'] : 0;
	
	
	
	$aliases      = isset($_POST['aliases']) ? $_POST['aliases'] : 0;
	
	
	
	$sex          = isset($_POST['sex']) ? $_POST['sex'] : 0;
	$birthday     = isset($_POST['birthday']) ? $_POST['birthday'] : 0;
	$acquaintance = isset($_POST['acquaintance']) ? $_POST['acquaintance'] : 0;
	$comments     = isset($_POST['comments']) ? $_POST['comments'] : 0;
	
	$personid = insert_person($name, $surname, $sex, $birthday, $acquaintance, $comments, $userid);
	insert_relation("users", "persons", $userid, $personid);
	//echo "</div>"; 
	
	//echo "<div class='box'>";
	//echo "<b>ALIASES:</b>";
	
	
	update_field_from_table( "persons" , "got_alias", 1 , "personid" , $personid );
	
	update_field_from_table( "persons" , "got_phone", 1 , "personid" , $personid );
	
	update_field_from_table( "persons" , "got_email", 1 , "personid" , $personid );
	
	update_field_from_table( "persons" , "got_website", 1 , "personid" , $personid );	
	
	update_field_from_table( "persons" , "got_address", 1 , "personid" , $personid );



	
	
	foreach ($aliases as $alias) {
		if ($alias)
			insert_relation("persons", "aliases", $personid, insert_alias($alias));
	}
	//echo "</div>";
	
	//echo "<div class='box'>";
	//echo "<b>RELATION:</b>";
	$reltypes = isset($_POST['reltypes']) ? $_POST['reltypes'] : 0;
	$persons  = isset($_POST['persons']) ? $_POST['persons'] : 0;
	
	$row = 0;
	foreach ($reltypes as $reltype) {
		if ($reltype) {
			$reltypeid = insert_relationtype($reltype);
			foreach ($persons[$row] as $personid2) {
				if (NULL != get_persons_for_user($personid2, $userid))
					insert_relation_reltype(insert_relation("persons", "persons", $personid, $personid2), $reltypeid);
			}
			$row++;
		}
	}
	//echo "</div>";
	
	/*Επικοινωνία*******************************************************************************************************/
	
	if (isset($_POST['chk2'])) {
		//echo "<div class='box'>";
		//echo "<b>PHONE:</b>";
		$phonecountries = isset($_POST['phonecountries']) ? $_POST['phonecountries'] : 0;
		$code           = isset($_POST['codecountries']) ? $_POST['codecountries'] : 0;
		$phones         = isset($_POST['phones']) ? $_POST['phones'] : 0;
		$phonetypes     = isset($_POST['phonetypes']) ? $_POST['phonetypes'] : 0;
		$row            = 0;
		foreach ($phonecountries as $country) {
			$countryid = insert_country($country, $code[$row]);
			$phoneid   = insert_phone_for_user($countryid, $phones[$row], $phonetypes[$row], $userid);
			if ($phoneid)
				insert_relation("persons", "phones", $personid, $phoneid);
			$row++;
		}
		//echo "</div>";
		
		//echo "<div class='box'>";
		//echo "<b>E-MAIL:</b>";
		$emails     = isset($_POST['emails']) ? $_POST['emails'] : 0;
		$emailtypes = isset($_POST['emailtypes']) ? $_POST['emailtypes'] : 0;
		$row        = 0;
		foreach ($emails as $email) {
			$emailid = insert_email($emails[$row], $emailtypes[$row]); //dimiourgia....
			if ($emailid)
				insert_relation("persons", "emails", $personid, $emailid);
			$row++;
		}
		//echo "</div>";
		
		//echo "<div class='box'>";
		//echo "<b>WEBSITE:</b>";
		$websites     = isset($_POST['websites']) ? $_POST['websites'] : 0;
		$websitetypes = isset($_POST['websitetypes']) ? $_POST['websitetypes'] : 0;
		$row          = 0;
		foreach ($websites as $website) {
			$websiteid = insert_website($websites[$row], $websitetypes[$row]);
			if ($websiteid)
				insert_relation("persons", "websites", $personid, $websiteid);
			$row++;
		}
		//echo "</div>";
	}
	
	/*Διεύθυνση*********************************************************************************************************/
	//echo "<div class='box'>";
	//echo "<b>ADDRESS:</b><br />";
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
	//echo "</div>";	
	/*Απασχόληση********************************************************************************************************/
	//echo "<div class='box'>";
	if (isset($_POST['chk4'])) {
		
		
	}
	//echo "</div>";
	/*Σπουδές***********************************************************************************************************/
	//echo "<div class='box'>";
	if (isset($_POST['chk5'])) {
		
		
	}
	//echo "</div>";
	
	
	$msc                 = microtime(true) - $msc;
	$msc                 = number_format($msc, 2);
	$_SESSION['message'] = "<b>insert.php:</b><br>Έγινε εισαγωγή της επαφής: " . $name . " " . $surname . ", αναγνωριστικό id: " . $personid . "<br />Χρόνος ολοκλήρωσης: $msc δευτερόλεπτα.";
} else
	$_SESSION['warnings'] = "<b>insert.php:</b><br>Δεν έγινε εισαγωγή επαφής!";

unset($_POST);
?>