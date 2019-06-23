//-----------------------------------------Liste des variable--------------------------------------
//________________VAR FICHIER GEOJSON _______________________________
// Variable stockant l'url/source du fichier geojson
var formations = "./inc/geo/cmqbatiment/formation.geojson";


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
                            
                            



//-----------------------------------------Setup Map--------------------------------------

map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]);

var marker = L.marker([0, 0]).addTo(map);

map.on('click', function(e) {

    var lat = e.latlng.lat.toFixed(5);
    var lon = e.latlng.lng.toFixed(5);

    marker.setLatLng([lat, lon]);

    document.getElementById('latInput').value = lat;
    document.getElementById('lonInput').value = lon;
    document.getElementById('nameInput').value = '';
    document.getElementById('status').innerHTML = '';
    
    function saveToDb() 
    {

        var latInput = document.getElementById('latInput').value;
        var lonInput = document.getElementById('lonInput').value;
        var nameInput = document.getElementById('nameInput').value;
        console.log('Fonction lancé');

        $.post('writePointsToDb.php',
        {
            lat: latInput,
            lon: lonInput,
            name: nameInput
        },
            function(data) 
            {
                console.log('dans la fonction');
                if (data === 'success') 
                {
                    document.getElementById('latInput').value = '';
                    document.getElementById('lonInput').value = '';
                    document.getElementById('nameInput').value = '';
                    document.getElementById('status').innerHTML = 'Saving successful!';

               } else {
                    document.getElementById('status').innerHTML = 'Error!';
                }
            }
        );

    }
    document.getElementById('btnSave').onclick = saveToDb;

});