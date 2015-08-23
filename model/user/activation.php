<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();

include_once('../plugins/SqlFormatter.php');
include_once('../debug.php');
include_once('../model.php');

session_start();

if ( isset($_GET['id']) && isset($_GET['user']) && isset($_GET['active']))
{
	if ( $Records = exists_user( $_GET['id'] , $_GET['user']) )
	{ 
		switch ($Records[0]['active'])
		{
			case "Activated";
				echo "<br />Activated<br />";
				$_SESSION['notice'] = "<b>activation.php:</b><br />User account <b>'" . $username . "'</b> it is already activated.";
				break;
			case "Locked";
				echo "<br />Locked<br />";
				$_SESSION['warning'] = "<b>activation.php:</b><br />User account <b>'" . $username . "'</b> is locked from administrator!";
				break;
			default;
				echo "<br />default<br />";
				if (exists_activecode($_GET['user'], $_GET['active']))
				{
					activate_user($_GET['user'], $_GET['active']);
					$_SESSION['success'] = "<b>activation.php:</b><br />User account <b>'" . $_GET['user'] . "'</b> successfully activated!, now you can use your username and password to login.";
				}
				else
					$_SESSION['warning'] = "<b>activation.php:</b><br />There is no correlation of the activation code to account: <b>" . $_GET['user'] . "</b>!";
				break;
		}
	}
	else
		$_SESSION['warning'] = "<b>activation.php:</b><br />The account you want to activate is not found!";
}
echo "<br />Header location: index.php";
header("Location: ../../index.php");
?>