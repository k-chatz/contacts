<div class="footer">
	<div class="copyright">
		<b>Mycnts © 2014 | Designed for mobile</b>
		<br />
		<sub>Script complete time: <?
			echo $microsecond;
			?>'', Queries: 
			<?
			if (isset($_SESSION['Queries'])) {
			echo $_SESSION['Queries'];
			//$_SESSION['Queries'] = 0;
			unset($_SESSION['Queries']); 

			} else
			echo "0";
			?>
		</sub>
	</div>
	<div>
		Icons made by Scott de Jonge from <a target="_blank" href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> -
		Css animations: <a target="_blank" href="http://cssload.net" title="Flaticon">cssload.net</a>
	</div>
</div>

</body>
</html>

