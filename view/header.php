<div class="header">
	<div class="bar">
		<a class="logo" href="index.php"><img height="22" src="view/images/group44.png" style="-webkit-filter: invert(100%);"></a>
		<?php
			if( isset($_SESSION['username']) && isset($_SESSION['userid']) ) 
			{
				echo "
				<a class='btn' href='index.php?settings'>".$_SESSION['username']."</a>
				<a class='btn' href='index.php?logout'>Αποσύνδεση</a>
				";
			}
			else
			{
				echo "
				<a class='btn' href='index.php?register'>Εγγραφή</a>  
				<a class='btn' href='index.php?login'>Σύνδεση</a>
				";
			}
			?>
	</div>
</div>