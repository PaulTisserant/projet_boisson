<?php 
include_once "fonction.php" ;
echo '
<nav>
    <ul>
        <li><a href="index.php"><img src="Photos/mixo.png" alt="Acceuil"></a></li>
        <li class="upscale"><a class="elem" href="recettes.php">Les Recettes</a></li> 

                <li>
                <div class="connect">
                <a href="panier.php">
            <img class="panier" src="Photos/panier.png" alt="panier">
            <span class="text" >Panier </span>   
                </a></li>
                ';
echo '
                <li>
                </div>
                <div class="connect">
                <a href="connexion.php">
            <img class="user" src="Photos/user.png" alt="user">
            <span class="text" >Connexion </span>   
                </a></li>
                </div>
                ';


echo'</ul> </nav>' ;










?>