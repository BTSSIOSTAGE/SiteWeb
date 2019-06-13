<!DOCTYPE html>
<html>
<head>
	
	<title>GeoJSON tutorial - Leaflet</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js" integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA==" crossorigin=""></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<style>
		#map {
			width: 800px;
			height: 600px;
		}
	</style>

	
</head>
<body>

<div id='map'></div>

<script>
var url = "carto.geojson";

	var map = L.map('map').setView([-21.136998,55.51512], 9); 

	var osm=new L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{ 
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);

	var  geojsonMarkerOptions = {
        'radius':6,
		'opacity': .5,
		'color': "green",
		'fillColor':  "blue",
		'fillOpacity': 0.8
	};

	function forEachFeature(feature, layer) {
	
			var popupContent = "<b>" +
					feature.properties.name + "</b> \n </br>" +
					feature.properties.organisme + "</br>" +
                                        feature.properties.ville + "</br>" +
                                        feature.properties.telephone + "</br>"
                                         ;
							
			if (feature.properties && feature.properties.popupContent) {
				popupContent += feature.properties.popupContent;
			}
				layer.bindPopup(popupContent);
	};

	  var Fabriceleboos = L.geoJSON(null, {
			onEachFeature: forEachFeature, 
			pointToLayer: function (feature, latlng) {
				return L.circleMarker(latlng, geojsonMarkerOptions);
			}
	  });

	// Get GeoJSON data and create features.
 
        $.getJSON(url, function(data) {
			Fabriceleboos.addData(data);
		});
	
	
	Fabriceleboos.addTo(map);

</script>
</body>
</html>