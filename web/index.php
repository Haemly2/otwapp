<!DOCTYPE html>
<html>

<head>
<script src="js/jquery-1.11.1.js"></script>
<script src="js/googleMaps.js"></script>
<script src="js/thingsjs"></script>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,400' rel='stylesheet' type='text/css'>
<script>
	$(document).ready(function(){
		//temp code cuz its too long to type
		$("#input").val("12345678901234567890");
		
		$("#go-button").click(function(){
			var code = $("#input").val();

			if(code.length != 20){
				$("#input-error").text("Code should be 20 alphanumeric characters");
			} else if( /[^a-zA-Z0-9]/.test(code)){
				$("#input-error").text("Invalid characters in code");
			} else{
				//TODO connect to php file
				$("#popout-background").fadeOut("slow");
			}
		});
		var dt = new Date();
		var dtHour = dt.getHours();
		if(dtHour > 12){
			dtHour -= 12;
		}
		var time = dtHour + ":" + dt.getMinutes();
		var i = 0;
		$("#wait").click(function(){
			if(i % 2 == 0){
				$("#event-content").append("<div class=\"event\">Wait requested at " + time + ".</div>");
			} else if(i % 2 != 0){
				$("#event-content").append("<div class=\"event2\">Wait requested at " + time + ".</div>");
			}
			i++;
		});
		
		$("#continue").click(function(){
			if(i % 2 == 0){
				$("#event-content").append("<div class=\"event\">Continue requested at " + time + ".</div>");
			} else if(i % 2 != 0){
				$("#event-content").append("<div class=\"event2\">Continue requested at " + time + ".</div>");
			}
			i++;
		});
		setHeight();
	});
	
	function setHeight(){
		//Set the size of the div to the percent of page remaining after the control
		//div is loaded so they scale well with no scroll bar.
		var height = $(document).height() - 3
		controlHeight = 64 + 3;
		var pageHeightWithoutControl = height - 64;
		var otherPercent = ((height - controlHeight) / height) * 100 + "%";
		$("#map-canvas").css("height",otherPercent); //set map and event content to the remainder
		$("#event-content").css("height",otherPercent);
	}
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8nP8zW5doATgHCBiJCaGe4r5cNeS1V1g&sensor=false">
 </script>
<script type="text/javascript">
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;

	function initialize() {
		directionsDisplay = new google.maps.DirectionsRenderer();
		var chicago = new google.maps.LatLng(41.850033, -87.6500523);
		var mapOptions = {
		zoom:7,
		center: chicago
	};
	map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	directionsDisplay.setMap(map);
}

	function calcRoute(){
		var request = {
			origin: "Sydney,NS",
			destination: "Toronto,ON",
			travelMode: google.maps.TravelMode.DRIVING,
			unitSystem: google.maps.UnitSystem.METRIC,
			//provideRouteAlternatives: Boolean,
			avoidHighways: false,
			avoidTolls: false
		};
		directionsService.route(request, function(result, status){
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(result);
			}
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>

</head>
<body>
	<div id="popout-background">
		<div id="popout">
			<div id="popout-description-text">
				Enter your code
			</div>
			<div id="input-container">
				<input type="text" id="input"/>
			</div>
			<div id="input-error"></div>
			<div id="go-button-container">
				<div id="go-button"><div id="go-inner-button-text">GO</div></div>
			</div>
		</div>
	</div>
	<div id="content-container" onmouseover="calcRoute()">
		<div id="control-content">
			<div id="control-label"><div id="control-label-text">Controls</div></div>
			<div id="button-cluster">
				<div id="wait" class="control-buttons"><div class="inner-button-text">Wait</div></div>
				<div id="continue" class="control-buttons"><div class="inner-button-text">Continue</div></div>
				<!--<div id="unused" class="control-buttons"><div class="inner-button-text">unused</div></div>
				<div id="unused" class="control-buttons"><div class="inner-button-text">unused</div></div>-->
			</div>
		</div>
		<div id="map-canvas">
		</div>
		<div id="event-content">
			<div id="event-title">
				event log
			</div>
		</div>
	</div>
</body>
</html>