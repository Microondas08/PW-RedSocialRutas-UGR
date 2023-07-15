<html>
<head>
<script src="../js/jquery-3.6.3.min.js"></script>
<link rel="stylesheet" href="../dist/leaflet.css" />
<script src="../dist/leaflet.js"></script>
<script src="../dist/gpx.min.js"></script>

<style  type="text/css">
    #map-container {
        height: 500px;
        width: 500px
    }
</style>

<script>

$( document ).ready(function() {    
    var map = L.map("map-container").setView([35.896, -5.29], 14);
    L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
        attribution: "Map data &copy; <a href='http://www.osm.org'>OpenStreetMap</a>"
    }).addTo(map);

<?php 
$url_base = "/RedSocialRutas/maps/";
$gpx_file = "Camino_Natural_Pasarelas.gpx";
?>
 const gpxPath = '<?php echo $url_base . $gpx_file ?>'
    new L.GPX(gpxPath, { async: true }).on("loaded", function (e) {
        map.fitBounds(e.target.getBounds());
    }).addTo(map);
});
</script>
</head>
<body>
<div id="map-container" ></div>
</body>
</html>
