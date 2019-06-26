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
        require('./inc/headjscss.php'); 
	if(isset($_SESSION['id'])){
		// Redirection si pas connecté
			header('Location: index.php');
			exit;
		}
	include ('./inc/fonction.php');
         


        $conn=  $dbconn->connect();

		$login_app = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
		$pass_app = filter_input(INPUT_POST, 'mdp');
		$nom_app = filter_input(INPUT_POST, 'nom');
		
		$reg_msg = '';
		
		
		if(isset($_GET['pages']))
					{	
						if($_GET['pages'] == 'register')
						{	
							if((!$login_app) || (!$pass_app)) {
								echo "<center><h1> champs non remplis</h1></center>";
							} else {
								try{
									// Vérification si email existe ou pass
									$sql = "SELECT COUNT(nom) AS nom FROM compte WHERE nom = '$login_app'";
                                                                        $result = pg_query($conn, $sql) or die('query error');

                                                                        $row = pg_fetch_row($result);
                                                                        
                                                                        $row = json_encode($row, JSON_UNESCAPED_UNICODE);;
							
									if($row > 0){
										header("location:./reg?pages=error_reg"); 
									}
									else{
										// Création du compte
                                                                                $optionshash = [
                                                                                    'cost' => 12,
                                                                                ];
                                                                                
                                                                                $hashedmdp = md5($pass_app);
                                                                            
                                                                                $sql = "INSERT INTO compte (email, mdp,  nom) VALUES ('$login_app', '$hashedmdp', '$nom_app')";
                                             
										
										$queryRecords = pg_query($conn, $sql) or die("error to fetch employees data");
										
										//$row = $stmt->fetch(PDO::FETCH_ASSOC);
										$reg_msg = 'Votre compte à bien était crée , vous pouvez dés à présent vous connecté !';
									}
								}catch (Exception $e) {
									echo 'Exception reçue : ', $e->getMessage(), "\n";
								}
								
							}
						}else if($_GET['pages'] == 'error_reg')
						{
							$reg_msg = 'Erreur ! cette adresse mail est déja prise !';
						}
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
		  <h2>Création de votre compte</h2>
		  <?php
			if($reg_msg != ''){
			echo '<div class="alert alert-info" role="alert">
			',$reg_msg,'
			</div>';
			$reg_msg = '';}
		  ?>
		  <form class="form-horizontal" action="?pages=register" method='post'>
			<div class="form-group">
			  <label class="control-label col-sm-2" for="email">Email:</label>
			  <div class="col-sm-10">
				<input type="email" class="form-control" id="email" placeholder="Entrez votre email" name="email">
			  </div>
			</div>	
			
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="nom">Nom:</label>
			  <div class="col-sm-10">          
				<input type="text" class="form-control" id="nom" placeholder="Entrez votre nom" name="nom">
			  </div>
			</div>	
			
			<div class="form-group">
			  <label class="control-label col-sm-2" for="mdp">Mot de passe:</label>
			  <div class="col-sm-10">          
				<input type="password" class="form-control" id="mdp" placeholder="Entrez votre mot de passe" name="mdp">
			  </div>
			</div>
			
			

			
			
			
			<div class="form-group">        
			  <div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">Créer</button>
			  </div>
			  
			  
		  </form>
		</div>
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
