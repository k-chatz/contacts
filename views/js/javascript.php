<?php header("Content-type: application/javascript"); ?>
<script>
	$(function() 
	{
		$( "#progressbar" ).progressbar({
			value: <?php echo $_SESSION ?>
	});
	
	alert("Test");
	
</script>