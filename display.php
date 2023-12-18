<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display boissons</title>
</head>
<body>

    <?php
    // Inclure le fichier de connexion à la base de données
    
    try {
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");

        // Sélectionner toutes les recettes et les ingrédients associés
        $sql = "SELECT title, food_index, ingredients, preparation FROM recipes";
        $result = $conn->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Pour chaque recette
        while ($row = $result->fetch()) {
            // Afficher le nom de la recette
            echo "<h1>" . $row['title'] . "</h1>";
            echo "<img src='Photos/".$row['title'].".jpg' alt='photo de la recette'>";
            echo "<h2>".$row['preparation']."</h2>";
            echo "<h2>".$row['ingredients']."</h2>";


            echo "<ul>";
            $ingredients = explode(",", $row['food_index']);
            foreach ($ingredients as $ingredient) {
                echo "<br>";

                echo "<li>" . $ingredient . "</li>";
            }
            echo "</ul>";
        }
    
        
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    


    ?>
        
</body>
</html>