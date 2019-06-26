<!DOCTYPE html>
<html>
    <!-- Aide : http://bl.ocks.org/ebrelsford/11295124 | https://leafletjs.com/examples/geojson/   | Leaflet Cookbook-->
    <head>
        <title>eMap 'Run - Add</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" /> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet" href="./inc/css/style.css"/> <!-- html, body & #map -->
        <script src="./inc/gestionf.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="./inc/css/bootstarp.min.css">
        <script src="./inc/js/bootstrap.min.js"></script>      
        <?php 
            include ("./inc/navbar.php"); 
            if(!isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
           
        ?>
        <style> #map{width: 70%;height: 94vh;z-index:1;float:left;}</style>
    </head>
    <body>
     <div class="mainbox">
        <h2>Gestion des Formations - Listes</h2>
        <div class="well clearfix">
            <div id="msg"></div>
            <div class="pull-right"><a class="btn btn-info action-btn" action-btn-value="add" data-toggle="modal" data-target="#add_model">Ajouter une formation</a></div>
        </div>
         
        <div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Ajout d'une formation</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="0" name="formation_id" id="formation_id">
                  <div class="form-group">
                    <label for="name" class="control-label">Nom de la formation:</label>
                    <input type="text" class="form-control" id="libelle_f" name="libelle_f"/>
                  </div>
                  <div class="form-group">
                    <label for="name" class="control-label">Type (Ex : BTS):</label>
                    <select class="select-orga" name="listetype" id="listetype"></select>
                    <div class="" id="test" >
                    </div>
                    <input type="hidden" class="form-control" id="type" name="type"/>
                  </div>
                  <div class="form-group">
                    <label for="salary" class="control-label">Capacité d'accueil:</label>
                    <input type="text" class="form-control" id="capacite" name="capacite"/>
                  </div>
                  <div class="form-group">
                    <label for="salary" class="control-label">Niveau requis:</label>
                    <input type="text" class="form-control" id="niv_requis" name="niv_requis"/>
                  </div>
                    <div class="form-group">
                    <label for="name" class="control-label">Modalité spécifique au recrutement:</label>
                    <input type="text" class="form-control" id="modalite_spe_recrutement" name="modalite_spe_recrutement"/>
                  </div>
                    <div class="form-group">
                    <label for="name" class="control-label">Organisme référent : </label>
                    <select class="select-orga" name="listeorga" id="listeorga"></select>
                    <input type="hidden" class="form-control" id="organisme_id" name="organisme_id"/>
                  </div>
                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_fermer" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="btn_add" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
    </div>
         
         
         
         
         

       
            <div class="listeorga">
                <table id="employee_grid" class="table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                             <th>ID Formation</th>
                             <th>Nom</th>
                             <th>Type</th>
                             <th>Câpacité d'accueil</th>
                             <th>Niveau requis</th>
                             <th>Modalité spécifique au recrutement</th>
                             <th>Organisme</th>
                             
                        </tr>
                    </thead>
                    <tbody id="emp_body">
                    </tbody>
                </table>
            </div>  
        </div>   

    </body>
</html>
