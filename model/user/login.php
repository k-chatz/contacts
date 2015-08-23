<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

ob_start();

include_once('../debug.php');
include_once('../db/db.php');
include_once('../model.php');

session_start();

//dump($_POST , "POST");
//dump($_SESSION , "SESSION");

if (isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['userpass']) && !empty($_POST['userpass']))
{
    $username = $_POST['user'];
	
	//$username = mysql_real_escape_string( $_POST['user']);
	
    $userpass = md5(trim($_POST['userpass']));
    
    if (NULL != $Records = exists_user(0, $username))
    {
        $userid = $Records[0]['userid'];
    
        //$_SESSION['confid'] =  $_POST['confid'];

		update_confid( $userid , $_POST['confid'] );

        if (NULL != exists_password($userid, $userpass))
        {
            switch ($Records[0]['active'])
            {
                case "Activated";
                        echo "<br />case: \"Activated\"<br />";
                        $_SESSION['becomeLogin']    = 1;
                        $_SESSION['userid']         = $userid;
                        $_SESSION['username']       = $username;
                        $_SESSION['isLoggedIn']     = 1;
                        echo "<br />User Is Logged In!<br />";
                        break;
                case "Locked";
                        echo "<br />case: \"Locked\"<br />";
                        $_SESSION['warning'] = "<b>login.php:</b><br />Account: ". $username." is disabled from administrator!";
                        break;
                default;
                        echo "<br />case: \"default\"<br />";
                        $_SESSION['notice'] = "<b>login.php:</b><br />Your account is disabled! To activate and login in your account hit the link that was sent to your inbox.";
                        break;
            }
        }
        else
        {
            $_SESSION['warning'] = "<b>login.php:</b><br />You have entered wrong password, try again!";
            echo $_SESSION['warning'];
        }
    }
    else
    {
        $_SESSION['warning'] = "<b>login.php:</b><br>Could not find a user with this account:" . $username . ", try again or <a href='index.php?register'>register</a> with your own email!";
        echo $_SESSION['warning'];
    }
}
else
{
    $_SESSION['warning'] = "<b>login.php:</b><br>You must fill in both fields to continue!";
    echo $_SESSION['warning'];
}

if(isset($_SESSION['warning']) && $_SESSION['warning'])
    header("Location: ../../index.php?p=login");
else
    header("Location: ../../index.php?cnf=". $_POST['confid'] ."");
?>