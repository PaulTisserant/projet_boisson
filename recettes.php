<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link 
        rel="stylesheet" 
        href="recettes.css"
    >
    <title>Recettes</title>
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

    <h1>Recettes</h1>

    <!-- Bar de recherche -->
    <form action="recettes.php" method="GET">
        <input type="text" name="search" placeholder="Rechercher une recette" class="searchBar">
        <input type="submit" value="Rechercher" class="researchButton">
    </form>

    <?php
    
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recherche par nom de recette
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql = "SELECT * FROM Recipes WHERE title LIKE :search";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
            } else {
                $sql = "SELECT * FROM Recipes";
                $stmt = $conn->prepare($sql);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $recipe) {
                // faire une carte avec le titre de la recette, les ingrédients et la photo
                echo "<div class='card'>";
                echo "<h2>" . $recipe['title'] . "</h2>";
                echo "<img src='images/" . $recipe['title'] . "' alt='" . $recipe['title'] . "'>";
                echo "<p>" . $recipe['food_index'] . "</p>";
                echo "</div>";
            }

            
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }


    ?>

    
</body>
</html>