<?php include_once('searchform.php'); ?>

<form id="downloadForm">
    <input type="hidden" name="cnf" value="<?php echo $confid ?>">
    <input type="hidden" name="act" value="download_file">
    filename: <input type="text" name="fn">
    fileId: <input type="text" name="fid"> 
    <input type="submit" value="Synchronous Request">
</form>
<div id="downloadRes"><!--Ajax response--></div>