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
              <li><a href="#">Par métier</a></li>
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
      <li><a href="#">Organismes</a>
          <ul>
            <li><a href="add.php">Ajouté</a></li>
            <li><a href="#">Modifié</a>
            <li><a href="#">Supprimé</a></li>
          </ul>
      </li>
      <li style="float:right"><a href="#" >Login</a></li>
    </ul>
</nav>