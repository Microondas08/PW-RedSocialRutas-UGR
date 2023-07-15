<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Mapa Leaflet</title>
	 <script src="jquery-3.6.3.min.js"></script>
	 <link rel="stylesheet" href="leaflet/leaflet.css" />
	 <script src="leaflet/leaflet.js" ></script>
	<style type="text/css">
		#map { 
				height: 500px; 
				width: 500px}
 	</style>
 	<script type="text/javascript">
 	$( document ).ready(function() {
 	    var map = L.map('map').setView([35.896, -5.29], 14);
		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    maxZoom: 19,
		    attribution: 'Programaci&oacute;n Web'
		}).addTo(map);
		//$('.leaflet-control-attribution').hide();
 	});	
 	</script>
 	
</head>
<body>

 <div id="map"></div>

</body>
</html>