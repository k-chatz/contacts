
<div class="header">
	<div class="bar">
		<a class="logo" href='index.php<?php echo $confid ? "?cnf=".$confid : ""; ?>'><img height="22" src="view/images/group44.png" alt="Contacts logo" style="-webkit-filter: invert(100%); filter: invert(100%);"></a>
			<?php
			if( isset($_SESSION['username']) && isset($_SESSION['userid']) ) {
			?>
				<a class="btn" title="Account management" href='index.php<?php echo $confid ? "?cnf=".$confid : ""; ?>&p=settings'><?php echo $_SESSION['username']; ?></a>
				<a class="btn" href='index.php?<?php echo $confid ? "cnf=".$confid : ""; ?>&p=logout'>Logout</a>
			<?php
			}else{
			?>
				<a class="btn" href="index.php?p=register">Register</a>  
				<a class="btn" href="index.php?p=login">Login</a>
			<?php
			}
			?>
	</div>
</div>