<div class="content">
	<div class="userform">
		<fieldset>
			<legend><b>Δημιουργία λογαριασμού:</b></legend>
			<? $_SESSION['regform'] = "reg" . md5(mt_rand()); //echo $_SESSION['regform']; ?>
			<form action="model/register.php" method="POST">
				<input type="email" name="useremail_1" placeholder="Όνομα χρήστη (e-mail)" autocomplete="off">
				<input type="email" name="useremail_2" placeholder="Επιβεβαίωση e-mail" autocomplete="off"> 
				<input type="password" name="userpass_1" placeholder="Κωδικός πρόσβασής" autocomplete="off"> 
				<input type="password" name="userpass_2" placeholder="Επιβεβαίωση κωδικού" autocomplete="off">
				<input type="hidden" name="regform" value = <? echo $_SESSION['regform']; ?>>
				<input type="reset" value="Καθαρισμός">
				<input type="submit" value="Εγγραφή">
			</form>
		</fieldset>
	</div>
</div>