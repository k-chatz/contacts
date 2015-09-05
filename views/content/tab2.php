<form id="uploadForm" enctype="multipart/form-data" method="POST" action="controllers/ajax.php">
    <input type="hidden" name="cnf" value="<?php echo $confid ?>">
    <input type="hidden" name="act" value="upload_file">

    <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
    <input type="file"   name="file"  id="userfile"> 
    <input type="submit" name="upload"  class="box" id="upload" value=" Upload ">
</form>

<div id="uploadRes"><!--Ajax response--></div>