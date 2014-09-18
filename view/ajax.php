<?php
ini_set('display_errors', 1);
$microsecond = microtime(true);
include_once('view.php');
include_once('../model/model.php');

//sleep(1);

if($_POST['photopath'])	put_photo_for_person($_POST);
if($_POST['got_alias'])	put_aliasses_for_person($_POST);
if($_POST['got_phone'])	put_phones_for_person($_POST['personid']);
if($_POST['got_address']) put_addresses_for_person($_POST['personid']);
//Σχόλια

//<div id="map-canvas"></div>
?>  


 
<?

$stack = array();
front_flashback_relatives( $_POST , 0 , 0 , $stack );


$microsecond = microtime(true) - $microsecond;
$microsecond = number_format($microsecond, 2);
?>
<sub>Script complete time: <? echo $microsecond; ?>'', Queries: 
	<?
	if (isset($_SESSION['Queries']))
	{
		echo $_SESSION['Queries'];
		unset($_SESSION['Queries']);
	}
	else
		echo "0";
	?>
</sub>

