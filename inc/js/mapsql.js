
$.post('./addpointmap.php',
    function(data) {
        if (data === 'connection error') {
            console.log('Error connecting to the database!');
        } else if (data === 'query error') {
            console.log('Error querying the database!');
        } 
         
    }
   ).done(function( data )
   {
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

        var gbacpro = L.featureGroup.subGroup(Groupe).addTo(map);
        var gbts = L.featureGroup.subGroup(Groupe).addTo(map);
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
        
        // Recupere donnée bdd en JSON
        data = JSON.parse(data);
        console.log(data);
        for (var i = 0; i < data.length; i++) 
        {
            var libelle_o = data[i]['libelle_o'];
            var rue1 = data[i]['rue1'];
            var rue2 = data[i]['rue2'];
            var lat = data[i]['lat'];
            var lng = data[i]['lng'];
            
            var libelle_f = data[i]['libelle_f'];
            var capacite = data[i]['capacite'];
            var niv_requis = data[i]['niv_requis'];
            var type = data[i]['type'];
            
            var cp  = data[i]['libellecp'];
            
            var libelleville = data[i]['libelleville'];
            var modalitesperecrutement = data[i]['modalite_spe_recrutement'];
            
            
            addOrganisme(lat,lng,type, libelle_o, rue1, rue2, cp , libelleville ,libelle_f,capacite,niv_requis,modalitesperecrutement);
                 
        }
        
        function addOrganisme(lat , lng , type, libelle_o, rue1, rue2, cp , libelleville , libelle_f,capacite,niv_requis,modalitesperecrutement){
            
            
            
            var organisme = L.circleMarker([lat, lng],OptionsMarkers);
            if(type === "BACPRO"){
                organisme.addTo(gbacpro); 
                lbacpro.addLayer(gbacpro); 
            } else if(type === "BTS"){
                organisme.addTo(gbts); 
                lbts.addLayer(gbts); 
            }else if(type === "BP") {
                organisme.addTo(gbp); 
                lbp.addLayer(gbp); 
            }else if(type === "CAP") {
                organisme.addTo(gcap); 
                lcap.addLayer(gcap); 
            }else{
               organisme.addTo(gdivers); 
               ldivers.addLayer(gdivers); 
            }
            addPopup(organisme, libelle_o, rue1, rue2, libelle_f,capacite,niv_requis, cp , libelleville,modalitesperecrutement,type);
        }
        
        
        function addPopup(organisme, libelle_o, rue1, rue2, libelle_f,capacite,niv_requis, cp , libelleville,modalitesperecrutement ,type){
            var ContenuePopup = "<b>"+ libelle_f + "</b> </br></br></br>"+ // Titre formation
            "<b> Organisme :</b> " + libelle_o + "</br></br>"+
            "<b> Site :</b> " + "</br></br>"+
            "<b> Sanction diplôme certificat :</b> " + type + "</br></br>"+
            "<b> Pré-requis :</b> " + modalitesperecrutement + "</br></br>"+
            "<b> Adresse :</b> " + rue1 + "</br></br>"+
            "<b> Complément d'adresse :</b> " + rue2 + "</br></br>"+
            "<b> Ville :</b> " + libelleville + "</br></br>"+
            "<b> Code postal :</b> " + cp + "</br></br>"+
            "<b> Téléphone :</b> " + "</br></br>"+
            "<b> Fax :</b> " + "</br></br>"+
            "<b> Mail :</b> " + "</br></br>"+
            "<b> Contact :</b> " + "</br></br>"+
                    "";

            organisme.bindPopup(ContenuePopup);
        }  
        
        
        L.control.layers(basemapControl, layerControl).addTo(map);
        
        L.control.search({
            layer: Groupe,
            initial: true,
            propertyName: libelle_f

        }).addTo(map);
        
   });