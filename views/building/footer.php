	<div class="footer">
		<div class="copyright">
			<b>Contacts | Designed for mobile</b>
			<br />
			<div id="credits">Script complete time: <?php
				echo number_format(microtime(true) - $ms, 2);
				?>'', Queries:
				<?php
				if (isset($_SESSION['Queries'])){
				echo $_SESSION['Queries'];
				unset($_SESSION['Queries']);
				} else
				echo "0";
				?>
				<div class="link">
					<br />Many thanks to <a target="_blank" href="http://www.codescar.eu/team/sudavar" title="Sudavar">Sudavar</a>
					at <a target="_blank" href="http://www.codescar.eu/" title="Codescar.eu">Codescar</a> team!<br />
					<br />Plugins: 
					<a target="_blank" href="http://mobiledetect.net/" title="mobile detect">Device check</a>,
					<a target="_blank" href="http://beneverard.github.io/jqPagination/" title="Pagination">Change pages</a>,
					<a target="_blank" href="http://www.colorzilla.com/gradient-editor/" title="Ultimate CSS Gradient Generator">Colors</a>,<br />
					<a target="_blank" href="http://www.flaticon.com" title="Flaticon">Icons</a>,
					<a target="_blank" href="http://cssload.net" title="css load">Css loaders</a>
					<a target="_blank" href="http://webapptester.com/html-jquery-tabs/" title="html-jquery-tabs">Tabs</a>,
					<a target="_blank" href="http://github.com/jdorn/sql-formatter" title="Sql formatter">Sql Format</a>
					<br />Source code:
					<a target="_blank" href="https://github.com/kwstarikanos/Contacts" title="GitHub Repository">GitHub</a>
					<br />Functions:
					<a href="?<?php echo $confid ? "cnf=".$confid."&" : ""; ?>debug=on" title="Debugging On">D:1</a> -
					<a href="?<?php echo $confid ? "cnf=".$confid."&" : ""; ?>debug=off" title="Debugging Off">D:0</a>

				</div>
			</div>
		</div>
	</div>
	</body>
</html>