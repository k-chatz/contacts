<?php
include_once('../model/model.php');
session_start();

echo "POST:<pre>";
var_dump($_POST);
echo "</pre>";

echo "SESSION:<pre>";
var_dump($_SESSION);
echo "</pre>";

/*Διαδικασία_εισόδου_χρήστη*********************************************************************************/

if ((isset($_POST['logform']) && $_POST['logform'] == $_SESSION['logform'] ))
{
    if (isset($_POST['user']) && !empty($_POST['user']) && isset($_POST['userpass']) && !empty($_POST['userpass']))
    {
        $username = $_POST['user'];
        $userpass = md5(trim($_POST['userpass']));
        
        if (NULL != $Records = exists_user(0, $username))
        {
            $userid = $Records[0]['userid'];
            if (NULL != exists_password_for_user($userid, $userpass))
            {
				switch ($Records[0]['active'])
				{
					case "Activated";
						echo "<br />case: \"Activated\"<br />";
						$_SESSION['login']		= 1;
						$_SESSION['userid']		= $userid;
						$_SESSION['username']	= $username;
						$_SESSION['loggedin']	= 1;
						echo "<br />Loggedin!<br />";
						break;
					case "Locked";
						echo "<br />case: \"Locked\"<br />";
						$_SESSION['warnings'] = "<b>login.php:</b><br />Ο λογαριασμός: " . $username . " είναι απενεργοποιημένος από το διαχειριστή!";
						break;
					default;
						echo "<br />case: \"default\"<br />";
						$_SESSION['warnings'] = "<b>login.php:</b><br />Ο λογαριασμός σου είναι απενεργοποιημένος! Για ενεργοποίηση πάτα το σύνδεσμο που έχει σταλεί στο inbox σου.";
						break;
				}
            }
            else
            {
                $_SESSION['warnings'] = "<b>login.php:</b><br />Ο κωδικός πρόσβασης δεν αντιστοιχεί στο λογαριασμό: <b>" . $username . "</b>!";
                echo $_SESSION['warnings'];
            }
        }
        else
        {
            $_SESSION['warnings'] = "<b>login.php:</b><br>Δεν βρέθηκε λογαριασμός για το χρήστη: <b>" . $username . "</b><br>Προσπάθησε ξανά με διαφορετικό όνομα χρήστη ή κάνε <a href='index.php?register'>εγγραφή</a>!";
            echo $_SESSION['warnings'];
        }
    }
    else
    {
        $_SESSION['warnings'] = "<b>login.php:</b><br>Πρέπει να συμπληρώσεις και τα δύο πεδία!";
        echo $_SESSION['warnings'];
    }
}
else
{
	$_SESSION['warnings'] = "<b>login.php:</b><br>POST['logform'] != SESSION['logform']";
	echo $_SESSION['warnings'];
}
header("Location: ../index.php");
?>