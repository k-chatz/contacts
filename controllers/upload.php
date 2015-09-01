<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/insert.php');

if($debug){
	dump($_FILES,"Files");
}

if(isset($_FILES)){
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){

		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];

		$fp      = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);



		{
			/*Πρέπει να μπει συνθήκη ώστε η μετατροπή σε base64 να γίνεται μόνο αν το αρχείο είναι τύπου εικόνας.*/
			//$image = $tmpName;
			//$type = pathinfo($image, PATHINFO_EXTENSION);
			//$data = file_get_contents($image);
			//$dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
			//$content = $dataUri;
		}

		if(!get_magic_quotes_gpc()){
		    $fileName = addslashes($fileName);
		}

		if( uploadFile($fileName,$fileSize,$fileType,$content) ){
			$_SESSION['success'] = "<b>upload.php:</b><br>file '$fileName' was uploaded successfully.";
		}
		else{
			$_SESSION['error'] = "<b>upload.php:</b><br>There was a problem during the uploading file '$fileName'!";
		}
	}
	else{
		$_SESSION['error'] = "<b>upload.php:</b><br>There was a problem during the uploading file!";
	}
}
?>
