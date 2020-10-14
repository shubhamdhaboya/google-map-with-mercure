<?php
	require 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dummy location tester</title>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?= $googleApiKey ?>&libraries=places&callback=initMap" defer></script>
	<style type="text/css">
		body {
			margin: 0px;
			padding: 0px; 
		}
		#map {
			height: 100vh;
			width: 100%;
		}
	</style>
</head>
<body>
	<div id="map"></div>
<script>
	var mapContainer;
	var map;
	var lat = parseFloat("<?= $lat ?>");
	var lng = parseFloat("<?= $lng ?>");
	var marker;

	function initMap() {
		mapContainer = document.getElementById('map');
		map = new google.maps.Map(mapContainer, {
            center: { lat, lng },
            zoom: 14
        });

        marker = new google.maps.Marker({
            map: map,
            animation: google.maps.Animation.DROP,
            anchorPoint: new google.maps.Point(0, -29),
            position: { lat, lng }
        });

        marker.addListener("click", function() {
            // open current agent marker info window
            map.setCenter({lat, lng});
            map.setZoom(14);
        });

        // connect to mercure
        const url = new URL("<?= $mercureURL ?>");
        url.searchParams.append("topic", "<?= $topic ?>");

        const es = new EventSource(url);
        es.onmessage = e => {
        	const data = JSON.parse(e.data);
			marker.setPosition(
        		new google.maps.LatLng(data.lat, data.lng)
			);
        }
	}
</script>
</body>
</html>