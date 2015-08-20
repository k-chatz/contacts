<?php 
include_once('plugins/SqlFormatter.php');

function show_query($type, $debug, $host_info, $db_name, $sql, $rows, $msc, $Result)
{
	switch ($type) {
		case 1:
			echo "<div class='QSELECT'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'> <b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a>
			echo "<div class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code( $debug[0]['function'] ) ."</pre><hr style='border:1px solid black'>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo  SqlFormatter::format($sql);
			
			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Result " . $rows . " records:</b></div>";
			break;
		case 2: 
			echo "<div class='QINSERT'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'> <b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a> 
			echo "<div  class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code( $debug[0]['function'])."</pre><hr style='border:1px solid black'>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo SqlFormatter::format($sql);

			echo "<div class='close' onclick='hide( $(this).next() )' ><b>Auto Increment ".$rows." :</b></div>";
			break;
		case 3:
			echo "<div class='QERROR'>";
			echo "<div id='Qid".$_SESSION['Queries']."' class='close' onclick='hide( $(this).next() )'><b>Q:".$_SESSION['Queries']."|T:".$msc."''|<span style='color:red'>R:".$rows."</span>|F:".$debug[0]['function']."</b></div>"; //<a href='#Qid".$_SESSION['Queries']."'></a>
			echo "<div  class='QCONTENT' style='display: none;'>";
			
			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>Function info:</b></div>";
			echo "<div style='display: none;'><pre>". get_function_source_code($debug[0]['function'])."</pre><hr style='border:1px solid black'>Called from file: " . $debug[0]['file'] . "<br />At line: " . $debug[0]['line'] . "<br />With args: ".get_function_args($debug)."</div>";

			echo "Database: ".$db_name." | Host: ".$host_info."";
			echo SqlFormatter::format($sql);

			echo "<div class='close'  onclick='hide( $(this).next() )' ><b>NOT executed because:</b></div>";
			break;
	}
	
	//dumb($Result ,"Result");
	
	echo "<pre class='QRESULT'>";
	print_r($Result);
	echo "</pre>";
	echo "</div></div>";
}

function get_function_source_code($function = "")
{
	if($function)
	{
		$func = new ReflectionFunction($function);
		$filename = $func->getFileName();
		$start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
		$end_line = $func->getEndLine();
		$length = $end_line - $start_line;
		$source = file($filename);
		$body = implode("", array_slice($source, $start_line, $length));
		return $body; 
	}
	else
		return NULL;
}

function dump( &$var , $description = "" , $output = 1 )
{

	$s_debugoutput = "margin: 10px 5px 10px 5px;
	padding: 0px 5px 0px 5px;
	border-style: solid;
	border-width: 1px;
	border-color: rgba(255, 50, 17, 0.66);
	border-radius: 0.3em;
	background-color: rgba(30, 0, 0, 1);
	color: #FF0000;
	text-shadow: 0px 0px 5px #FF0000;
	-moz-box-shadow: 0px 0px 4px #FF0000;
	-webkit-box-shadow: 0px 0px 4px #FF0000;
	box-shadow: 0px 0px 4px #FF0000;
	word-wrap: break-word;";

	$s_debugvalue = "margin: 5px -6px 0px -6px;
	padding: 5px;
	background-color: rgba(0, 0, 0, 0.5);
	border-style: solid;
	border-width: 1px;
	border-color: rgba(255, 50, 17, 0.66);
	border-bottom-left-radius: 0.3em;
	border-bottom-right-radius: 0.3em;";

	

	$e = new Exception();
	$traces = $e->getTrace();
	if($output)
	{?>
		<div style="<?php echo $s_debugoutput; ?>">
			<code>
				Dump box |
				Script: <?php echo basename($traces[0]['file']); ?>:<?php echo $traces[0]['line']; ?> | Description: <?php echo $description; ?>
				<br />
				<div style="<?php echo $s_debugvalue; ?>">
					<pre><?php is_array($var) ? print_r($var) : var_dump($var); ?></pre>
				</div>
			</code>
		</div>
	<?php
	}
	return $var;
}

function get_function_args($debug)
{
	$i      = 0;
	$string = "( ";
	foreach ($debug[0]['args'] as $value) {
		$string = $value ? $string . $value : $string . "\"\"";
		$string = ($i == count($debug[0]['args']) - 1) ? $string = $string . " )" : $string = $string . " , ";
		$i++;
	}
	return $string;
}

function script_complete_time( $ms = 0 )
{
	if( $ms )
	{
		?>
			<br />
			<sub>Script complete time: <?php echo $ms; ?>'', Queries:
				<?php
				if (isset($_SESSION['Queries']))
				{
					echo $_SESSION['Queries'];
					unset($_SESSION['Queries']);
				}
				else
					echo "0";
				?>
			</sub>
		<?php
	}
	else
		return NULL;
}

?>