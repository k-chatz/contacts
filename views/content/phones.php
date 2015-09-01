<?php
function put_phones_for_person($personid)
{
	if (NULL != $Records = get_phones(0, $personid))
	{
	?><div class="Person_content"><?php
			put_Separating( "phone45.png" , "Phones:" );
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
?>