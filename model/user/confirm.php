<?php

include_once('../debug.php');
include_once('../plugins/SqlFormatter.php');
include_once('../model.php');
dump($_POST);

	
update_field_from_table( "settings" , "option_value" , $_POST['items'] , "option_name" , "items_per_page" );




//header("Location: ../index.php");
?>