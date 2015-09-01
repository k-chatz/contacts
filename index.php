<?php

/*Start timer (End at building/footer.php)*/
$ms = microtime(true);

/*Force display errors/warnings*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

session_start();

include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/models/plugins/Mobile_Detect.php');

include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/models/debug.php');

include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/models/model.php');

include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/views/alerts.php');

// Show or hide debugging informations.

if (isset($_GET['debug'])) $_SESSION['debug'] = $_GET['debug'];
$debug = (isset($_SESSION['debug']) && $_SESSION['debug'] == "on") ? 1 : 0;
/*Device check*/
$detect = new Mobile_Detect();

if ($detect->isMobile() || $debug) $isMobile = true;
else {
	$_SESSION['notice'] = "<b>index.php:</b><br />This page is only for mobile devices. To continue try to open this page with a mobile device!";
	$isMobile = false;
}

/*Head of the page*/
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/views/building/head.php');

/*For user activity checking.*/
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/models/user/activity.php');

/*For update behavior buttons who is at the top right corner of the application.*/
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/views/building/header.php');

?>

<div class="body">

<?php
/*To display alert messages (if these exists)*/
session_alert();

if ($confid) {
?>
	<div id="cnf" style="display: none;"><?php
	echo $confid; ?></div>
<?php
}

?>
	<div class="content">
<?php
/*Page controller*/
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/controllers/pages.php');

?>
	</div> <!-- content -->
</div> <!--body -->

<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/views/building/footer.php');

if ($debug) {
	dump($_SESSION, "SESSION");

	// dump($_SERVER,"SERVER");

}

?>
