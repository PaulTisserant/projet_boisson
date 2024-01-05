<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link 
        rel="stylesheet" 
        href="recettes.css"
    >
    <style>
        /* Ajoutez du CSS pour styliser la liste déroulante des suggestions */
        #autocompleteList {
            list-style: none;
            padding-left : 20px;
            margin-left : 20px;
            display: none;
            border: 1px solid #ccc;
            border-top: none;
            width: 100px;
        }

        #autocompleteList li {
            padding: 8px;
            cursor: pointer;
        }

        #autocompleteList li:hover {
            background-color: #f1f1f1;
        }
    </style>
    <title>Recettes</title>
</head>
<body>

    <?php //include "header.php";?>

    <h1>Recettes</h1>

    <!-- Bar de recherche -->
    <form action="recettes.php" method="GET">
        <input type="text" name="search" placeholder="Rechercher une recette" class="searchBar">
        <!-- Liste déroulante des suggestions -->
        <ul id="autocompleteList"></ul>
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

                echo "<h3>Séléctionnez un ou plusieurs ingrédients (en appuyant sur CTRL)</h3>";
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

    <div>
        <h3>Faite une recherche par ingredients classé par catégorie <a href="hierarchie.php">ici</a></h3>
    </div>

    <!-- Liste des ingredients selectionnés -->
    <div id="ingredientsListContainer">
        <h2>Ingrédients sélectionnés</h2>
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
                    echo "<a href='recette.php?id=" . $recipe['recipe_id'] . "'>Plus d'infos</a>";
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

        document.addEventListener("DOMContentLoaded", function () {
            // Gestionnaire d'événements pour la saisie dans le champ de recherche
            document.querySelector(".searchBar").addEventListener("input", function () {
                var searchTerm = this.value;

                // Requête AJAX pour récupérer les suggestions de recherche depuis le serveur PHP
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "autocomplete.php?search=" + searchTerm, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        // Mettez à jour la liste déroulante des suggestions
                        updateAutocompleteList(data);
                    }
                };
                xhr.send();
            });

            // Fonction pour mettre à jour la liste déroulante des suggestions
            function updateAutocompleteList(suggestions) {
                var autocompleteList = document.getElementById("autocompleteList");
                autocompleteList.innerHTML = "";

                if (suggestions.length > 0) {
                    // Afficher la liste déroulante
                    autocompleteList.style.display = "block";

                    // Ajouter chaque suggestion à la liste
                    suggestions.forEach(function (suggestion) {
                        var listItem = document.createElement("li");
                        listItem.textContent = suggestion;
                        autocompleteList.appendChild(listItem);
                    });
                } else {
                    // Masquer la liste déroulante s'il n'y a pas de suggestions
                    autocompleteList.style.display = "none";
                }
            }

            // Gestionnaire d'événements pour la sélection d'une suggestion
            document.addEventListener("click", function (event) {
                if (event.target.tagName === "li" && event.target.parentNode.id === "autocompleteList") {
                    var selectedSuggestion = event.target.textContent;
                    console.log(selectedSuggestion);
                    document.querySelector(".searchBar").value = selectedSuggestion;

                    // Masquer la liste déroulante après la sélection
                    document.getElementById("autocompleteList").style.display = "none";
                }
            });

            // Gestionnaire d'événements pour masquer la liste déroulante lorsque le champ de recherche n'est pas selectionné (!focus)
            document.querySelector(".searchBar").addEventListener("blur", function () {
                document.getElementById("autocompleteList").style.display = "none";
            });
        });


    </script>
</html>