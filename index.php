<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();
session_start();

include_once('model/plugins/Mobile_Detect.php');
include_once('model/debug.php');
include_once('model/db/db.php');
include_once('model/model.php');
include_once('view/alerts.php');

//dump($_SERVER);

$detect = new Mobile_Detect();
if ($detect->isMobile())
	$isMobile = true;
else
{
	$_SESSION['warning'] = "<b>index.php:</b><br>This page is only for mobile devices. To continue try to open this page with a mobile device!";
	$isMobile = false;
}
include_once('ctrl.php');
?>
