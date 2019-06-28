<?php 

    session_start();

?>

<nav>
    <ul class="main-navigation">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="mapsql.php">Carte</a>
      </li>
      <?php
	if(isset($_SESSION['id']))
	{
            echo '
		      <li><a href="#">Organismes</a>
                         <ul>
                            <li><a href="addorga.php">Ajouter</a></li>
                            <li><a href="gorganisme.php">Gérer</a></li>
                         </ul>
                      </li>
                      <li><a href="gformations.php">Formations</a>
                      </li>
                      <li style="float:right"><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> Deconnexion</a></li>
                      <li style="float:right"><a href="./compte.php"><span class="glyphicon glyphicon-user"></span> Mon Compte ( '.$_SESSION["email"].' )</a></li>';
           if($_SESSION["droittype"] == 3){
               echo '<li style="float:right"><a href="./admin.php"><span class="glyphicon glyphicon-log-in"></span> Admisnistration</a><ul>
                            <li><a href="./admin/compte.php">Comptes</a></li>
                            <li><a href="gorganisme.php">Organismes</a></li>
                            <li><a href="gorganisme.php">Formations</a></li>
                         </ul></li>';
           }
					
	}else
					{
					echo '
						<li style="float:right"><a href="./reg.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						
                                                <li style="float:right"><a href="./log.php" >Login</a></li>';
					}					
      ?>


      
    </ul>
</nav>