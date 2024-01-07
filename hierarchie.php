

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link 
        rel="stylesheet" 
        href="recettes.css"
    >
    <link rel="stylesheet" type="text/css" href="header.css">
    <style>
        .categories ul {
            list-style: none;
            padding-left: 20px;
            display: none;
        }

        .categories ul.active {
            display: block;
        }

        .categories p {
            cursor: pointer;
            color: blue;
        }

        .categories {
            margin: 20px auto; /* Ajout de cette ligne pour centrer horizontalement */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.1);
            width: 300px;
            display: inline-block; /* Ajout de cette ligne pour aligner avec le reste */
        }

    </style>
</head>
<body>

    <?php include "header.php";?>

    <div class="container">

        

        <h3>Parcourez les catégories et selectionnez le ou les ingrédients qui compose la recette que vous cherchez</h3>

        <div id="categories" class="categories">
            <!-- Les catégories initiales -->
            <p id="category_0">Aliments</p>
            <ul id="children_0">
                <!-- Les sous-catégories seront ajoutées ici dynamiquement -->
            </ul>
        </div>
        <button id="confirm">confirmer la selection d'ingrédients</button>

        

        <?php
            include 'bddConnexion.php';
            try {
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $result = null;

                // recherche si la variable search se trouve dans toutes les données d'une recette
                if (isset($_POST['categories'])) {
                    $categories = $_POST['categories'];
                    $string = implode(" ", $categories);
                    $stmt = $conn->prepare("SELECT * FROM recipes WHERE food_index LIKE '%" . $string . "%'");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }


                if ($result == null) {
                    echo "<h2>Aucune recette ne correspond à votre recherche</h2>";
                } else {
                    echo "<h2>Voici les recettes correspondant à votre recherche</h2>";

                    foreach ($result as $recipe) {
                        // carte clickable qui redirige vers la page de la recette
                        
                        echo "<div class='card'>";
                        
                        echo "<h2>" . $recipe['title'] . "</h2>";
                        echo "<img src='Photos/default.png' alt='" . $recipe['title'] . "'>";
                        echo "<p>" . $recipe['food_index'] . "</p>";
                        echo "<a href='recette.php?id=" . $recipe['recipe_id'] . "'>Plus d'infos</a>";
                        echo "</div>";
                        
                    }
                }



                function displayCategoriesArray($parentId, $conn) {
                    $result = [];
                    $sql = "SELECT name FROM foodhierarchy WHERE food_id = :parentId";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
                    $stmt->execute();
                    $category = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($category) {
                        $result['id'] = $parentId;  // Utilisation de l'ID comme identifiant
                        $result['name'] = $category['name'];

                        // Fetch children
                        $sqlChildren = "SELECT child_food_id FROM hierarchyrelationships WHERE parent_food_id = :parentId";
                        $stmtChildren = $conn->prepare($sqlChildren);
                        $stmtChildren->bindParam(':parentId', $parentId, PDO::PARAM_INT);
                        $stmtChildren->execute();
                        $children = $stmtChildren->fetchAll(PDO::FETCH_ASSOC);

                        if ($children) {
                            $result['children'] = [];
                            foreach ($children as $child) {
                                $result['children'][] = displayCategoriesArray($child['child_food_id'], $conn);
                            }
                        }
                    }

                    return $result;
                }

                $initialParents = [238];
                $categoriesArray = [];

                foreach ($initialParents as $parentId) {
                    $categoriesArray[] = displayCategoriesArray($parentId, $conn);
                }

                // Convertir le tableau PHP en JSON pour une utilisation côté client (JavaScript)
                $categoriesJSON = json_encode($categoriesArray);
                echo "<script>var categories = $categoriesJSON;</script>";

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }


        ?>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var categoriesElement = document.getElementById('categories');
                categoriesElement.innerHTML = generateCategoriesHTML(categories);

                function generateCategoriesHTML(categories, parentId) {
                    var html = '';
                    categories.forEach(function (category) {
                        var categoryId = category.id;  // Utilisation de l'ID comme identifiant
                        html += '<p id="category_' + categoryId + '">' + category.name + '</p>';
                        if (category.children && category.children.length > 0) {
                            html += '<ul id="children_' + categoryId + '">';
                            html += generateCategoriesHTML(category.children, categoryId);
                            html += '</ul>';
                        }
                    });
                    return html;
                }

                // Ajouter un gestionnaire d'événements à chaque catégorie
                document.querySelectorAll('p').forEach(function (category) {
                    category.addEventListener('click', function () {
                        toggleChildren(category.id);
                    });
                });

                // Fonction pour afficher ou masquer les enfants d'une catégorie
                function toggleChildren(categoryId) {
                    console.log(categoryId);
                    var numerp = categoryId.split('_')[1];
                    var childrenList = document.getElementById('children_' + numerp);

                    if (!childrenList) {
                        document.getElementById('category_' + numerp).style.color = 'red';
                    } else {
                        childrenList.classList.toggle('active');
                    }
                    
                }
            });


            document.getElementById('confirm').addEventListener('click', function () {
                // Récupérer les catégories sélectionnées (les catégories dont la couleur est rouge)
                var selectedCategories = [];
                document.querySelectorAll('p').forEach(function (category) {
                    if (category.style.color === 'red') {
                        //push le nom de la catégorie dans le tableau
                        selectedCategories.push(category.innerHTML);
                    }
                });

                console.log(selectedCategories);

                // créer un formulaire caché avec les catégories sélectionnées
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = 'hierarchie.php';

                selectedCategories.forEach(function (category) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'categories[]';
                    input.value = category;
                    form.appendChild(input);
                });

                document.body.appendChild(form);
                form.submit();

                

            });



        </script>

    </div>
</body>
</html>
