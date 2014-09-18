<?
if (NULL != ($Records = get_persons_for_user($userid))) 
{
	for ($row = 0; $row < count($Records); $row++)
	{
	?><div class='Person'>																												
		<div id="pid<? echo $Records[$row]['personid'] ?>" class="Person_close" onclick="echo_contact( $(this).next() , '<? echo http_build_query( $Records[$row] ) ?>' , <? echo $Records[$row]['personid'] ?> )"> 
			<!-- <a href="#pid<? //echo $Records[$row]['personid'] ?>"></a>  Εμφανίζει προβλήματα συνχρονισμού με τη φόρτωση του script--> 
			<div class="Person_close_icon">
				<img height="22" src="view/images/<? echo ($Records[$row]['sex'] == "male") ? "user62.png" : "female9.png" ?>"/> 
			</div>
			<div class="Person_close_content">
				<b><? echo $Records[$row]['name'] . " " . $Records[$row]['surname'] //$Records[$row]['personid'] . " | " .?></b>
			</div>
			<div class="Person_close_tools">
				<? include('animations/loader.php'); ?>
				<!-- <img height="22" src="view/images/tools3.png"/>  -->
			</div>			
		</div>
		<div class="Person_Container" style="display: none;">
		<!--Εδώ το περιεχόμενο φορτώνεται μόνο με ajax. 
		Τη φόρτωση του την αναλαμβάνει το αρχείο ajax.php ανάλογα με 
		τις παραμέτρους που πήρε.
		-->
		</div>
	  </div>
	<?}
}
?> 