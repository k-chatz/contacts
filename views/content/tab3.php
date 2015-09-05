<?php //include_once('searchform.php'); ?>

<form id="downloadForm">
    <input type="hidden" name="cnf" value="<?php echo $confid ?>">
    <input type="hidden" name="act" value="download_file">
    fileId: <input type="text" name="fid" id="fid">
    <input type="submit" value="Ajax Request">
</form>
<div id="downloadRes"><!--Ajax response--></div>