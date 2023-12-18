<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insertion</title>
</head>
<body>
    <h1>Insertion script</h1>
    <?php
    include "Donnees.inc.php";


  // Fonction pour obtenir l'ID d'un aliment dans la table FoodHierarchy
  function getFoodId($foodName, $conn)
  {
      $sql = "SELECT food_id FROM FoodHierarchy WHERE name = :foodName";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':foodName', $foodName, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
          return $result['food_id'];
      } else {
          // Insérer l'aliment s'il n'existe pas encore
          $sql = "INSERT INTO FoodHierarchy (name) VALUES (:foodName)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':foodName', $foodName, PDO::PARAM_STR);
          $stmt->execute();
          return $conn->lastInsertId();
      }
  }

  try {
    $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");

    // Insertion des données de la hiérarchie des aliments
    foreach ($Hierarchie as $categoryName => $categoryData) {
        if (isset($categoryData['sous-categorie']) && is_array($categoryData['sous-categorie'])) {
            foreach ($categoryData['sous-categorie'] as $subCategoryName) {
                $parentId = getFoodId($categoryName, $conn);
                $childId = getFoodId($subCategoryName, $conn);

                // Insérer la relation de hiérarchie
                $sql = "INSERT INTO HierarchyRelationships (parent_food_id, child_food_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$parentId, $childId]);
            }
        }
    }


    // Insertion des données des recettes
    foreach ($Recettes as $recipe) {
        $title = $recipe['titre'];
        $ingredients = $recipe['ingredients'];
        $preparation = $recipe['preparation'];
        $index = implode(', ', $recipe['index']); // Concaténez les éléments de l'index

        // Insérer la recette
        $sql = "INSERT INTO Recipes (title, ingredients, preparation, food_index) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $ingredients, $preparation, $index]);

    }

    $sql = "SELECT title, food_index, ingredients, preparation FROM recipes";
    $result = $conn->query($sql);
    $result->setFetchMode(PDO::FETCH_ASSOC);

    // Pour chaque recette
    while ($row = $result->fetch()) {
        // Afficher le nom de la recette
        $ingredients = explode(",", $row['food_index']);
        foreach ($ingredients as $ingredient) {
            $sql2 = "SELECT nom from ingredients where nom = :ingredient";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bindParam(':ingredient', $ingredient, PDO::PARAM_STR);
            $stmt2->execute();
            $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($result2) {
                echo "L'ingrédient ".$ingredient." existe déjà dans la base de données";
            } else {
                $sql3 = "INSERT INTO ingredients (nom) VALUES (:ingredient)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bindParam(':ingredient', $ingredient, PDO::PARAM_STR);
                $stmt3->execute();
                echo "L'ingrédient ".$ingredient." a été ajouté à la base de données";
            }
        }

    }



    } catch (PDOException $e) {
        // tenter de réessayer la connexion après un certain délai, par exemple
        echo "Erreur !: " . $e->getMessage() . "<br/>";

    } finally {
        $conn = null;
    }

?>

</body>
</html>
<!DOCTYPE html>
