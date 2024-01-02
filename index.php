<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
    <?php include "header.php";?>

    <h3>Bienvenue sur notre site de recettes de cocktail <span style="color:#D52D36;">MixologyHub </span> !</h3>

    <div class='conteneur'>
        <a href="recettes.php">
     <div class='card'>
        <div class='cardContent'>
        <h2>Nos recettes</h2>
        <img src='Photos/cocktail.png' alt='default'>
        </div>
     </div>
</a>
    <a href="panier.php">
     <div class='card'>
        <div class='cardContent'>

        <h2>Votre Panier</h2>
        <img src='Photos/panier.png' alt='default'>
        </div>
     </div>
     </a>

<?php 
include_once "fonction.php";
if(verifConn()){
    echo "
    <a href='compte.php'>
     <div class='card'>
        <div class='cardContent'>

        <h2>Votre Compte</h2>
        <img src='Photos/user.png' alt='default'>
        </div>
     </div>
     </a>


    </div>
    " ;
}else{
    echo "
    <a href='connexion.php'>
    <div class='card'>
       <div class='cardContent'>
       <h2>Connexion</h2>
       <img src='Photos/user.png' alt='default'>
       </div>
    </div>
    </a>


   </div>
   " ;
}
    ?>
</body>
</html>