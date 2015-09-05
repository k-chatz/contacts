<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/Contacts/models/content/sel_persons.php');

$items = get_option( "items_per_page", $userid );
$items = $items ? $items : 5;
$contacts = get_person_count( $userid );
$pages = ($contacts ? $contacts : 1) / $items;

if (!$pages) $pages = 1;
if ( $pages - round( $pages ) > 0 )
    $pages = round( $pages ) + 1;
else
    $pages = round( $pages );
	
?>
<div id="itm" style="display: none;"><?php echo $items; ?></div>

<div id="ajaxPersons"><!--*Ajax*--></div>

<div class="pagination">
    <div class="page_loader">
        <?php include('views/animations/page_loader.php'); ?>
    </div>
    <a href="#" class="first" data-action="first" style="background-image: url('views/icons/previous2.png')" /></a>
    <a href="#" class="previous" data-action="previous" style="background-image: url('views/icons/left207.png')" ></a>
    <input id="pagination_max" type="text" readonly="readonly" data-max-page="<?php echo $pages; ?>" />
    <a href="#" class="next" data-action="next" style="background-image: url('views/icons/right218.png')"></a>
    <a href="#" class="last" data-action="last" style="background-image: url('views/icons/next.png')"></a>
</div>
