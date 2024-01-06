<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="favoris.css">
    <link rel="stylesheet" type="text/css" href="header.css">
    <title>Vos favoris</title>
</head>
<body>
<?php include_once "header.php" ;?>
<h1>Vos favoris :</h1>
<?php 
include_once "fonctions.php" ;
if(verifConn()){


    try {
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM favoriterecipes JOIN recipes USING(recipe_id) WHERE user_id =?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '<div class="cardContainer">' ;
        foreach ($result as $recipe) {

            echo "<div class='card'>";      
            echo "<h2>" . $recipe['title'] . "</h2>";
            echo "<img src='Photos/default.png' alt='" . $recipe['title'] . "'>";
            echo "<p>" . $recipe['food_index'] . "</p>";
            echo "<a href='recette.php?id=" . $recipe['recipe_id'] . "'>Plus d'infos</a>";
            echo "</div>";
        }
        echo '</div>' ;
    }catch (PDOException $e) {
        echo "Erreur : " . $e->GETMessage();
    }






}else{

    if(isset($_SESSION['favorite'])){
        if(count($_SESSION['favorite'])){
            // Si il y a au moins un favoris
            try {
                $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = ?");
                echo '<div class="cardContainer">' ;
                foreach ($_SESSION['favorite'] as $id) {
                    $stmt->execute([$id]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    echo "<div class='card'>";      
                    echo "<h2>" . $result['title'] . "</h2>";
                    echo "<img src='Photos/default.png' alt='" . $result['title'] . "'>";
                    echo "<p>" . $result['food_index'] . "</p>";
                    echo "<a href='recette.php?id=" . $result['recipe_id'] . "'>Plus d'infos</a>";
                    echo "</div>";
                }
                echo '</div>' ;
            }catch (PDOException $e) {
                echo "Erreur : " . $e->GETMessage();
            }
        }else{
            echo '<h1>Vous n\'avez pas de Favoris </h1> ' ;
            
    }
    }
}

?>    
</body>
</html>