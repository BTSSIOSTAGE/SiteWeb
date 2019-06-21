
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
map.setView([-21.136998,55.51512], 5); // Coordonée ou la map va se recentré ( Ile de la reunion )
map.bounds = [],
map.setMaxBounds([
    [-20.636998,56.05000],
    [-21.536998,55.00212]
]); 


var marker = L.marker([0, 0]).addTo(map);

map.on('click', function(e) 
{

    var lat = e.latlng.lat.toFixed(5);
    var lon = e.latlng.lng.toFixed(5);

    marker.setLatLng([lat, lon]);

    document.getElementById('latInput').value = lat;
    document.getElementById('lonInput').value = lon;
    document.getElementById('nomorganisme').value = '';
    document.getElementById('adresse1').value = '';
    document.getElementById('adresse2').value = '';
    document.getElementById('ville').value = '';
    document.getElementById('cp').value = '';
    
    document.getElementById('status').innerHTML = '';
    
    document.getElementById('btnSave').onclick = AddDbOrganisme;
    
    function AddDbOrganisme() 
    {

        var latInput = document.getElementById('latInput').value;
        var lonInput = document.getElementById('lonInput').value;

        var nom = document.getElementById('nomorganisme').value;
        var adresse1 = document.getElementById('adresse1').value;
        var adresse2 = document.getElementById('adresse2').value;
        var ville = document.getElementById('ville').value;
        var cp = document.getElementById('cp').value;
        console.log('Fonction lancé!');
        console.log(latInput,lonInput,nom,adresse1,adresse2,ville,cp);
        $.post('./addOrganismetoDb.php',
        {
            lat: latInput,
            lon: lonInput,
            nom: nom,
            adr1: adresse1,
            adr2: adresse2,
            ville: ville,
            cp : cp

        },
        function(data) 
        {
            if (data === 'success')
            {
                document.getElementById('nom').value = '';
                document.getElementById('adresse1').value = '';
                document.getElementById('adresse2').value = '';
                document.getElementById('ville').value = '';
                document.getElementById('cp').value = '';
                document.getElementById('status').innerHTML = 'Organisme enregistré avec succés!';
            } else {
                document.getElementById('status').innerHTML = 'Erreur!';
                console.log(latInput,lonInput,nom,adresse1,adresse2,ville,cp);
         }
    }
    );
    }

});



