<?php
session_start();
include_once('model.php');
if ( isset($_GET['id']) && isset($_GET['user']) && isset($_GET['active']))
{
	if ( $Records = exists_user( $_GET['id'] , $_GET['user']) )
	{ 
		switch ($Records[0]['active'])
		{
			case "Activated";
				echo "<br />Activated<br />";
				$_SESSION['message'] = "<b>activation.php:</b><br />Ο λογαριασμός " . $username . " είναι ήδη ενεργοποιημένος.";
				break;
			case "Locked";
				echo "<br />Locked<br />";
				$_SESSION['warnings'] = "<b>activation.php:</b><br />Ο λογαριασμός: " . $username . " είναι απενεργοποιημένος από το διαχειριστή!";
				break;
			default;
				echo "<br />default<br />";
				if (exists_activecode_for_user($_GET['user'], $_GET['active']))
				{
					activate_user($_GET['user'], $_GET['active']);
					$_SESSION['message'] = "<b>activation.php:</b><br />Έγινε ενεργοποίηση του λογαριασμου: <b>" . $_GET['user'] . "</b> με επιτυχία, τώρα μπορείς να χρησιμοποιήσεις το όνομα χρήστη και τον κωδικό σου για να συνδεθείς.";
				}
				else
					$_SESSION['warnings'] = "<b>activation.php:</b><br />Δεν υπάρχει αντιστοίχιση του κωδικού ενεργοποίησης με τον λογαριασμό: <b>" . $_GET['user'] . "</b>!";
				break;
		}
	}
	else
		$_SESSION['warnings'] = "<b>activation.php:</b><br />Ο λογαριασμός που θέλεις να ενεργοποιήσεις δεν βρέθηκε!";
}
echo "<br />Header location: index.php";
header("Location: ../index.php");
?>