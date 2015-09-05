<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/sel_persons.php');

function put_person($pid, $imageBase64, $sex, $name, $surname){
?><div class='Person'>
	<div id="pid<?php echo $pid; ?>" class="person_label">
		<div class="person_label_icon" style="background-image: url('<?php echo ($imageBase64 != NULL ? "data:image;base64,". $imageBase64 : "views/icons/businessman94.png") ?>');"></div>
		<div class="person_label_content"><b><?php
		echo ($name ? $name . " " : "... ") . ($surname ? $surname : "...") ;
		?></b>
		</div>
		<div class="person_label_tools">
			<div class="loader facebookG">
			<div id="blockG_1" class="facebook_blockG"></div>
			<div id="blockG_2" class="facebook_blockG"></div>
			<div id="blockG_3" class="facebook_blockG"></div>
			</div>
		</div>
	</div>
	<div class="Person_Container" style="display: none;"><!--*ajax*--></div>
  </div>
<?php
}

if( NULL != $records = get_persons( $userid, $items, $page )){
	for ( $row = 0; $row <= count( $records ); $row++ ) {
		if( $row != count( $records ) ){
			put_person( $records[$row]['personid'] , $records[$row]['imageBase64'] , $records[$row]['sex'] , $records[$row]['name'] , $records[$row]['surname'] );
		}
	}
}
else{
	$_SESSION['notice'] = "<b>persons.php:</b><br />No contacts found. To add new contacts press 'add contact'.";
}
?>