<?php
function put_person($pid, $sex, $name,$surname){
?><div class='Person'>														
	<div id="pid<?php echo $pid; ?>" class="person_label">
		<div class="person_label_icon">
			<img height="22" alt="Person icon" src="view/images/<?php echo ($sex == "male") ? "businessman94.png" : "businessman94.png" ?>"/>
		</div>
		<div class="person_label_content">
			<b>
			<?php
			//echo "[". $pid . "] ";
			echo ($name != "-") ? $name." " : "" ;
			echo ($surname != "-") ? $surname." " : "" ;
			
			if( $name == "-" && $surname == "-" )
				echo get_string_of_aliases( $pid );
			?>
			</b>
		</div>
		<div class="person_label_tools">
			<?php include('animations/loader.php'); ?>
		</div>
	</div>
	<div class="Person_Container" style="display: none;"><!--*ajax*--></div>
  </div>
<?php
}

function get_age($birthDate = 0)
{
	if( $birthDate ) 
		return date_diff(date_create( $birthDate ), date_create('today'))->y;
	else
		return NULL;
}

function put_field( $icon , $value = "" )
{
	if($value)
	{ ?>
		<div class="Person_Field_Icon" >
			<img alt="Person field icon" src="view/images/<?php echo $icon ? $icon : "no_icon.png"; ?>" height="23">
		</div>
		<div class="Person_Field"><?php echo "<b>" . $value . "</b>"; ?></div>
	<?php
	}
}

function put_Separating( $icon , $value = "" )
{ ?>
	<div class="Person_Separating_SubContent">
		<div class="Person_SeparatingField_Icon">
			<img alt="Separating icon" src="view/images/<?php echo $icon ? $icon : "no_icon.png"; ?>" height="24" >
		</div>
		<div class="Person_SeparatingField"><?php echo $value ? $value : "&nbsp;"; ?></div>
	</div>	
<?php
} 

function put_info_for_person($person)
{
	//if exists file... 
	?>
		<div class="Person_content">
			<div class="Person_Category_Container">
				<?php 
				if(NULL != $aliases = get_string_of_aliases( $person['personid'] ) )
					put_Separating( "circular138.png" , $aliases );
				if( $person['birthday'] )
					put_Separating( "birthday20.png" , "" . date("d-m-Y", strtotime( $person['birthday'] )) . " (" .  get_age( $person['birthday'] ) . " χρονών)" );
				
				if (NULL != $person['photopath'])
				{
					//put_Separating( "camera44.png" , $person['photopath'] ); ?>
					<div class="photo" style="background-image: url('view/images/<?php echo $person['photopath']; ?>');"></div>
				<?php
				}
				?>
			</div>
		</div> 
	<?php

}

function put_phones_for_person($personid)
{
	if (NULL != $Records = get_phones(0, $personid))
	{
	?><div class="Person_content"><?php
			put_Separating( "phone45.png" , "Τηλέφωνα:" );
			foreach ($Records as $Record)
			{
				switch ($Record['type'])
				{
					case 1:
						put_field( "cellphone57.png" , "<a class='tel_link' href='tel:".$Record['phone']."'>".$Record['phone']."</a>" );
						break;
					case 2:
						put_field( "phone25.png" , "<a class='tel_link' href='tel:".$Record['phone']."'>".$Record['phone']."</a>" );
						break;
				}
			}?>	
		</div>
	<?php
	}
}

function put_addresses_for_person($personid)
{
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

function put_comments_for_person($comments = "")
{
	if($comments != "")
	{?>
		<div class='Person_content'><?php
			put_Separating( "comments1.png" , "Σημειώσεις:" ); 
			put_field( "comments1.png" , $comments );
	?>	</div> <?php
	}
	else
		return NULL;
}

function get_string_of_aliases($personid)
{
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

?>