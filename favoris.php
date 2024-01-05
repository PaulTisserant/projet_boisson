<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos favoris</title>
</head>
<body>

<h1>Vos favoris :</h1>
<?php 
include "fonctions.php" ;
if(verifConn()){
    echo ' Bonjour ' . $_SESSION['login'] ;
}
else{
    echo 'Bonjour Visiteur ' ;

    if(count($_SESSION['favoris']) > 0){
        // Si il y a au moins un favoris
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
            foreach ($_SESSION['favoris'] as $id) {
                $stmt->execute($id);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "<div class='card'>";      
                echo "<h2>" . $recipe['title'] . "</h2>";
                echo "<img src='Photos/default.png' alt='" . $recipe['title'] . "'>";
                echo "<p>" . $recipe['food_index'] . "</p>";
                echo "<a href='recette.php?id=" . $recipe['recipe_id'] . "'>Plus d'infos</a>";
                echo "</div>";
            }
        }catch (PDOException $e) {
            echo "Erreur : " . $e->GETMessage();
        }
    }
}

?>    
</body>
</html>