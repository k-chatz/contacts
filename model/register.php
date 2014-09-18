<?php
include_once('../model/model.php');
session_start();
/*Διαδικασία_εγγραφής_χρήστη*********************************************************************************/
if (isset($_POST['regform']) && $_POST['regform'])
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
                    $url     = "" . $_SERVER['SERVER_NAME'] . "/mycnts/model/activation.php?id=". $userid ."&user=" . $username . "&active=" . $active . "";
                    $message = "<h2>Ευχαριστούμε " . $username . " για την εγγραφή!</h2><hr /><br /><p>Ο λογαριασμός σου δεν είναι ενεργοποιημένος, 
					για να ενεργοποιηση κάνε κλικ στον παρακάτω σύνδεσμο: </p>" . $url . "<div><sub>Mycnts © 2014<sub></div>";
                    if (mail_utf8($_POST['useremail_1'], "Επικύρωση λογαριασμού MyCnts", $message))
                    {
                        $_SESSION['message'] = "<b>register.php:</b><br>Ευχαριστούμε για την εγγραφή! Σου έχουμε στείλει ένα e-mail ενεργοποίησης λογαριασμού στη διεύθυνση: <b>" . $username . "</b>";
                        header("Location: ../index.php?login");
                    }
                    else 
                    {
                        $_SESSION['warnings'] = "<b>register.php:</b><br>Ουπς! Κάτι πήγε στραβά με την αποστολή e-mail!";
                        header("Location: ../index.php?register");
                    }
                }
                else
                {
                    $_SESSION['warnings'] = "<b>register.php:</b><br>Η διαδικασία εγγραφής δεν ήταν επιτυχής!";
                    echo $_SESSION['warnings'];
                    header("Location: ../index.php?register");
                }
            }
            else
            {
                $_SESSION['warnings'] = "<b>register.php:</b><br>Ο χρήστης " . $username . " υπάρχει ήδη, δοκίμασε ξανά με διαφορετικό username!";
                echo $_SESSION['warnings'];
                header("Location: ../index.php?register");
            }
        }
        else
        {
            $_SESSION['warnings'] = "<b>register.php:</b><br>Στα πεδία επιβεβαίωσης δεν έχεις συμπληρώσει τα ίδια στοιχεία, προσπάθησε ξανά!";
            echo $_SESSION['warnings'];
            header("Location: ../index.php?register");
        }
    }
    else
    {
        $_SESSION['warnings'] = "<b>register.php:</b><br>Πρέπει να συμπληρώσεις όλα τα απαραίτητα πεδία!";
        echo $_SESSION['warnings'];
        header("Location: ../index.php?register");
    }
    unset($_POST['regform']);
}
?>