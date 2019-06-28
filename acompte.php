<html lang="fr">
  <head>
    <title>Accueil | BTS SIO 1</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./inc/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="./inc/gestion_compte.js.js"></script>
	<?php include ("./inc/navbar.php");
        
		  include ('./inc/fonction.php');
                  require('./inc/headjscss.php');
		  if(!isset($_SESSION['id'])){
			// Redirection si pas connecté
			header('Location: ./log.php');
			exit;
		  }else if($_SESSION['droittype'] != 3){
                      header('Location: ./index.php');
                      exit;
                  }
    ?>
	
  </head>
  
  
  <body>  
   <div class="mainbox">
        <h2>Gestion des Comptes - Listes</h2>
        <div class="well clearfix">
            <div id="msg"></div>
        </div>
         
        <div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Création d'un compte</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
                    <input type="hidden" value="add" name="action" id="action">
                    <input type="hidden" value="0" name="formation_id" id="formation_id">
                  <div class="form-group">
                    <label for="name" class="control-label">Email :</label>
                    <input type="text" class="form-control" id="libelle_f" name="libelle_f"/>
                  </div>
                  <div class="form-group">
                    <label for="name" class="control-label">Email :</label>
                    <input type="text" class="form-control" id="libelle_f" name="libelle_f"/>
                  </div>
                  <div class="form-group">
                    <label for="name" class="control-label">Type (Ex : BTS):</label>
                    <select class="select-orga" name="listetype" id="listetype"></select>
                    <div class="" id="test" >
                    </div>
                    <input type="text" class="form-control" id="type" name="type"/>
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
                             <th>ID Compte</th>
                             <th>Nom</th>
                             <th>Email</th>
                             <th>Mot de passe</th>
                             <th>Niveau de droit</th>
                             <th>Compte validé</th>
                             
                        </tr>
                    </thead>
                    <tbody id="emp_body">
                    </tbody>
                </table>
            </div>  
        </div> 
    
  </body>
</html>

