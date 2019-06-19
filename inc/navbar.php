<?php 

    session_start();

?>

<nav-ul>
    <nav-li><a href="index.php">Accueil</a></nav-li>
        <nav-li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Carte</a>
            <div class="dropdown-content">
              <a href="cmqbatiment.php">CMQ Batiment</a>
              <a href="cmqnumerique.php">CMQ Numérique</a>
              <a href="mapsql.php">MAP TEST SQL</a>
            </div>
            <nav-li style="float:right"><a class="active" href="login.php">Connexion</a></nav-li>
      </nav-li>
</nav-ul>