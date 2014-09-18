
function echo_contact(output , post_data , pid ){
	var display = $(output).css( "display" ); 
	
	if(display == "none"){
		$("#Loader"+pid).fadeIn( "fast" );
		
		var className = $('.'+$(output).attr('class') );
		jQuery( className ).hide(); //Κρύβει όλα τα div που έχουν την ίδια κλάση με την output.
		$(className).html("");
				
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 )
			{
				if(xmlhttp.status == 200)
				{
					$(output).html( xmlhttp.responseText );
				}
				else
				{
					$(output).html( "<b style='color:red;'>Loading script failed:</b> check the internet connection and try again!" );
				}
				$("#Loader"+pid).fadeOut( "fast" );
				jQuery(output).show();
				
				//window.onload = loadScript;
				loadScript();
			}
			
			console.log("readyState: "+xmlhttp.readyState);
			console.log("status: "+xmlhttp.status);
		}
		xmlhttp.open("POST","view/ajax.php",true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// xmlhttp.setRequestHeader("Content-length", post_data.length); //Console error!
		// xmlhttp.setRequestHeader("Connection", "close");	//Console error!
		xmlhttp.send(post_data);
	}else
	  
		jQuery(output).hide();  
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
		jQuery(div).show();
	}else
		jQuery(div).hide();
}

function fix_height(left,right){
	var R = $(right).height();
	//alert(R);
	$(left).css("height", R);
}

jQuery(document).ready(function(){
	jQuery('.T').hide();
	jQuery('.SUBT').hide();
	
	activetab(1,'.T:first');
	activetab(1,'.SUBT:first');
	jQuery("#container li").click(function()
	{
		var activeTab = jQuery(this).attr("id"); 

		if( activeTab == "#T1" || activeTab == "#T2" || activeTab == "#T3" )
			jQuery(".T").hide();
		else
			jQuery(".SUBT").hide();

		activetab(1,activeTab);
		return false; //Για να μην "κλωτσάει προς τα πάνω η οθόνη όταν πατάμε το link.
	});
}); 