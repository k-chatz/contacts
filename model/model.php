<?php
ini_set('display_errors', 1);
ob_start(); 

//require_once('SqlFormatter.php');
include('SqlFormatter.php');

function Query($sql, $debug, $db_name = "kostis_mycnts")
{
	$print = isset($_SESSION['debug']) ? $_SESSION['debug'] : 0;
	$print = 1;
	
	$msc   = microtime(true);
	
	/*Σύνδεση με τη βάση*/
	include('connection.php');
	
	if ($result = $mysqli->query($sql)) {
		isset($_SESSION['Queries']) ? $_SESSION['Queries']++ : $_SESSION['Queries'] = 1;
		usleep(10000);
		$msc = microtime(true) - $msc;
		$msc = number_format($msc, 3);
		
		if ($result !== true) //SELECT
			{
			if ($result->num_rows) {
				//$Array = mysqli_fetch_all($result,MYSQLI_ASSOC); //PHP/5.5.11 ONLY
				$Array = array(
					array()
				);
				$i     = 0;
				while ($row = $result->fetch_assoc()) {
					$r = 0;
					while ($r++ < count($row)) {
						$value           = current($row);
						$key             = key($row);
						$Array[$i][$key] = $value;
						next($row);
					}
					$i++;
				}
				if($print) show_query(1, $debug, $mysqli->host_info, $db_name, $sql, $result->num_rows, $msc, $Array);
				$result->close();
			} else {
				if($print) show_query(1, $debug, $mysqli->host_info, $db_name, $sql, 0, $msc, NULL);
				$result->close();
				return NULL;
			}
		} else //INSERT, UPDATE , DELETE 
			{
			$Array = $mysqli->insert_id;
			if($print) show_query(2, $debug, $mysqli->host_info, $db_name, $sql, $mysqli->insert_id, $msc, $Array);
		}
		
		$mysqli->close();
		return $Array;
	} else {
		$msc = microtime(true) - $msc;
		$msc = number_format($msc, 2);
		
		if($print) show_query(3, $debug, $mysqli->host_info, $db_name, $sql, 0, $msc, $mysqli->error);
		$mysqli->close();
		
		return NULL;
	}
} 

function show_query($type, $debug, $host_info, $db_name, $sql, $rows, $msc, $Result)
{

	/*Βιβλιοθήκη για μορφοποίηση αλφαριθμητικού sql*/
	//require_once('SqlFormatter.php');
	//include('SqlFormatter.php');

	switch ($type) {
		case 1:
			echo "<div class='QSELECT'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'> <b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a>
			echo "<div class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code( $debug[0]['function'] ) ."</pre>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo  SqlFormatter::format($sql);
			
			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Result " . $rows . " records:</b></div>";
			break;
		case 2: 
			echo "<div class='QINSERT'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'> <b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a> 
			echo "<div  class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code( $debug[0]['function'])."</pre>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo SqlFormatter::format($sql);

			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Auto Increment ".$rows." :</b></div>";
			break;
		case 3:
			echo "<div class='QERROR'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'><b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a>
			echo "<div  class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code($debug[0]['function'])."</pre>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo SqlFormatter::format($sql);

			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>NOT executed because:</b></div>";
			break;
	}
	echo "<pre class='QRESULT'>";
	print_r($Result);
	echo "</pre>";
	echo "</div></div>";
}

function get_function_source_code($function = "")
{
	if($function)
	{
		$func = new ReflectionFunction($function);
		$filename = $func->getFileName();
		$start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
		$end_line = $func->getEndLine();
		$length = $end_line - $start_line;

		$source = file($filename);
		$body = implode("", array_slice($source, $start_line, $length));
		return $body; 
	}
	else
		return NULL;
}

function get_function_args($debug)
{
	$i      = 0;
	$string = "( ";
	foreach ($debug[0]['args'] as $value) {
		$string = $value ? $string . $value : $string . "\"\"";
		$string = ($i == count($debug[0]['args']) - 1) ? $string = $string . " )" : $string = $string . " , ";
		$i++;
	}
	return $string;
}

function get_string_of_streets_from_address($address)
{
	$streets = "";
	$i       = 0;
	
	if($address['streets'])
	{
		foreach ($address['streets'] as $value)
			$streets = $streets . ($i++ > 0 ? " & " : " ") . $value['street'] . " " . $value['number'];
		return $streets;
	}
	else
		return NULL;
}

function get_string_of_full_address($address)
{
	return "" . get_string_of_streets_from_address($address) . ", " . $address['location'] . ", " . $address['city'] . ", " . $address['region'] . ", " . $address['country'] . ", " . $address['comments'] . "";
}

function mail_utf8($to, $subject = '(No subject)', $message = "")
{
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
	$headers .= "To: <" . $to . ">" . "\r\n";
	$headers .= "From: MyCnts <mycnts@projects.codescar.eu>" . "\r\n";
	return mail($to, "=?UTF-8?B?" . base64_encode($subject) . "?=", $message, $headers);
}


