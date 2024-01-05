<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recette</title>
    <link rel="stylesheet" href="recettes.css">
    <link rel="stylesheet" type="text/css" href="header.css">

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
        .conteneur{
            display: block;
            margin: auto;
            width: 50%;
            height: 80%;
            border: #ab3333 3px solid;
            border-radius: 30px;
            padding: 20px;
        }
        .conteneur img{
            display: block;
            margin: auto;
        }
        .conteneur h2{
            font-size: 230%;
            color: #ab3333;
            font-weight: bold;
            text-align: center; 
        }
        .bouton{
            background-color: #ab3333;
            border: black 1px solid;
            color: white;
        }
        .bouton img {
            filter: brightness(100) ;

        }
    </style>
</head>

<body>

    <?php include "header.php";?>


    <?php 

        require_once "fonctions.php";
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM recipes WHERE recipe_id = :id");
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<div class='conteneur'>" ;
            echo "<h2>" . $result['title'] . "</h2>";
            if($result['photo_path']== NULL){
            echo "<img src='Photos/default.png' alt='" . $result['title'] . "'>";
            }else{
                echo "<img src= " .$result['photo_path'] . " alt='" . $result['title'] . "'>";
            }
            echo "<h3> Ingredient : </h3>";

            $ingredients = explode('|',$result['ingredients']) ;
            echo "<ul>" ;
            foreach ($ingredients as $ingredient) {
                echo "<li>" . $ingredient . "</li>";
            }
            echo "</ul>" ;
            echo "<h3> Instruction : </h3>";
            echo "<p>" . $result['preparation'] . "</p>";
            echo '
            <div class="bouton">
            <img src="Photos/favoris.png" >
            echo "</div>";
        
            echo "</div>" ;
            ' ;

            // si l'utilisateur est connecté, on affiche le bouton pour ajouter la recette en favoris
            if (verifConn()) {
                echo "<form action='recette.php?id=" . $_GET['id'] . "' method='POST'>";
                echo "<input type='hidden' name='recipe_id' value='" . $_GET['id'] . "'>";
                echo "<input type='submit' value='Ajouter la recette aux favoris' name='favoris'>";
                echo "</form>";

                echo "Utilisateur id : " . $_SESSION['user_id'] . "<br>";
            } else {
            }

            
            

            

        } catch (PDOException $e) {
            echo "Erreur : " . $e->GETMessage();
        }
    ?>
    
</body>
</html>