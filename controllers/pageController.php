<?php
$page = isset($_GET['p']) ? $_GET['p'] : "";

/*Check if p (From page) GET parameter is set*/
if($isMobile && !empty($page)){
	switch ($page){
	    case "register":
	        if(!$isLoggedIn)
	      	  include_once('view/user/register.php');
	        break;
	    case "login":
	        if(!$isLoggedIn)	
	        	include_once('view/user/login.php');
	        break;
	    case "logout":
				include_once('model/user/logout.php');
				header("Location: index.php");
				die();
	        break;
		case "settings":
		/*Account Management code*/
	  		if(!$isLoggedIn){
				header("Location: index.php");
				$_SESSION['error'] = "<b>index.php:</b><br>The page you are looking was not found!";
				die();
			}
	        break;
	     default:
	     	$_SESSION['error'] = "<b>index.php:</b><br>The page you are looking was not found!";
	     	header("Location: index.php");
			die();
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

		if($page == "settings"){
			include_once('view/content/settings.php');
		}
		else
		{
			include_once('view/content/tabs.php');
		}
	}
?>