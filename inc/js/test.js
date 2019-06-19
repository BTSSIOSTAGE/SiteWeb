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
       var map = L.map('map', 
        {
            minZoom: 11,
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
        
        data = JSON.parse(data);
        
        for (var i = 0; i < data.length; i++) {
        var name = data[i]['name'];
        var lat = data[i]['lat'];
        var lon = data[i]['lon'];
       
        var marker = L.marker([lat, lon]);
        
        marker.bindPopup(name);
        
        marker.addTo(map);
        
       }
        
   });
   
   
   
   // Variable de la map
