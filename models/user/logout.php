<?php
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']){
	/*Logout user*/
	logout();

	$_SESSION['success'] = ($debug ? "<b>logout.php:</b><br />" : "") . "Now, you are disconnected from the system.";
}else{
	$_SESSION['notice'] = ($debug ? "<b>logout.php:</b><br />" : "") . "Already offline!";
}

redirect("", $debug);

die();

?>