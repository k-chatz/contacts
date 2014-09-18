<div class="content">
	<div class="userform">
		<fieldset>
			<legend><b>Σύνδεση στη βάση:</b></legend>
			<? $_SESSION['logform'] = "log" . md5(mt_rand()); //echo $_SESSION['logform'];?>
			<form name="myform" action="model/login.php" method="POST">
				<input type="email" name="user" placeholder="Όνομα χρήστη (e-mail)" autofocus>
				<br />
				<input type="password" name="userpass" placeholder="Κωδικός πρόσβασής">
				<input type="hidden" name="logform" value = <? echo $_SESSION['logform']; ?>>
				<br />
				<input type="reset" value="Καθαρισμός">
				<input type="submit" value="Είσοδος">
			</form>
		</fieldset>
	</div>
</div>