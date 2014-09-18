<?php include_once('model/model.php'); ?>

<link rel="stylesheet" type="text/css" href="view/css/insert/address.css">

	<input type="hidden" value="0" name="address_num" id="address_num" />

	<div class="newaddress">
		<b>Διεύθυνση 1:</b>
		<br/>
		<label for="existaddress">Θα γίνει εισαγωγή της διεύθυνσης:</label>
		<select name="existaddress[]" style="width:100%">
			<option value=""></option>
			<?php
			if( NULL != $addresses)
				foreach($addresses as $address)
					echo "<option value='".$address['addressid']."'>". get_string_of_full_address($address) ."</option>";
			?>
		</select>
		
		<div class="data">
			<b>Στοιχεία:</b>
			<div class="street-place">
				<div class="street">
					<label for="streets">Οδός:</label>
					<input type="text" name="streets[0][]" list="streets" />
					<input type="number" name="numbers[0][]" class="streetnumber"/>
					<input class="plusbtn" type="button" value="+" />
					<input type="hidden" value="0" class="cur_street" />
				</div>
			</div>
		
			<br/>
			<label for="location">Περιοχή:</label>
			<input type="text" name="location[]" list="locations" />
			<label for="city">Πόλη:</label>
			<input type="text" name="city[]" list="cities" />
			<br/>
			<label for="region">Νομός:</label>
			<input type="text" name="region[]" list="regions" />	
			<label for="country">Χώρα:</label>
			<input type="text" name="country[]" list="countries" />
			<br/>
			<label for="addresscomnt">Σχόλια:<br></label>
			<textarea style="width:30%; max-width:50%" name="addresscomnt[]" rows="5" cols="5"></textarea>
			<input id="plusaddress" type="button" name="plusaddress" value="+"/>
		</div>
		
		<div class="map">
			<b>Σημείο στο χάρτη:</b>
		</div>
		
	</div>
	
<div class="addressbox">

<div class="newaddress">
		<b>Διεύθυνση 2:</b>
		<br/>
		<label for="existaddress">Θα γίνει εισαγωγή της διεύθυνσης:</label>
		<select name="existaddress[]" style="width:100%">
		<option value=""></option>
		<?php
		if( NULL != $addresses)
			foreach($addresses as $address)
				echo "<option value='".$address['addressid']."'>". get_string_of_full_address($address) ."</option>";
		?>
		</select>

		<div class="data">
			<b>Στοιχεία:</b>
			<div class="street-place">
				<div class="street">
					<label for="streets">Οδός:</label>
					<input type="text" name="streets[1][]" list="streets" />
					<input type="number" name="numbers[1][]" class="streetnumber"/>
					<input class="plusbtn" type="button" value="+" />
					<input type="hidden" value="0" class="cur_street" />
				</div>
			</div>
		
			<br/>
			<label for="location">Περιοχή:</label>
			<input type="text" name="location[]" list="locations" />
			<label for="city">Πόλη:</label>
			<input type="text" name="city[]" list="cities" />
			<br/>
			<label for="region">Νομός:</label>
			<input type="text" name="region[]" list="regions" />	
			<label for="country">Χώρα:</label>
			<input type="text" name="country[]" list="countries" />
			<br/>
			<label for="addresscomnt">Σχόλια:<br></label>
			<textarea style="width:30%; max-width:50%" name="addresscomnt[]" rows="5" cols="5"></textarea>
			<input id="plusaddress" type="button" name="plusaddress" value="+"/>
		</div>
		
		<div class="map">
			<b>Σημείο στο χάρτη:</b>
		</div>
		
	</div>

</div>