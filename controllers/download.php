<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/select.php');

if( NULL != $records = downloadFile($userid, $fileId, $fileName)){

	if (!file_exists($_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid))) {
	    mkdir($_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid), 0777, true);
	}

	$file = $_SERVER['DOCUMENT_ROOT']."/Contacts/views/user/temp/". md5($userid) ."/". $records[0]['name'];

	/*Open binary file for write at user temp folder*/
	if ( !$fp = fopen($file, "wb")){
		$_SESSION['error'] = ($debug ? "<b>download.php:</b><br />" : "") . "Err:: Cannot open file ($file)";
	}
	else{

		/*Decode from base64 to original format*/
		$base64 = $records[0]['content'];
		
		$content = base64_decode($base64);

		if($content !== false){

			/*Save content at user temp folder to be able download file.*/
			if (fwrite($fp, $content) === FALSE) {
			    $_SESSION['error'] = ($debug ? "<b>download.php:</b><br />" : "") . "Err:: Cannot write to file ($file)";
			}
			else{
				$_SESSION['success'] = ($debug ? "<b>download.php:</b><br />" : "") . "The file '" . $records[0]['name'] . "' is ready for <a target=\"_blank\" href=\"views/user/temp/". md5($userid) ."/". $records[0]['name'] ."\" title=\"File\">download</a>!";
			}
		}
		else{
			$_SESSION['error'] = ($debug ? "<b>download.php:</b><br />" : "") . "Err:: Decode failure!";
		}
	}
	fclose($fp);
}
else{
	$_SESSION['error'] = ($debug ? "<b>download.php:</b><br />" : "") . "Err:: Could not find the requested file!";
}

?>
