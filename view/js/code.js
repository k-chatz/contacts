function ajax(data, resElem){
	return $.ajax({ type: "POST", url: "model/content/ajax.php", data: data, dataType: "html",
		success: function(response){ $(resElem).html(response); }}
	);
	request.fail(function(jqXHR, textStatus){
	  alert( "Request failed: " + textStatus);
	});
}

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

	/*Όταν ο χρήστης πατάει για να εισάγει μια νέα επαφή.*/
	$( "#add-btn" ).on( "click", add_person);	

	/*Όταν ο χρήστης πατάει για να ανοίξει μια επαφή.*/
    jQuery( '#ajaxPersons' ).on( "click", ".person_label", get_person );
	

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

    /* 
	swipeleft - swiperight
    As soon as JQuery Mobile will be available, uncomment this
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

    /*Αν έχει δοθεί κωδικός cnf στη σελίδα τότε γίνονται τα ajax.*/
	if( jQuery( '#cnf' ).length ){
    	change_page(1);
	}
});

function get_person() {
	var cnf = $( '#cnf' ).html(); 	//index.php
	var pid = $( this ).attr( "id" );
	pid = pid.substring( "pid".length );
    var loader	= $( '#pid'+pid+' > .person_label_tools > .loader' );
	var isActive = $( this ).next().css("display") != "none" ;

    if (isActive){
		/*
		 Αν τα στοιχεία της επαφής είναι ορατά, τότε να γίνουν αόρατα.
		*/
		$( '.Person_Container' ).css("backgroundColor", "#black");
		$( '.Person_Container' ).slideUp();
        $( this ).next().html( '' ).slideUp( function(){
			$( '.person_label' ).removeClass( "person_label_active" );
		});
    }
    else
    {
	    /*
	     Αν τα στοιχεία της επαφής δεν είναι ορατά τότε να γίνει ajax request και να
	     εμφανιστεί η απάντηση, δηλαδή τα στοιχεία.
	    */
		$( '.person_label' ).removeClass( "person_label_active" );
		loader.show();

		var person = $( '#pid' + pid ).next();
		request = ajax( { act: "get_person", cnf: cnf , pid: pid } , person );
		request.done(function(msg){ $( person ).slideDown('slow', function(){ loader.hide(); }); });
		$( this ).addClass( "person_label_active" );
		$( '.Person_Container' ).slideUp();
	}
}

function change_page( PG ) {
	var cnf = $( '#cnf' ).html();	//index.php
	var itm = $( '#itm' ).html();	//tab1.php
    var loader = $( '.pagination > .page_loader > .loader_bowlG' );
	loader.show();
	request = ajax({ act: "get_persons", cnf: cnf , pg: PG ,itm: itm }, "#ajaxPersons" );
	request.done(function(msg){ loader.hide(); });

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
	data = { act: "add_person", cnf: $( '#cnf' ).html() };
	request = ajax( data , "#ajaxPersons");
	request.done(function(msg){ /*Success code here*/ });
	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});
}