<?php 

    session_start();

?>

<nav>
    <ul class="main-navigation">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="#">Cartes</a>
        <ul>
          <li><a href="cmqnumerique.php">CMQ Numerique</a></li>
          <li><a href="#">CMQ Bâtiment</a>
            <ul>
              <li><a href="cmqfamille.php">Par métier</a></li>
              <li><a href="cmqbatimentf.php">Par formation</a></li>
            </ul>
          </li>
          <li><a href="#">Carte SQL Test</a>
            <ul>
              <li><a href="mapsql.php">SQL</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <?php
	if(isset($_SESSION['id']))
	{
            echo '
		      <li><a href="#">Organismes</a>
                         <ul>
                            <li><a href="addorga.php">Ajouter</a></li>
                            <li><a href="gorganisme.php">Gérer</a>
                         </ul>
                        </li>
                      <li><a href="gformations.php">Formations</a>
                      </li>
                      <li style="float:right"><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> Deconnexion</a></li>
                      <li style="float:right"><a href="./compte.php"><span class="glyphicon glyphicon-user"></span> Mon Compte ( '.$_SESSION["email"].' )</a></li>';
					
	}else
					{
					echo '
						<li style="float:right"><a href="./reg.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
						
                                                <li style="float:right"><a href="./log.php" >Login</a></li>';
					}					
      ?>


      
    </ul>
</nav>