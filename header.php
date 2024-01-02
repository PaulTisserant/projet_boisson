<?php 
include_once "fonction.php" ;
echo '
<header>
    <div class= "logo">
        <a href="index.php"><img src="Photos/mixo.png" alt="Acceuil"></a>
    </div>
    <div class= "menu">
        <div class="connect">
            <a class="elem" href="recettes.php">
            <img class="panier" src="Photos/cocktail.png" alt="cocktail">
            <span class="text" >Les Recettes </span>   </a>
        </div>
    </div>
    <div class="headRight">
    <div class="connect">
        <a href="panier.php">
        <img class="panier" src="Photos/panier.png" alt="panier">
        <span class="text" >Panier </span>   </a>
    </div>

                ';
                if(verifConn()){
                    echo '

                    <div class="connect">
                        <a href="compte.php">
                        <img class="user" src="Photos/user.png" alt="user">
                        <span class="text" >' . $_SESSION['login']  . '</span>   </a>
                    </div>
                </div>
                ';

                }else{
                    echo '
                    <div class="connect">
                        <a href="connexion.php">
                        <img class="user" src="Photos/user.png" alt="user">
                        <span class="text" >Connexion </span>   </a>
                    </div>
                </div>
                ';
                }
echo' </header>' ;










?>