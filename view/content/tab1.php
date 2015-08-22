<?php
$items = get_option( "items_per_page", $userid );
$contacts = get_person_count( $userid );
$pages = ($contacts ? $contacts : 1) / ($items ? $items : 20);

if (!$pages) $pages = 1;
if ( $pages - round( $pages ) > 0 )
    $pages = round( $pages ) + 1;
else
    $pages = round( $pages );
	
?>
<div id="ITM" style="display: none;"><?php echo $items; ?></div>

<div id="toolbar-1" class="yui3-toolbar">
    <span id="add-btn" class="yui3-toolbar-button first-child"><input type="button" name="btn-add" value="Add"></span>
    <span id="edit-btn" class="yui3-toolbar-button"><input type="button" name="btn-edit" value="Edit"></span>
    <span id="delete-btn" class="yui3-toolbar-button"><input type="button" name="btn-delete" value="Delete"></span>
    <span id="save-btn" class="yui3-toolbar-button"><input type="button" name="btn-save" value="Save"></span>
</div>  

<div id="ajax_results"><!--*Ajax*--></div>

<div class="pagination">
    <div class="page_loader">
        <?php include('view/animations/page_loader.php'); ?>
    </div>
    <a href="#" class="first" data-action="first" style="background-image: url('view/icons/previous2.png')" /></a>
    <a href="#" class="previous" data-action="previous" style="background-image: url('view/icons/left207.png')" ></a>
    <input id="pagination_max" type="text" readonly="readonly" data-max-page="<?php echo $pages; ?>" />
    <a href="#" class="next" data-action="next" style="background-image: url('view/icons/right218.png')"></a>
    <a href="#" class="last" data-action="last" style="background-image: url('view/icons/next.png')"></a>
</div>