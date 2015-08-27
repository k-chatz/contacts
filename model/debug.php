<?php
include_once('plugins/SqlFormatter.php');

function getSourceCode($function = "")
{
	/*
	(Plugin)
	Source code from here: 
	https://gist.github.com/engine-andre/5772769
	*/
	$func = new ReflectionFunction($function);
	$filename = $func->getFileName();
	$start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
	$end_line = $func->getEndLine();
	$length = $end_line - $start_line;
	$source = file($filename);
	$body = implode("", array_slice($source, $start_line, $length));
	return $body; 
}

function getFunctionArgs($backtrace)
{
	$i      = 0;
	$string = "( ";
	foreach ($backtrace[0]['args'] as $value) {
		$string = $value ? $string . $value : $string . "\"\"";
		$string = ($i == count($backtrace[0]['args']) - 1) ? $string = $string . " )" : $string = $string . " , ";
		$i++;
	}
	return $string;
}

function showQuery($type, $backtrace, $host_info, $database, $sql, $rows, $affected_rows, $msc, $Result)
{
	switch ($type) 
	{
		case 'FETCH':
			$class = "qFetch";
			$CreditTitle = "<b>Result ". $rows ." records:</b>";
			break;
		case 'AFFECT':
			$class = "qAffect";
			$CreditTitle = "<b>Affected rows: ". $affected_rows .", Auto Increment ". $rows .":</b>";
			break;
		case 'FAILURE':
			$class = "qFailure";
			$CreditTitle = "<b>NOT executed because:</b>";
			break;
		default:
			$class = "qUnknown";
			$CreditTitle = "<b>Result:</b>";
			break;
	}
	$Queries = isset($_SESSION['Queries']) ? $_SESSION['Queries'] : 0;
?>
	<div class="<?php echo $class ?>">
		<div id="Qid<?php echo $Queries ?>" class="close" onclick="hide( $(this).next() )">
			<b>#<?php echo $Queries; ?>|T: <?php echo $msc ?>''|
				<span style="color:red">R:<?php echo $rows ? $rows : $affected_rows; ?></span>
				|F:<?php echo $backtrace[0]['function']; ?>
			</b>
		</div>
		<div class="qContent" style="display: none;">

			<div class="close" onclick="hide($(this).next())">
				<b>Function info:</b>
			</div>

			<div style='display: none;'>
				<pre><?php echo getSourceCode($backtrace[0]['function']); ?></pre>
				<hr style='border:1px solid black'>
				Called from file: <?php echo $backtrace[0]['file'] ?>
				<br />
				At line: <?php $backtrace[0]['line'] ?>
				<br />
				With args: <?php echo getFunctionArgs($backtrace)?>
			</div>

			Database: <?php echo $database ?> | Host: <?php echo $host_info ?>
			<?php echo  SqlFormatter::format($sql); ?>

			<div class="close" onclick="hide( $(this).next() )" >
				<?php echo $CreditTitle ?>
			</div>
			<pre class='qResult'><?php print_r($Result); ?></pre>
		</div>
	</div>
<?php
}

function dump( &$var , $description = "" , $output = 1 )
{
	if($output){
	$e = new Exception();
	$traces = $e->getTrace();
	?>
		<div class = "dumpBoxOutput">
			<code>
				&nbsp;Dump | Script: <?php echo basename($traces[0]['file']); ?>:
				<?php echo $traces[0]['line']; ?> | Description: <?php echo $description; ?>
				<br />
				<div class = "dumpBoxValue">
					<pre><?php is_array($var) ? print_r($var) : var_dump($var); ?></pre>
				</div>
			</code>
		</div>
	<?php
	}
	return $var;
}

function script_complete_time( $ms = 0 ){
$Queries = isset($_SESSION['Queries']) ? $_SESSION['Queries'] : 0;
	?>
		<div class="scriptTime"><b>
			Script complete time: <?php echo $ms; ?>'', 
			Queries: <?php echo $Queries; ?></b>
		</div>
	<?php
}
?>
