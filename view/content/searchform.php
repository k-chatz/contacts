<form id='searchform' action='index.php' method='GET'>
	<input type='text' name='search'>                           
	<a onclick="document.getElementById('searchform').submit()"></a>
	<div class='clear'></div>
</form>
<?php include('results.php');?>