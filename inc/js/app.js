
// Variable stockant l'url/source du fichier geojson
var url = "carto.geojson";

// Variable de la map
var map = L.map('map', {
    minZoom: 7,
    maxZoom: 17
});
        
map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]);
// On initialise map 
var osm = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ 
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);

// Options du marker
var  OptionsMarkers = {
    'radius':6,
    'opacity': .5,
    'color': "blue",
    'fillColor':  "blue",
    'fillOpacity': 0.4
};


// Pour chaque marker , on va récuperer ces données et les faires appaitre dans une popup
function forEachFeature(feature, marker) 
{
	var ContenuePopup = "<b>" +
            feature.properties.name + "</b></br>" +
            feature.properties.organisme + "</br>" +
            feature.properties.ville + "</br>" +
            feature.properties.telephone + "</br>";
    
        if (feature.properties && feature.properties.ContenuePopup) {
            ContenuePopup += feature.properties.ContenuePopup;
        }
	marker.bindPopup(ContenuePopup);
};




// Récupère les données du fichier GeoJSON et crée chaque marker.
$.getJSON(url, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}});
    var markerCluster = L.markerClusterGroup();
    points.addTo(markerCluster);
    markerCluster.addTo(map);
});

