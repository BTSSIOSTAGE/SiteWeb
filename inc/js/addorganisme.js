$(document).ready(function(){
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




// Liste déroulante ville

var $listederou = $('#listeville');

$listederou.append('<option value="">Selectionnez ...</option>');
$.ajax(
{
        url: './inc/fonction.php?action=deroullistville',
        data: 'villes', 
        success: function(json) {
            json = JSON.parse(json);
            $.each(json, function(index, ville)
            {
                var action = "<option value='"+ville.cpdeville_id+"'>"+ ville['libelleville'] +" ("+ ville['cp_id'] +") </option>";
                $('#listeville').append(action);

            });
            console.log(json);

    }

});

// à la sélection de la localité un dans la liste
$listederou.on('change', function() {
    var val = $(this).val(); // on récupère la valeur de la localité un
    $('#cpdeville').val(val); 
    
});


var marker = L.marker([0, 0]).addTo(map); // Ajout d'un marker

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
    document.getElementById('cpdeville').value = '';
    document.getElementById('emailorganisme').value = '';
    document.getElementById('numerotel').value = '';
    
    document.getElementById('status').innerHTML = '';
    
    document.getElementById('btnSave').onclick = AddDbOrganisme;
   
    
    function AddDbOrganisme() // Renvoie les données
    {

        var latInput = document.getElementById('latInput').value;
        var lonInput = document.getElementById('lonInput').value;

        var nom = document.getElementById('nomorganisme').value;
        var adresse1 = document.getElementById('adresse1').value;
        var adresse2 = document.getElementById('adresse2').value;
        var intituleadresse = document.getElementById('intituleadresse').value;
        
        var email = document.getElementById('emailorganisme').value;
        var numtel = document.getElementById('numerotel').value;
        
        var cpdeville = document.getElementById('cpdeville').value;
        
        
        
        $.post('./addorg.php',
        {
            plat: latInput,
            plng: lonInput,
            pnom: nom,
            paddr1: adresse1,
            paddr2: adresse2,
            pcpdeville: cpdeville,
            pemail : email,
            pnumtel : numtel,
            pintitule : intituleadresse

        },
        function(data) // Insertion ok
        {
                document.getElementById('latInput').value = '';
                document.getElementById('lonInput').value = '';
                document.getElementById('nomorganisme').value = '';
                document.getElementById('adresse1').value = '';
                document.getElementById('adresse2').value = '';
                document.getElementById('cpdeville').value = '';
                document.getElementById('status').innerHTML = 'Organisme enregistré avec succés ! (Approbation demandé)';
                document.getElementById('emailorganisme').value = '';
                document.getElementById('numerotel').value = '';
                document.getElementById('intituleadresse').value = '';
   
         
        }
        );
    }

});

});




