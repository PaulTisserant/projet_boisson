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
        <input type="submit" value="Rechercher" class="researchButton" id="researchButton">
        <?php 
            try {
                $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM ingredients");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $ingredients = "";

                if (isset($_GET['ingredients']) && $_GET['ingredients'] != "") {
                    $ingredients = $_GET['ingredients'];
                }

                echo "<select name='ingredients' id='ingredients' class='selector' multiple>";
                foreach ($result as $ingredient) {
                    echo "<option value='" . $ingredient['nom'] . "'>" . $ingredient['nom'] . "</option>";
                }
                echo "</select>";

            } catch (PDOException $e) {
                echo "Erreur : " . $e->GETMessage();
            }
        ?>
    </form>

    <!-- Liste des ingredients selectionnés -->
    <div id="ingredientsListContainer">
        <ul id="ingredientsList">
        </ul>
    </div>



    <div class="cardContainer">

        <?php
        
            try {
                $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // recherche si la variable search se trouve dans toutes les données d'une recette
                if (isset($_GET['search']) && $_GET['search'] != "") {
                    $search = $_GET['search'];
                    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE '%$search%' OR food_index LIKE '%$search%' OR ingredients LIKE '%$search%' OR preparation LIKE '%$search%'");
                } else if (isset($_GET['ingredients'])) {
                    $ingredients = $_GET['ingredients'];
                    $stmt = $conn->prepare("SELECT * FROM recipes WHERE food_index LIKE '%" . $_GET['ingredients'] . "%'");
                } else {
                    $stmt = $conn->prepare("SELECT * FROM recipes");
                }

                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $recipe) {
                    echo "<div class='card'>";
                    echo "<h2>" . $recipe['title'] . "</h2>";
                    echo "<img src='Photos/default.png' alt='" . $recipe['title'] . "'>";
                    echo "<p>" . $recipe['food_index'] . "</p>";
                    echo "</div>";
                }

                
            } catch (PDOException $e) {
                echo "Erreur : " . $e->GETMessage();
            }




        ?>

    </div>

    
</body>

    <script>

        localStorage.clear();

        if (localStorage.getItem('ingredientsList') === null) {
            document.getElementById('ingredientsList').display = "none";
        }


        // Fonction pour créer un nouvel élément de la liste d'ingrédients
        function createIngredientElement(ingredient, index) {
            var li = document.createElement('li');
            
            var p = document.createElement('p');
            p.innerHTML = ingredient;
            li.appendChild(p);

            return li;
        }

        // Fonction pour mettre à jour la liste d'ingrédients affichée
        function updateIngredientsList() {

            var ingredientsListContainer = document.getElementById('ingredientsList');
            ingredientsListContainer.innerHTML = "";

            var ingredientsList = JSON.parse(localStorage.getItem('ingredientsList')) || [];

            for (var i = 0; i < ingredientsList.length; i++) {
                var ingredientElement = createIngredientElement(ingredientsList[i], i);
                ingredientsListContainer.appendChild(ingredientElement);
            }
        }

        document.getElementById('ingredients').addEventListener('change', function() {
            var options = document.getElementById('ingredients').options;

            var selectedOptions = [];
            for (var i = 0; i < options.length; i++) {
                if (options[i].selected) {
                    selectedOptions.push(options[i].value);
                }
            }
            console.log(selectedOptions);
            localStorage.setItem('ingredientsList', JSON.stringify(selectedOptions));
            
            updateIngredientsList();

            console.log(localStorage.getItem('ingredientsList'));
        });

        // Appel initial pour afficher la liste au chargement de la page
        updateIngredientsList();


    </script>
</html>