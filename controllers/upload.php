<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/insert.php');

/* 
 * Comment at php.net manual. 
 * Url: http://php.net/manual/en/features.file-upload.errors.php.
 * This code is a fixed version of a note originally submitted by (Thalent, Michiel Thalen) on 04-Mar-2009
*/
function codeToMessage($code){ 
    switch ($code){
        case UPLOAD_ERR_INI_SIZE: 
            $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
            break;
        case UPLOAD_ERR_FORM_SIZE: 
            $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
            break;
        case UPLOAD_ERR_PARTIAL: 
            $message = "The uploaded file was only partially uploaded"; 
            break;
        case UPLOAD_ERR_NO_FILE: 
            $message = "No file was uploaded"; 
            break;
        case UPLOAD_ERR_NO_TMP_DIR: 
            $message = "Missing a temporary folder"; 
            break;
        case UPLOAD_ERR_CANT_WRITE: 
            $message = "Failed to write file to disk"; 
            break;
        case UPLOAD_ERR_EXTENSION: 
            $message = "File upload stopped by extension"; 
            break;
        default:
            $message = "Unknown upload error"; 
            break;
    }
    return $message;
}

if($debug){
	/*Head of the page*/
	include_once ($_SERVER['DOCUMENT_ROOT'] . '/Contacts/views/building/head.php');
	dump($_FILES,"Files");
}

if(isset($_FILES)){
	$error = $_FILES['file']['error'];
	if(isset($_POST['upload']) && $_FILES['file']['size'] > 0){

			$fileName = $_FILES['file']['name'];

		 	$type = pathinfo( $_FILES['file']['tmp_name'], PATHINFO_EXTENSION);
		 	$data = file_get_contents( $_FILES['file']['tmp_name'] );

			/*The file will be save as base64 encode.*/
		 	$content = base64_encode($data);

			if(!get_magic_quotes_gpc()){
			    $fileName = addslashes($fileName);
			}

			if( uploadFile($userid, $fileName, $_FILES['file']['size'], $_FILES['file']['type'], $content) ){
				$_SESSION['success'] = ($debug ? "<b>upload.php:</b><br />" : "") . "File '$fileName' was uploaded successfully at the database.";
			}
	}
	else{
		$_SESSION['error'] = ($debug ? "<b>upload.php:</b><br />" : "") . "The file was rejected because: " . codeToMessage($error);
	}
}
?>
