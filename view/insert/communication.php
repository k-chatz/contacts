<?php include_once('model/model.php'); ?>
<link rel="stylesheet" type="text/css" href="view/css/insert/communication.css">

<div class="box">
	<h4>Τηλέφωνα:</h4><hr />
	<fieldset>
		<legend><b>Τηλέφωνο:</b></legend>
		<label for="phone">1:</label>
		<input class="country" type="text" name="phonecountries[]" placeholder="Όνομα χώρας" list="countries"/>
		<input class="codecountries" type="text" name="codecountries[]" placeholder="Κωδικός" list="codecountries"/>
		<input class="phone" type="tel" name="phones[]" placeholder="Τηλέφωνο" list="phones"/>
		<input class="phonetypes" type="text" name="phonetypes[]" placeholder="Τύπος τηλεφώνου" list="phonetypes" />
		<input class="plusbtn" type="button" name="phonebtn" value="+"/>
		
		<br/>
		
		<label for="phone">2:</label>
		<input class="country" type="text" name="phonecountries[]" placeholder="Όνομα χώρας" list="countries"/>
		<input class="codecountries" type="text" name="codecountries[]" placeholder="Κωδικός" list="codecountries"/>
		<input class="phone" type="tel" name="phones[]" placeholder="Τηλέφωνο" list="phones"/>
		<input class="phonetypes" type="text" name="phonetypes[]" placeholder="Τύπος τηλεφώνου" list="phonetypes" />
		<input class="removebtn" type="button" name="phonebtn" value="-"/>
	</fieldset>
	
	<br/>
	<h4>Διαδίκτυο:</h4><hr />
	<fieldset>
		<legend><b>E-mail:</b></legend>
		<label for="email">1:</label>
		<input class="email" type="email" name="emails[]" placeholder="example@host.com" list="emails" />
		<input class="emailtypes" type="text" name="emailtypes[]" placeholder="Τύπος e-mail" list="emailtypes" />
		<input class="plusbtn" type="button" name="emailbtn" value="+"/>
		<br/>
		<label for="email">2:</label>
		<input class="email" type="email" name="emails[]" placeholder="example@host.com" list="emails" >
		<input class="emailtypes" type="text" name="emailtypes[]" placeholder="Τύπος e-mail" list="emailtypes" />
		<input class="removebtn" type="button" name="emailbtn" value="-">
	</fieldset>

	<br/>
		
	<fieldset>
		<legend><b>Δικτυακός τόπος:</b></legend>
		<label for="website">1:</label>
		<input type="url" name="websites[]" placeholder="http://www.example.com" list="websites" />
		<input class="websitetype" type="text" name="websitetypes[]" placeholder="Τύπος web-site" list="websitetypes" />
		<input class="plusbtn" type="button" name="websitebtn" value="+"/>
		<br/>
		<label for="website">2:</label>
		<input type="url" name="websites[]" placeholder="http://www.example.com" list="websites" />
		<input class="websitetype" type="text" name="websitetypes[]" placeholder="Τύπος web-site" list="websitetypes" />
		<input class="removebtn" type="button" name="websitebtn" value="-"/>		
	</fieldset>
</div>