function client_ip()
{
    if( !empty( $_SERVER['HTTP_X_FORWARED_FOR'] ) )
        $ip = $_SERVER['HTTP_X_FORWARED_FOR'];
    else if ( !empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

function get_relation_string( $gender , $Parrent_level = 0 , $Child_level = 0 )
{
$relation = "";
	switch ($Parrent_level)
	{
		case 0:
			switch ($Child_level)
			{
				case 1:
					$relation = $gender == "male" ? "Γιός" : "Κόρη"; 
				break;
				
				case 2:
					$relation = $gender == "male" ? "Εγγονός" : "Εγγονή"; 
				break;
				
				case 3:
					$relation = $gender == "male" ? "Δισέγγονος" : "Δισέγγονη"; 	
				break;
				
				case 4:
					$relation = $gender == "male" ? "...." : "....";
			}
		break;
		case 1:
			$relation = $gender == "male" ? "Πατέρας" : "Μητέρα"; 
			if($Child_level)
				switch ($Child_level)
				{
					case 1:
						$relation = $gender == "male" ? "Αδερφός" : "Αδερφή"; 
					break;
					case 2:
						$relation = $gender == "male" ? "Ανιψιός" : "Ανιψιά"; 
					break;
					case 3:				
						$relation = $gender == "male" ? "...." : "...."; 				
					break;
					
					case 4:
						$relation = $gender == "male" ? "...." : "....";
				}
		break;
		case 2:
			$relation = $gender == "male" ? "Παππούς" : "Γιαγιά"; 
			if($Child_level)
				switch ($Child_level)
				{
					case 1:
						$relation = $gender == "male" ? "Θείος" : "Θεία"; 
					break;
					case 2:
						$relation = $gender == "male" ? "Ξάδερφος" : "Ξαδέρφη"; 
					break;
					case 3:				
						$relation = $gender == "male" ? "...." : "...."; 				
					break;
					
					case 4:
						$relation = $gender == "male" ? "...." : "....";
				}
		break;
	}
return $relation;
}


//TODO Όταν ο χρήστης προσθέτει μια επαφή αν βάζει γονείς, σε αυτούς που έβαλε ότι τους έχει γονείς θα πρέπει να
//ενημερώνεται το πεδίο τους number_of_childs.
function rear_flashback_relatives( $parrentid , $parrent_gender , $Parrent_level = 0 ,$Child_level = 0 , $exception = 0 , $number_of_childs , &$stack)
{
	if( $number_of_childs && ( NULL != ( $Records = get_childs_from_parrent(  $parrentid , $parrent_gender , $exception , $stack ) ) ) )
	{
		$Child_level++; 
		for( $i = 0 ; $i < count($Records) ; $i++ )
		{
			$relation = get_relation_string( $Records[$i]['sex'] , $Parrent_level , $Child_level );
			 echo "<p class='Debug1'>L:[".$Parrent_level."][".$Child_level."]|N:".$Records[$i]['personid']."|".$relation."|=> ".$Records[$i]['name']." ".$Records[$i]['surname']."</p>";
			if ( ! in_array( $Records[$i]['personid'] , $stack))
				array_push($stack, $Records[$i]['personid'] );
			if($Records[$i]['number_of_childs']) 
				rear_flashback_relatives( $Records[$i]['personid'] , $Records[$i]['sex'] , $Parrent_level , $Child_level , $exception , $number_of_childs , $stack);
		}
	}
}

function front_flashback_relatives( $person , $Parrent_level = 0 , $exception = 0 , &$stack )
{
	if ( ! in_array( $exception , $stack))
		array_push($stack, $exception );
		
	$relation = get_relation_string( $person['sex'] , $Parrent_level );
	
	if($Parrent_level)
		echo "<p class='Debug2'>L:[0][".$Parrent_level."]|N:".$person['personid']."|".$relation."|=> ".$person['name']." ".$person['surname']."</p>";
	rear_flashback_relatives( $person['personid'] ,$person['sex'] , $Parrent_level , 0 , $exception , $person['number_of_childs'] , $stack );

	if( $person['motherid'] || $person['fatherid'] )
	{
		$root = get_parrents( $person['motherid'] ? $person['motherid'] : 0 , $person['fatherid'] ? $person['fatherid'] : 0 );
		front_flashback_relatives( $root[0] , ++$Parrent_level , $person['personid'] , $stack ); //Αριστερό υποδένρο.
		front_flashback_relatives( $root[1] , $Parrent_level-- , $person['personid'] , $stack ); //Δεξί υποδένρο.
	}
}


include('sql_select.php');
include('sql_insert.php');
include('sql_update.php');
//include('sql_delete.php');
?>