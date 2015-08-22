<?php
function alert( $message, $type = "info" ){
$imgPath = path("/contacts/view/icons/".($type == "info" ? "ok4.png" : "error6.png"));
	?>
		<div id="<?php echo ($type == "info") ? "info" : "warning"; ?>" onclick="hide(this)">
			<div class="alert_icon">
				<img src="<?php echo $imgPath ?>" alt="Alert icon" height="24" />
			</div>
			<div class="alert_content"><?php echo ($message ? $message : "alerts.php: Empty message!"); ?></div>
		</div>
	<?php
}

function session_alert()
{
	if(isset($_SESSION['info']))
	{
		alert( $_SESSION['info'] );
		unset($_SESSION['info']);
	}
	if(isset($_SESSION['warning']))
	{
		alert( $_SESSION['warning'] , "warning" );
		unset($_SESSION['warning']);
	}
}
?>