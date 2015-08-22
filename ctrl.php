<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

//dump($_REQUEST , "REQUEST");
 
$microsecond = microtime(true);

//Show or hide Queries for debugging
if( isset($_GET['admin']) ) 
	$_SESSION['admin'] = $_GET['admin'];

//dump($_SESSION,"SESSION");

/*For user activity checking.*/
include_once('model/user/activity.php'); 

/*Head of the page*/
include_once('view/building/head.php');

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

/*Check if p (From page) GET parameter is set*/
if($isMobile && isset($_GET['p'])){
	switch ($_GET['p']) {
	    case "register":
	        if(!$isLoggedIn)
	      	  include_once('view/user/register.php');
	        break;
	    case "login":
	        if(!$isLoggedIn)	
	        	include_once('view/user/login.php');
	        break;
		case "settings":
		/*Account Management code*/
	  		if($isLoggedIn)
	        	include_once('view/content/settings.php');
	        break;
	    case "logout":
				include_once('model/user/logout.php');
				header("Location: index.php");
				die();
	        break;
	     default:
	     	echo "The page you are looking was not found!";
	}
}
else
{
	if(! $isLoggedIn)
		include_once('view/welcome.php');
}

	if($isLoggedIn)
	{
		/*Here is content who view logged in users!*/

		/*Include all required functions*/
		include_once('view/view.php');

		/*Update the database relating to the user about the current status 
		for synchronization at Session variables and db Fields*/
		update_user_status($userid, $isLoggedIn, $ip , $_SERVER['HTTP_USER_AGENT'] );
	
		$_SESSION['REMOTE_ADDR']		= $ip;
		$_SESSION['HTTP_USER_AGENT']	= $_SERVER['HTTP_USER_AGENT'];

		include_once('view/content/tabs.php');
	}
?>
	</div> <!-- content -->
</div> <!--contentplace -->

<?php

//dump($_SESSION , "_SESSION");

$microsecond = microtime(true) - $microsecond;
$microsecond = number_format($microsecond, 2);

include_once('view/building/footer.php'); 
?>