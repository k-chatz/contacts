function visibility(chk, item){
	var div = $(item);
	if(chk.checked)
		div.fadeIn();
	else
		div.fadeOut('fast');
};

$(document).ready(function(){
	$('#plusaddress').click(function(){
		var num = $('#address_num').val();
		$('#rmad'+num++).toggle();
		$('#address_num').val(num);
	
		addnum=num;
		addnum++;
		
		var html = '<div class="newaddress"><b>Διεύθυνση '+addnum+':</b>\
		<input class="removeaddr" id="rmad'+num+'" type="button" name="plusaddress" value="X"><br />\
		<label for="country">Χώρα: </label><input type="text" name="country['+num+']"/>\
		&nbsp; <label for="city">Πόλη: </label><input type="text" name="city['+num+']"/>\
		&nbsp; <label for="region">Νομός: </label><input type="text" name="region['+num+']"/>\
		&nbsp; <label for="location">Περιοχή: </label><input type="text" name="location['+num+']"/>\
		<br /><div class="street-place">\
		<div class="street">\
			<label for="streets">Οδός: </label><input type="text" name="streets['+num+'][]" />\
			&nbsp; <label for="number">Αριθμός: </label><input type="number" name="numbers['+num+'][]" style="width:50px" />\
			<input class="plusstreet" type="button" name="plusstreet" value="+" />\
			<input type="hidden" value="'+addnum+'" class="cur_street" /></div>\
		</div><label for="addresscomnt">Σχόλια: <br /></label>\
		<textarea style="width:99%" name="addresscomnt['+num+']" rows="5" cols="30"></textarea>\</div>';
		$('#addresses').append(html);
	});
	
	//Δημιουργία νέου πλαισίου διεύθυνσης
	$("body").on('click', '.removeaddr', function(){
		$(this).parent('div').remove();
		var num = $('#address_num').val();
		num--;
		if( num > 1 )
			$('#rmad'+num).toggle();
		$('#address_num').val(num);
	});
	
	
	//Δημιουργία πεδίων για διεύθυνση
	$("body").on('click', '.plusbtn', function(){
		var num = $(this).next().val();
		var html = "<div class='street'><label for='streets'>Οδός:</label>\
				<input type='text' name='streets["+num+"][]' list='streets'/>\
				<input type='number' name='numbers["+num+"][]' class='streetnumber' />\
				<input class='removebtn' type='button' value='-' />";
		$(this).parents().eq(1).append(html);
	});
	
	//Διαγραφή τρέχοντος πεδίου διεύθυνσης
	$("body").on('click', '.removebtn', function(){
		$(this).parent('div').remove();
	});
	
	
	
	
	
	
	
	
	
});

