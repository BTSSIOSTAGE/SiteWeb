<!DOCTYPE html>
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
	<?php include ("./inc/navbar.php");
		  include ('./inc/fonction.php');
                  require('./inc/headjscss.php');
		  if(!isset($_SESSION['id'])){
			// Redirection si pas connecté
			header('Location: log.php');
			exit;
		  }
    ?>
	
  </head>
  
  
  <body>  
   
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->    
    <div class="t-page">
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->      
    
      
    <!---------------------------------------------------------------------------ACCUEIL------------------------------------------------------------------------- -->    
    <div class="container">
		<div class="container-fluid">
			<a href="https://cdn.glitch.com/ce9915f4-ec74-4709-babf-71eb72708429%2FLogo%20LyceeNelsonslide.jpg?1551633637787">
				<img src="https://cdn.glitch.com/ce9915f4-ec74-4709-babf-71eb72708429%2FLogo%20LyceeNelsonslide.jpg?1551633637787" alt="banniere" width="700">
			</a>
			
				<h2>Mon compte - Modifier mes informations</h2>

				<?php
					$conn=  $dbconn->connect();
					
					//$compte = $conn->query('SELECT username from users WHERE username: "'.$_SESSION['username'].'"');
					//$donnees = $compte->fetch();
					$id = $_SESSION['id'];
					$sql = "SELECT * FROM compte WHERE compte_id = '$id'"; 
                                        $result = pg_query($conn, $sql) or die('query error');
                                        
					foreach (pg_fetch_all($result) as $row) {
					}

					
					if(isset($_GET['pages']))
					{	
						if($_GET['pages'] == 'compte_update')
						{
							if(empty($_POST['mdp']))
							{
                                                                $emailupdate = $_POST["email"];
                                                                $nomupdate = $_POST["nom"];
								$update = "UPDATE compte SET nom = '$nomupdate' , email = '$emailupdate' WHERE compte_id ='$id'";
                                                                $result = pg_query($conn, $update) or die('query error');
								
								echo '<div class="alert alert-success" role="alert">
										Vos informations ont etaient mis à jour ( Sauf mot de passe ) ! Recharger la page !
									 </div>';
							}
							else
							{
								$emailupdate = $_POST["email"];
                                                                $nomupdate = $_POST["nom"];
                                                                $mdpupdate = $_POST["mdp"];
                                                                $hashedmdp = md5($mdpupdate);
								$update = "UPDATE compte SET nom = '$nomupdate' , email = '$emailupdate', mdp = '$hashedmdp' WHERE compte_id ='$id'";							
                                                                $result = pg_query($conn, $update) or die('query error');
								
								echo '<div class="alert alert-success" role="alert">
										Vos informations ont etaient mis à jour ! Recharger la page !
									 </div>';
									 
							}
                                                        $_SESSION["email"] = $_POST["email"];
							$_SESSION["nom"] = $_POST["nom"];
							
						}
					}
				
				?>
				<form class="form-horizontal" action="?pages=compte_update" method="post"> 
					<div class="form-group">
						<label class="control-label col-sm-2" for="mdp">Email:</label>
						<div class="col-sm-10">          
							<input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'];  ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="nom">Nom:</label>
						<div class="col-sm-10">          
							<input type="text" class="form-control" id="nom"  name="nom" value="<?php echo $row['nom'];  ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="control-label col-sm-2" for="mdp">Mot de passe:</label>
						<div class="col-sm-10">          
							<input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre nouveau mot de passe"> 
						</div>
					</div>
					
					<div class="form-group">        
					  <div class="col-sm-offset-2 col-sm-10">
						<button type="submit" name = 'Submit' class="btn btn-success">Modifier</button>
					  </div>
					</div>
				</form>
		</div>    
    </div>
     <!---------------------------------------------------------------------------NAVIGATION------------------------------------------------------------------------- -->    

        
        
        
  
          
          
          
          
          
          
          
          
          
          
          
          
          
          
        </div>
      </div>

    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- --> 
    </div> 
    <!-------------------------------------------------------------------------------------------------------------------------------------------------------------- -->    

    
    
  </body>
</html>
