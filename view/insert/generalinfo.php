<?php include_once('model/model.php'); ?>

<div class="box">
	<fieldset>
	<legend><b>Στοιχεία:</b></legend>
		<input id="name" type="text" name="name" maxlength="40" placeholder="*Όνομα" list="names" required autofocus>
		<input id="surname" type="text" name="surname" maxlength="40" placeholder="*Επώνυμο" list="surnames" required >
		<br/>
		<input id="alias" type="text" name="aliases[]" maxlength="40" placeholder="Ψευδώνυμο" list="aliases">
		<input class="plusbtn" id="plusalias" type="button" name="plusalias" value="+">
		<br/>
		<input id="alias" type="text" name="aliases[]" maxlength="40" placeholder="Ψευδώνυμο" list="aliases">
		<input class="removebtn" id="plusalias" type="button" name="plusalias" value="-">
		
		<br/>
		
		<label for="birthday">Ημερομηνία γέννησης:</label>
		<input id="birthday" type="date" name="birthday">
		
		<label>*Φύλο:</label>
		<input type="radio" name="sex" value="male" id="male" required>
		<label for="male">Άνδρας</label>
		<input type="radio" name="sex" value="female" id="female" required>
		<label for="female">Γυναίκα</label>
	</fieldset>
	
	<hr />
	
	<fieldset>
	<legend><b>Φωτογραφία:</b></legend>
		<input type="file" name="photofile" value="Επιλογή αρχείου..">
	</fieldset>

	<hr />

	<fieldset>
	<legend><b>Συσχετίσεις:</b></legend>
		<br/>
		<label for="acquaintance">Ημερομηνία γνωριμίας:</label>
		<input id="acquaintance" type="date" name="acquaintance" value="<?php echo date('Y-m-d'); ?>">
		<br/>

		<label>Είναι:</label>
		<input type="text" name="reltypes[]" list="reltypes" />
		<label>με:</label>
		<select name="persons[0][]" style="width:200px;" multiple tabindex="8">
		<?php
		if( NULL != $Persons )
		{
			for ($row = 0; $row <  count($Persons) ; $row++) 
				echo "<option value='".$Persons[$row]['personid']."'>".$Persons[$row]['name']." ".$Persons[$row]['surname']." (".$Persons[$row]['personid'].")</option>";
		}
		?>
		</select>
		<input class="plusbtn" type="button" name="relbtn" value="+">
		
		<br/>
		
		<label>Είναι:</label>
		<input type="text" name="reltypes[]" list="reltypes" />
		<label>με:</label>
		<select name="persons[1][]" style="width:200px;" multiple tabindex="8">
		<?php
		if( NULL != $Persons )
		{
			for ($row = 0; $row <  count($Persons) ; $row++) 
				echo "<option value='".$Persons[$row]['personid']."'>".$Persons[$row]['name']." ".$Persons[$row]['surname']." (".$Persons[$row]['personid'].")</option>";
		}
		?>
		</select>	
		<input class="removebtn" type="button" name="relbtn" value="-">
	</fieldset>

</div>
