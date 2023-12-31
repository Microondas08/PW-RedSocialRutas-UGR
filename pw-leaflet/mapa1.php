<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Mapa Leaflet</title>
	 <script src="jquery-3.6.3.min.js"></script>
	 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
	     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
	     crossorigin=""/>
	 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
	     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
	     crossorigin=""></script>
	<style type="text/css">
		#map { 
				height: 500px; 
				width: 500px}
 	</style>
 	<script type="text/javascript">
 	$( document ).ready(function() { 	    
 	    var map = L.map('map').setView([51.505, -0.09], 13);
		
		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    maxZoom: 19,
		    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);
 	});	
 	</script>
 	
</head>
<body>

 <div id="map"></div>

</body>
</html>