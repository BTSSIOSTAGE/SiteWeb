<html lang="fr">
  <head>
    <title>Accueil | BTS SIO 1</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../inc/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<?php include ("../inc/navbar.php");
		  include ('../inc/fonction.php');
                  require('../inc/headjscss.php');
		  if(!isset($_SESSION['id'])){
			// Redirection si pas connecté
			header('Location: ../log.php');
			exit;
		  }else if($_SESSION['droittype'] != 3){
                      header('Location: ../index.php');
                      exit;
                  }
    ?>
	
  </head>
  
  
  <body>  
   
    
  </body>
</html>

