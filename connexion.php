<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="connexion.css">
    <link rel="stylesheet" type="text/css" href="header.css">

</head>
<body>
    <?php 
    include "fonctions.php";

    $sub = true ;
    session_start();

    if(verifConn()){
        echo "connect" ;
        header('Location: compte.php');
        exit() ;
    }else{
        if ( isset($_POST['mdp']) && isset($_POST['login'])) {
            $sub = false ;
            $log = $_POST['login'] ;
            $mdp = $_POST['mdp'] ;
            try {
                $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
                $sql = "SELECT user_id, password FROM users WHERE login = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$log]);
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($userData && password_verify($mdp, $userData['password'])) {
                    echo "connect" ;
                    $sub = true ;
                    $_SESSION['user_id'] = $userData['user_id'];
                    $_SESSION['login'] =  $log ;
                    header('Location: compte.php');
                    exit() ;
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
    }   
    ?>
<?php  include "header.php" ?>


<section>
<div class="conteneur" >
<form method="post" action="#">
        <h1 class="conn">Se connecter </h1>

    <?php 
    if(!$sub ){ 
        echo '<p style="color:red ;margin-left: 10px;">  /!\ ERREUR Le login ou le mot de passe est incorrect </p>'  ;
    } 
    ?>
    </br>
    <label >Login :</label>
    <input name="login" type="text" name="login" placeholder="Login">
    </br>
    <label >Mot de passe :</label>
    <input name="mdp" type="password" name="login" placeholder="Mot de passe" >
    </br>
    <button id="button"  name="submit" type="submit">Se connecter</button>
    </br>
    <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire ici</a></p>
</form>
</div>
</section>
</body>
</html>