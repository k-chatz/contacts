<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

ob_start();

session_name("CntId");
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/debug.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/sel_user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/user/upt_user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/model.php');

$username = isset($_POST['user']) ? trim($_POST['user']) : 0;

$userpass = isset($_POST['userpass']) ? md5(trim($_POST['userpass'])) : 0;

$debug = (isset($_SESSION['debug']) && $_SESSION['debug'] == "on") ? 1 : 0;

if($debug){
    /*Head of the page*/
    include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/views/building/head.php');
    dump($_SESSION , "SESSION");
    dump($_POST , "POST");
}

$failure = 0;

if ($username && $userpass){

    if (NULL != $Records = exists_user(0, $username))
    {
        $userid = $Records[0]['userid'];

        if (NULL != exists_password($userid, $userpass))
        {
            update_confid( $userid , $_POST['confid'] );

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
                        $_SESSION['warning'] = ($debug ? "<b>login.php:</b><br />" : "") . "Account: ". $username." is disabled from administrator!";
                        break;
                default;
                        echo "<br />case: \"default\"<br />";
                        $_SESSION['notice'] = ($debug ? "<b>login.php:</b><br />" : "") . "Your account is disabled! To activate and login in your account hit the link that was sent to your inbox.";
                        break;
            }
        }
        else
        {
            $failure = 1;
            $_SESSION['warning'] = ($debug ? "<b>login.php:</b><br />" : "") . "You have entered wrong password, try again!";
        }
    }
    else
    {
        $failure = 1;
        $_SESSION['warning'] = ($debug ? "<b>login.php:</b><br />" : "") . "Could not find a user with this account: " . $username . ", try again or <a href='index.php?p=register'>register</a> with your own email!";
    }
}
else
{
    $failure = 1;
    $_SESSION['warning'] = ($debug ? "<b>login.php:</b><br />" : "") . "You must fill in both fields to continue!";
}

redirect($failure ? "?p=login" : "?cnf=" . $_POST['confid'], $debug);
?>
