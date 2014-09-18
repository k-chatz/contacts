<?
function alert()
{
	if (isset($_SESSION['message']))
	{
	?> 
		<div id="message">
			<div class="alert_icon">
				<img src="view/images/information1.png" height="24" />
			</div>
			<div class="alert_content"><? echo $_SESSION['message'] ?></div>
			<div class="close" title="Απόκρυψη" onclick="hide( $(this).parent() )">X</div>
		</div>
	<?
		unset($_SESSION['message']);
	}
	
	if (isset($_SESSION['warnings']))
	{
	?>
		<div id="warning">
			<div class="alert_icon">
				<img src="view/images/exclamation.png" height="24" />
			</div>
			<div class="alert_content"><? echo $_SESSION['warnings'] ?></div>
			<div class="close" title="Απόκρυψη" onclick="hide( $(this).parent() )">X</div>
		</div>
	<?
		unset($_SESSION['warnings']);
	}
}

function put_field( $icon , $value = "" )
{
	if($value)
	{?>
		<div class="Person_Field_Icon" >
			<img src="view/images/<? echo $icon ? $icon : "no_icon.png"  ?>" height="23">
		</div>
		<div class="Person_Field"><? echo $value ?></div>
	<?
	}
}

function put_Separating( $icon , $value = "" )
{?>
	<div class="Person_Separating_SubContent">
		<div class="Person_SeparatingField_Icon">
			<img src="view/images/<? echo $icon ? $icon : "no_icon.png"  ?>" height="24" >
		</div>
		<div class="Person_SeparatingField"><? echo $value ? $value : "&nbsp;"  ?></div>
	</div>	
<?
}

function put_photo_for_person($person)
{
	//if exists file... 
	if (NULL != $person['photopath'])
	{
	?>
		<div class="Person_content">
			<div class="Person_Category_Container">
				<? put_Separating( "camera44.png" , ""); ?>
				<img src="view/images/<? echo $person['photopath'] ?>">
			</div>
		</div> 
	<?
	}
}

function put_aliasses_for_person($person)
{
	if (NULL != $Records = get_aliases(0, $person['personid']))
	{?>
	<div class="Person_content"><?
		put_Separating( "circular138.png" , "Άλλα ονόματα:" );
		foreach ($Records as $Record)
			foreach ($Record as $value)
				put_field( "flickr5.png" , $value );
	?>
	</div>
	<?
	}
}

function put_phones_for_person($personid)
{
	if (NULL != $Records = get_phones(0, $personid))
	{
	?><div class="Person_content"><?
			put_Separating( "phone45.png" , "Τηλέφωνα:" );
			foreach ($Records as $Record)
			{
				switch ($Record['phonetype'])
				{
					case 1:
						put_field( "cellphone57.png" , "<a href='tel:".$Record['phone']."'>".$Record['phone']."</a>" );
						break;
					case 2:
						put_field( "phone25.png" , "<a href='tel:".$Record['phone']."'>".$Record['phone']."</a>" );
						break;
				}
				
				if (file_exists("view/images/" . $Record['operator'] . ""))
				{?>
					<div class="PhoneOperator">
						<img src="view/images/<? echo $Record['operator'] ?>" height="24">
					</div><?
				}
				if (file_exists("view/images/" . $Record['packet'] . ""))
				{
				?>
					<div class="PhonePacket">
						<img src="view/images/<? echo $Record['packet'] ?>" height="24">
					</div><?
				}
			}?>	
		</div>
	<?
	}
} 
 
function put_addresses_for_person($personid)
{
	if (NULL != $Records = get_addresses(0, $personid))
	{?>
		<div class='Person_content'><?
		foreach ($Records as $Record)
		{
			put_Separating( "home82.png" , $Record['city'] ); 
			put_field( "placard.png" , get_string_of_streets_from_address($Record) );
			put_field( "locator7.png" , $Record['location'] );
			put_field( "placeholder8.png" , $Record['region'] );
			put_field( "flag11.png" , $Record['country'] );
			put_field( "comments1.png" , $Record['comments'] );
		}?>
		</div><?
	}
}
?>