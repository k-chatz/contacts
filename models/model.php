<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ob_start();

function rootPath($path = ""){
	$root = "/Contacts/";
	return $_SERVER['REQUEST_SCHEME']."://".($_SERVER['SERVER_NAME'] == "::1" ? "localhost" : $_SERVER['SERVER_NAME'] ).":".$_SERVER['SERVER_PORT'].$root.$path;
}

function redirect($location, $debug = 0){
	$nextLocation = rootPath() . $location;
	if($debug){
	    dump($_SESSION , "SESSION");
	    echo "<br />Manually redirect to <a href=". $nextLocation ." \"title=\"index\">". $nextLocation ."</a>";
	}
	else
	    header("Location: ". $nextLocation);
}

function get_string_of_streets_from_address($address){
	$streets = "";
	$i       = 0;
	
	if($address['streets'])
	{
		foreach ($address['streets'] as $value)
			$streets .= ($i++ > 0 ? " & " : " ") . $value['street'] . " " . $value['number'];
		return $streets;
	}
	else
		return NULL;
}

function get_string_of_full_address($address)
{
	return "" . get_string_of_streets_from_address($address) . ", " . $address['location'] . ", " . $address['city'] . ", " . $address['region'] . ", " . $address['country'] . ", " . $address['comments'] . "";
}

function mail_utf8($to, $subject = '(No subject)', $message = "")
{
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
	$headers .= "To: <" . $to . ">" . "\r\n";
	$headers .= "From: MyCnts <mycnts@projects.codescar.eu>" . "\r\n";
	return mail($to, "=?UTF-8?B?" . base64_encode($subject) . "?=", $message, $headers);
}

/*From google search...*/
function client_ip(){
    if( !empty( $_SERVER['HTTP_X_FORWARED_FOR'] ) )
        $ip = $_SERVER['HTTP_X_FORWARED_FOR'];
    else if ( !empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
}

function removeDir($dir){
	//dump($dir);
	/*From: http://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it*/
	$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
	foreach($files as $file) {
	    if ($file->isDir()){
	    	//dump($file,"Remove dir");
	        rmdir($file->getRealPath());
	    } else {
	    	//dump($file,"Remove file");
	        unlink($file->getRealPath());
	    }
	}
	rmdir($dir);
}

?>
