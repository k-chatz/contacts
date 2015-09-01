<div class="userform">
	<fieldset>
		<legend><b>System connect:</b></legend>
		<form id="userform" action="models/user/login.php" method="POST">
			<input type="text" name="user" placeholder="Username (e-mail)" autofocus>
			<br />
			<input type="password" name="userpass" placeholder="Password">
			<input type="hidden" name="confid" value = <?php echo md5(mt_rand()); ?>>
			<br />
			<input type="reset" value="Clear">
			<input type="submit" value="Connect!">
		</form>

	</fieldset>
</div>