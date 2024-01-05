<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recette</title>
    <link rel="stylesheet" href="recettes.css">
    <style>
        input[type="submit"] {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>

    <?php include "header.php";?>

    <h1>Recette</h1>

    <?php 

        require_once "fonctions.php";
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = :id");
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            echo "<h2>" . $result['title'] . "</h2>";
            echo "<img src='Photos/default.png' alt='" . $result['title'] . "'>";
            echo "<p>" . $result['ingredients'] . "</p>";
            echo "<p>" . $result['preparation'] . "</p>";

            

            // si l'utilisateur est connecté, on affiche le bouton pour ajouter la recette en favoris
            if (verifConn()) {
                echo "<form action='recette.php?id=" . $_GET['id'] . "' method='POST'>";
                echo "<input type='hidden' name='recipe_id' value='" . $_GET['id'] . "'>";
                echo "<input type='submit' value='Ajouter la recette aux favoris' name='favoris'>";
                echo "</form>";

                echo "Utilisateur id : " . $_SESSION['user_id'] . "<br>";
            } else {
                echo "<p>Connectez-vous pour ajouter la recette à vos favoris</p>";
            }

            
            

            

        } catch (PDOException $e) {
            echo "Erreur : " . $e->GETMessage();
        }
    ?>
    
</body>
</html>