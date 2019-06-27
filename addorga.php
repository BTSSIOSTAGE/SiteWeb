<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>eMap 'Run - Add</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />       
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <?php 
            include ("./inc/navbar.php"); 
            require('./inc/headjscss.php');
            if(!isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
        ?>
        <style> #map{width: 70%;height: 94vh;z-index:1;float:left;}</style>
    </head>
    <body>
        <div id='map'> <script src="./inc/js/addorganisme.js"></script></div>
        <div class="gestion">
            <div class="box">
                <div class="inputDiv">
                    <b><center>Ajouté un organisme</b> </center><br><br>
                    <b>Lat</b>: <br>
                    <input type="text" id="latInput"> <br>
                    <b>Lon</b>: <br>
                    <input type="text" id="lonInput"> <br>
                    <b>Nom de l'organisme</b>: <br>
                    <input type="text" id="nomorganisme"> <br>
                    <b>Téléphone</b>: <br>
                    <input type="text" id="numerotel"> <br>
                    <b>Email de l'organisme</b>: <br>
                    <input type="text" id="emailorganisme"> <br>
                    <b>Adresse 1</b>: <br>
                    <input type="text" id="adresse1"> <br>
                    <b>Adresse 2</b>: <br>
                    <input type="text" id="adresse2"> <br> 
                    <b>Ville</b>: <br>
                    <input type="text" id="ville"> <br> 
                    <b>Code postal</b>: <br>
                    <input type="text" id="cp"> <br> 
                    
                    
                    
                    
                    <br>
                    <input type="button" value="Ajouter" id="btnSave" class="bouttonform button2">
                    <p id="status"></p>
                </div>
             </div>
        </div>
    </body>
</html>
