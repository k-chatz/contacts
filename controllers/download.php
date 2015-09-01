<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/select.php');

if( NULL != $records = downloadFile($userid, $fileId, $fileName)){

	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid))) {
	    mkdir($_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid), 0777, true);
	}

	$file = $_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid) ."/". $records[0]['name'];

	if ( !$fp = fopen($file, "wb")){
		$_SESSION['error'] = "<b>download.php:</b><br>Err:: Cannot open file ($file)";
	}
	else{
		if (fwrite($fp, $records[0]['content']) === FALSE) {
		    $_SESSION['error'] = "<b>download.php:</b><br>Err:: Cannot write to file ($file)";
		}
		else{
			$_SESSION['success'] = "<b>download.php:</b><br>The file '" . $records[0]['name'] . "' is ready for <a target=\"_blank\" href=\"views/user/temp/". md5($userid) ."/". $records[0]['name'] ."\" title=\"File\">download</a>!";
		}
		fclose($fp);
	}
}
else{
	$_SESSION['error'] = "<b>download.php:</b><br>Err:: Could not find the requested file!";
}

?>
