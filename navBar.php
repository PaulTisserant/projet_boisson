<?php 
include_once "fonction.php" ;
echo '
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="recettes.php">Recettes</a></li> ' ;

if (verifConn()){
          echo '<li><a href="compte.php">Compte</a></li>
                <li><a href="deconnexion.php">Deconnexion</a></li>' ;
}else{
echo '
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="connexion.php">Connexion</a></li>  ';
}

echo'</ul> </nav>' ;










?>