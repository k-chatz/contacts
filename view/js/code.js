jQuery(document).ready(function(){
	jQuery('.T').hide();
	jQuery('.SUBT').hide();
	
	activetab(1,'.T:first');
	activetab(1,'.SUBT:first');
	jQuery(".ultab li").click(function(){
		var activeTab = jQuery(this).attr("id"); 

		if( activeTab == "#T1" || activeTab == "#T2" || activeTab == "#T3" )
			jQuery(".T").hide();
		//else
			//jQuery(".SUBT").hide();

		activetab(1,activeTab);
		return false; //Για να μην "κλωτσάει προς τα πάνω η οθόνη όταν πατάμε το link.
	});

	$( "#add-btn" ).on( "click", add_person);	

	//Otan o xristis pataei na anoixei mia epafi
    jQuery( '#ajax_results' ).on( "click", ".person_label", get_person );
	
    var max_pages = jQuery( '#pagination_max' ).attr( 'data-max-page' );

    jQuery(document).keydown(function(event) {
        if ( event.which == 39) {
            // Right arrow pressed
            previous_page( max_pages );
        } else if (event.which == 37) {
            // Left arrow pressed
            next_page( max_pages );
        }
    });

    /* As soon as JQuery Mobile will be available, uncomment this
    jQuery( "body" ).on( "swiperight", function(){
        next_page( max_pages ); 
    });
    jQuery( "body" ).on( "swipeleft", function(){
        previous_page( max_pages );
    }); */
    
    jQuery( '.pagination' ).jqPagination({
		max_page	: max_pages,
		paged		: function( page ) {
			change_page( page );
		}
	});

	//Gia tin proti fora pou tha anoigei prepei na klithei i change_page(1)
	//gia emfanistei i proti selida.
    change_page( 1 );

    //jQuery( 'html' ).niceScroll( { cursorcolor : "#FFB530" } );
    //jQuery( "div[id^='ascrail']" ).show();
	
});

function get_person() {
	var CNF = $( '#CNF' ).html(); 	//ctrl
	var PID = $( this ).attr( "id" );
	
	PID = PID.substring( "pid".length );
    var loader	= $( '#pid'+PID+' > .person_label_tools > .loader' );
	
    if ( $( this ).next().css( "display" ) != "none" ) {		//An to Person_Container einai energo tote na klisei
		$( '.Person_Container' ).css("backgroundColor","#black");
		$( '.Person_Container' ).slideUp();
        $( this ).next().html( '' ).slideUp( function(){
			$( '.person_label' ).removeClass( "person_label_active" );
		});
    }else{														//An Person_Container den einai energo tote na ginei ajax kai na anoixei
		$( '.person_label' ).removeClass( "person_label_active" );
		loader.show();
		$.ajax( {
			type: "POST",
			url: "model/content/ajax.php",
			data: { act: "get_person", cnf: CNF , pid: PID },
			success: function( response ) {
				var person = $( '#pid' + PID ).next();
				$( person ).html( response );
				$( person ).slideDown('slow', function(){
					loader.hide();
				});
			}
		});
		$( this ).addClass( "person_label_active" );
		$( '.Person_Container' ).slideUp();
	}
}

function change_page( PG ) {
	var CNF = $( '#CNF' ).html();	//ctrl
	var ITM = $( '#ITM' ).html();	//tab1
    var loader = $( '.pagination > .page_loader > .loader_bowlG' );
	
	loader.show();
    var ajax = $.ajax({
		type: "POST",
		url: "model/content/ajax.php",
		data: { act: "get_persons", cnf: CNF , pg: PG ,itm: ITM },
		success: function( response ) {
            $( '#ajax_results' ).html( response );
            loader.hide();
        }
    });

    $( '.cnts_page' ).removeClass( "cnts_page_active" );
    $( this ).addClass( "cnts_page_active" );
}

function previous_page( max_pages ){
	//alert(max_pages);
    // Calculate current page
    var cur_page = jQuery( '#pagination_max' ).val();
    cur_page = parseInt( cur_page.substring(0).split(" ", 1) );
    // Are we in limits?
    if ( cur_page == max_pages )
        return;
    cur_page++;
    //Make the change
    change_page( cur_page );
    jQuery( '#pagination_max' ).val(""+cur_page + " - " + max_pages );
}

function next_page( max_pages ){
    // Calculate current page
    var cur_page = jQuery( '#pagination_max' ).val();
    cur_page = parseInt( cur_page.substring(0).split(" ", 1) );
    // Are we in limits?
    if ( cur_page == 1 )
        return;
    cur_page--;
    //Make the change
    change_page( cur_page );
    jQuery( '#pagination_max' ).val( ""+cur_page + " - " + max_pages );
} 

function activetab(active,element){
	if(active){
		jQuery(element).show();
	}else{
		jQuery(element).hide();
}};

function hide(div){
	var display = $( div ).css( "display" ); 
	console.log( display );
	if(display == "none"){
		/*Κλείσιμο όλων των div που έχουν την κλάση div*/
		var className = $('.'+$(div).attr('class') );//.split(' ').join('.'));
		jQuery(  className ).hide();
		/*Εμφάνιση του div που πάτησε ο χρήστης*/
		jQuery(div).slideDown();
	}else
		jQuery(div).slideUp();
}

function fix_height(left,right){
	var R = $(right).height();
	//alert(R);
	$(left).css("height", R);
}

function add_person(){
alert("function add_person");

 $( '#ajax_results' ).html( "<b>test</b>" );


}