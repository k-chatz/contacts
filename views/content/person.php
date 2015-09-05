<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/relatives.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/sel_persons.php');

function get_age($birthDate = 0){
	if( $birthDate ) 
		return date_diff(date_create( $birthDate ), date_create('today'))->y;
	else
		return NULL;
}

function put_field( $icon , $value = "" ){
	if($value)
	{ ?>
		<div class="Person_Field_Icon" >
			<img alt="Person field icon" src="views/icons/<?php echo $icon ? $icon : "no_icon.png"; ?>" height="23">
		</div>
		<div class="Person_Field"><?php echo "<b>" . $value . "</b>"; ?></div>
	<?php
	}
}

function put_Separating( $icon , $value = "" ){ 
?>
	<div class="Person_Separating_SubContent">
		<div class="Person_SeparatingField_Icon">
			<img alt="Separating icon" src="views/icons/<?php echo $icon ? $icon : "no_icon.png"; ?>" height="24" >
		</div>
		<div class="Person_SeparatingField"><?php echo $value ? $value : "&nbsp;"; ?></div>
	</div>
<?php
} 

function put_info_for_person($person){
	?>
		<div class="Person_content">
			<div class="Person_Category_Container">
				<?php 
				if(NULL != $aliases = get_string_of_aliases( $person['personid'] ) )
					put_Separating( "circular138.png" , $aliases );
				if( $person['birthday'] )
					put_Separating( "birthday20.png" , "" . date("d-m-Y", strtotime( $person['birthday'] )) . " (" .  get_age( $person['birthday'] ) . " χρονών)" );
				
				if (NULL != $person['imageBase64'])
				{
					//put_Separating( "camera44.png" , $person['photopath'] ); ?>
					<div class="photo" style="background-image: url('<?php echo "data:image;base64,". $person['imageBase64']; ?>');"></div>
				<?php
				}
				?>
			</div>
		</div> 
	<?php
}

function put_comments_for_person($comments = ""){
	if($comments != "")
	{?>
		<div class='Person_content'><?php
			put_Separating( "comments1.png" , "Comments:" ); 
			put_field( "comments1.png" , $comments );
	?>	</div> <?php
	}
	else
		return NULL;
}

function get_string_of_aliases($personid){
	if( NULL != $records = get_aliases(0 , $personid ))
	{
		$aliases = "";
		for( $i = 0 ; $i < $end = count($records) ; $i++ )
		{
			$aliases .= $records[$i]['alias'];
			$aliases .= ($i+1 < $end) ? ", " : "";
		}
		return $aliases;
	}
	else
		return NULL;
}

if( NULL != $records = get_person( $userid , $personid )){
	if($records[0]['birthday'] || $records[0]['imageBase64'])
		put_info_for_person($records[0]);

	if($records[0]['got_phone']){
		put_phones_for_person($records[0]['personid']);
	}

	if($records[0]['got_address']){
		put_addresses_for_person($records[0]['personid']);
	}

	if($records[0]['comments']){
		put_comments_for_person($records[0]['comments']);
	}

	//RELATIVES
    $array = array();
	$stack = array();
	front_flashback_relatives( $array, $records[0], 0, $stack );
	//dump( $stack, "stack" );
}
else
	$_SESSION['error'] = "<b>ajax.php:</b><br />This contact does not exists!";
?>