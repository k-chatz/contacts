<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();

include_once('../plugins/SqlFormatter.php');
include_once('../debug.php');
include_once('../model.php');

session_start();
/*User Registration*********************************************************************************/
$register = true;
if($register == true)
{
	if (isset($_POST['useremail_1']) && !empty($_POST['useremail_1']) && isset($_POST['useremail_2']) && !empty($_POST['useremail_2']) && isset($_POST['userpass_1']) && !empty($_POST['userpass_1']) && isset($_POST['userpass_2']) && !empty($_POST['userpass_2']))
	{
		if ($_POST['useremail_1'] == $_POST['useremail_2'] && $_POST['userpass_1'] == $_POST['userpass_2'])
		{
			$username = trim($_POST['useremail_1']);
			if (NULL == exists_user( 0 , $username))
			{
				$active = "act" . md5(mt_rand());
				if ( $userid = insert_user($username, md5(trim($_POST['userpass_1'])), $_SERVER['REMOTE_ADDR'], $_SERVER['REMOTE_PORT'], $_SERVER['HTTP_USER_AGENT'], $active))
				{
					$url     = "" . $_SERVER['SERVER_NAME'] . "contacts/model/user/activation.php?id=". $userid ."&user=" . $username . "&active=" . $active . "";
					$message = "<h2>Thank you " . $username . " for registering!</h2><hr /><br /><p>Your account is not activated, 
					To activate click on the following link: </p>" . $url . "<div><sub>Mycnts © 2014<sub></div>";
					if (mail_utf8($_POST['useremail_1'], "Account validation MyCnts", $message))
					{
						$_SESSION['info'] = "<b>register.php:</b><br>Thanks for signing up! We've sent an email account activation at: <b>'" . $username . "'</b>";
						header("Location: ../../index.php?p=login");
					}
					else 
					{
						$_SESSION['warning'] = "<b>register.php:</b><br>Ooops! Something went wrong with sending e-mail!";
						header("Location: ../../index.php?p=register");
					}
				}
				else
				{
					$_SESSION['warning'] = "<b>register.php:</b><br>Ooops! The registration process failed!";
					echo $_SESSION['warning'];
					header("Location: ../../index.php?p=register");
				}
			}
			else
			{
				$_SESSION['warning'] = "<b>register.php:</b><br>The user with e-mail '" . $username . "' already exists, try again with another username!";
				echo $_SESSION['warning'];
				header("Location: ../../index.php?p=register");
			}
		}
		else
		{
			$_SESSION['warning'] = "<b>register.php:</b><br>Incorrect keying in confirmation fields, try again!";
			echo $_SESSION['warning'];
			header("Location: ../../index.php?p=register");
		}
	}
	else
	{
		$_SESSION['warning'] = "<b>register.php:</b><br>You must fill in all required fields!";
		echo $_SESSION['warning'];
		header("Location: ../../index.php?p=register");
	}
	unset($_POST['regform']);
}
else
{
	$_SESSION['warning'] = "<b>register.php:</b><br>This project is not complete yet! User registration  is temporarily disabled.";
	echo $_SESSION['warning'];
	header("Location: ../../index.php");
}
?>