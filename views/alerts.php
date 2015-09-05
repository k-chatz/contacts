<?php
function alert( $message, $type = "Notice" ){
	?>
		<div id="<?php echo $type ?>" onclick="hide(this)">
			<div class="alert_icon">
				<img src="<?php echo rootPath( "views/icons/". $type .".png") ?>" alt="Alert icon" height="24" />
			</div>
			<div class="alert_content"><?php echo "<b>". $type ." message:</b> <pre class=\"alert\">". (!empty($message) ? $message : "alerts.php: Empty message!" ) . "</pre>"; ?></div>
		</div>
	<?php
}

function session_alert()
{
	if(isset($_SESSION['notice']))
	{
		alert( $_SESSION['notice'] );
		unset($_SESSION['notice']);
	}

	if(isset($_SESSION['success']))
	{
		alert( $_SESSION['success'] , "Success" );
		unset($_SESSION['success']);
	}

	if(isset($_SESSION['warning']))
	{
		alert( $_SESSION['warning'] , "Warning" );
		unset($_SESSION['warning']);
	}

	if(isset($_SESSION['error']))
	{
		alert( $_SESSION['error'] , "Error" );
		unset($_SESSION['error']);
		//header("HTTP/1.0 400 Bad Request");
	}
}
?>