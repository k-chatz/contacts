<?php
/*Start timer (End at building/footer.php)*/
$ms = microtime(true);

/*Force display errors/warnings*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

session_start();

include_once('model/plugins/Mobile_Detect.php');
include_once('model/debug.php');
include_once('model/db/db.php');
include_once('model/model.php');
include_once('view/alerts.php');

//Show or hide debugging informations.
if( isset($_GET['debug']) ) $_SESSION['debug'] = $_GET['debug'];

$debug = (isset($_SESSION['debug']) && $_SESSION['debug'] == "on") ? 1 : 0;

/*Device check*/
$detect = new Mobile_Detect();
if ($detect->isMobile())
	$isMobile = true;
else
{
	$_SESSION['notice'] = "<b>index.php:</b><br>This page is only for mobile devices. To continue try to open this page with a mobile device!";
	$isMobile = false;
}

/*Head of the page*/
include_once('view/building/head.php');

/*For user activity checking.*/
include_once('model/user/activity.php'); 

/*For update behavior buttons who is at the top right corner of the application.*/
include_once('view/building/header.php');

?>

<div class="contentplace">

<?php

/*To display info or warning messages (if this exists)*/
session_alert();

if($confid)
{
?>
	<div id="CNF" style="display: none;"><?php echo $confid; ?></div>
<?php
}
?>
	<div class="content">
<?php

/*Page controller*/
include_once('controllers/pageController.php');

?>
	</div> <!-- content -->
</div> <!--contentplace -->

<?php

include_once('view/building/footer.php');

if($debug){
	dump($_SESSION,"SESSION");
}
?>
