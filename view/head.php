<!DOCTYPE html>
<html>
	<head>
		<title>MyCnts</title>
		<meta charset="UTF-8">
		<meta http-equiv="refresh" content="300">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link rel="stylesheet" type="text/css" href="view/css/style.css">
		<link rel="stylesheet" type="text/css" href="view/css/loader.css">
		<link rel="stylesheet" type="text/css" href="view/css/map.css">
		<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> -->
		 
		<!-- <script src="view/js/jquery.min.js"></script> -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="view/js/code.js"></script>
		
		<script>
		function initialize() {
		
		console.log("initialize");

		  var mapOptions = {
			zoom: 8,
			center: new google.maps.LatLng(-34.397, 150.644)
		  };

		  var map = new google.maps.Map(document.getElementById('map-canvas'),
			  mapOptions);
		}

		function loadScript() {
		
		console.log("loadScript");
		
		  var script = document.createElement("script");
		  script.type = "text/javascript";
		  script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyBnpbNT-cXcdsUM4TY8gxPpqQIKac3qydc&sensor=false&callback=initialize";
		  setTimeout(function () {
				try{
					if (!google || !google.maps) {
						console.log("google is not defined");
						//This will Throw the error if 'google' is not defined
					}
				}
				catch (e) {
					//You can write the code for error handling here
					//Something like alert('Ah...Error Occurred!');
				}
			}, 5000);
		  document.body.appendChild(script);
		}
		</script>
	</head>
	<body>