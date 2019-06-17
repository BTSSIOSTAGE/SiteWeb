//-----------------------------------------Liste des variable--------------------------------------
//________________VAR FICHIER GEOJSON _______________________________
// Variable stockant l'url/source du fichier geojson
var bacpro = "./inc/geo/bacpro.geojson";
var bts = "./inc/geo/bts.geojson";
var cap = "./inc/geo/cap.geojson";
var bp = "./inc/geo/bp.geojson";
var divers = "./inc/geo/divers.geojson";
//__________________________________________________________________   




//________________VAR MAP _________________________________________________________________________________
// Variable de la map
var map = L.map('map', 
{
    minZoom: 9,
    maxZoom: 22
});
// On initialise map 
var osm = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ 
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
//________________________________________________________________________________________________________________                             
                            
                            

//________________GROUPE POUR CLUSTER __________________ 
var Groupe = new L.markerClusterGroup().addTo(map);

var gbts = L.featureGroup.subGroup(Groupe).addTo(map);
var gbacpro = L.featureGroup.subGroup(Groupe).addTo(map);
var gcap = L.featureGroup.subGroup(Groupe).addTo(map);
var gbp = L.featureGroup.subGroup(Groupe).addTo(map);
var gdivers = L.featureGroup.subGroup(Groupe).addTo(map);
//__________________________________________________________________        



//________________GROUPE DE LAYERS (BTS , CAP ...)__________________ 
var lbacpro = L.layerGroup().addTo(map);
var lbts = L.layerGroup().addTo(map);
var lcap = L.layerGroup().addTo(map);
var lbp = L.layerGroup().addTo(map);
var ldivers = L.layerGroup().addTo(map);
//__________________________________________________________________ 

// Options du marker
var  OptionsMarkers = {
    'radius':15,
    'opacity': .5,
    'color': "blue",
    'fillColor':  "blue",
    'fillOpacity': 0.4
};

var basemapControl = {
  //"My Basemap": osm// an option to select a basemap (makes more sense if you have multiple basemaps)
};

var layerControl = {
  "Bac Pro": lbacpro, 
  "Bp": lbp, 
  "Cap": lcap, 
  "Bts": lbts, 
  "Divers": ldivers 
};

//-----------------------------------------Setup Map--------------------------------------

map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]);




//-----------------------------------------Listes fonctions--------------------------------------

// Pour chaque marker , on va récuperer ces données et les faires appaitre dans une popup
function forEachFeature(feature, marker) 
{
	var ContenuePopup = "<b>" +
            feature.properties.name + "</b></br>" +
            feature.properties.organisme + "</br>" +
            feature.properties.ville + "</br>" +
            feature.properties.téléphone + "</br>";
    
        if (feature.properties && feature.properties.ContenuePopup) {
            ContenuePopup += feature.properties.ContenuePopup;
        }
	marker.bindPopup(ContenuePopup);

};




//----------------------------------------- Chargement des fichiers + placements des données --------------------------------------

//_______________________________________________________BAC PRO________________________________________________
$.getJSON(bacpro, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}});
    points.addTo(gbacpro);
    lbacpro.addLayer(gbacpro);
});

//_________________________________________________________BTS________________________________________________
$.getJSON(bts, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}});
    points.addTo(gbts);
    lbts.addLayer(gbts);

});

//_________________________________________________________BP________________________________________________
$.getJSON(bp, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}});   
    points.addTo(gbp);   
    lbp.addLayer(gbp);   
});


//_________________________________________________________CAP________________________________________________
$.getJSON(cap, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}});   
    points.addTo(gcap);
    lcap.addLayer(gcap);       
});

//_________________________________________________________DIVERS________________________________________________

$.getJSON(divers, function(geojson) 
{
    var points = L.geoJSON(geojson, {onEachFeature: forEachFeature, pointToLayer: function (feature, latlng) {return L.circleMarker(latlng, OptionsMarkers);}}); 
    points.addTo(gdivers);
    ldivers.addLayer(gdivers);    
});


L.control.layers(basemapControl, layerControl).addTo(map);