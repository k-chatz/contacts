<?php
function put_addresses_for_person($personid){
	if (NULL != $Records = get_addresses(0, $personid))
	{
		foreach ($Records as $Record)
		{
		?>
		<div class='Person_content'>
		<?php
			put_Separating( "home82.png" , $Record['city'] ); 
			put_field( "placard_1.png" , get_string_of_streets_from_address($Record) );
			put_field( "locator7.png" , $Record['location'] );
			put_field( "placeholder8.png" , $Record['region'] );
			put_field( "flag11.png" , $Record['country'] );
			put_field( "comments1.png" , $Record['comments'] );
		?>
		</div>
		<?php
		} 
	}
}
?>