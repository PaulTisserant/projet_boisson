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

    // Récupérer l'ID de la recette insérée
    $recipeId = $conn->lastInsertId();

    // Vérifier si la recette a une photo
    if (isset($recipe['photo'])) {
        $photo = $recipe['photo'];

        // Insérer la photo de la recette
        $sql = "INSERT INTO RecipePhotos (recipe_id, photo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$recipeId, $photo]);
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
