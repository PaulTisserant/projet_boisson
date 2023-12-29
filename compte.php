<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="compte.css">

    <title>Compte</title>
</head>
<body>

<nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="recettes.php">Recettes</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
    </nav>
<?php 
session_start();
include "fonction.php";
?>
</body>
<div class="conteneur" > 
<h1 >Information Utilisateur</h1>
<?php 
if (isset($_SESSION['user_id']) && isset($_SESSION['login'])) {
    if(!(verifConn())){
        echo 'erreeee' ;
            header('Location: connexion.php');
            exit() ;
        }
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $sql = "SELECT * FROM users WHERE login = ? AND user_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['login'], $_SESSION['user_id']]);
            // Si une ligne est retournée, le login existe
            if ($stmt->rowCount() > 0) {
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                // Stockez les données dans des variables individuelles
                $login = $userData['login'];
                $password = $userData['password'];
                $first_name = $userData['first_name'];
                $last_name = $userData['last_name'];
                $gender = $userData['gender'];
                $email = $userData['email'];
                $birthdate = $userData['birthdate'];
                $address = $userData['address'];
                $postal_code = $userData['postal_code'];
                $city = $userData['city'];
                $phone_number = $userData['phone_number'];

            }else{
                echo "Error aucune ligne";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
}else{
    header('Location: connexion.php');
}


$pass = afficherMotDePasse($password) ;
echo "
<p> Nom : <span class='info'> $last_name </span> </p> 
<p> Prenom : <span class='info'> $first_name </span> </p> 
<p> Civilite : <span class='info'> $gender </span> </p> 
<p> Email : <span class='info'> $email </span> </p> 
<p> Tel : <span class='info'> $phone_number </span> </p> 
<p> Ville : <span class='info'> $city </span> </p> 
<p> Code Postal : <span class='info'>$postal_code </span> </p> 
<p> Adresse : <span class='info'> $address </span> </p> 
<p> Login : <span class='info'> $login </span> </p> 
<p> Mot de passe : <span class='info'>$pass </span>  </p> 

 "  ?>
</div>


</html>