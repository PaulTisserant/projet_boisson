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

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "boissons";

    function recupererLettres($chaine) {
        $lettres = preg_replace('/_/', ' ', $chaine);
        $lettres = preg_replace('/ï/', 'i', $lettres);

        return $lettres;
    }
    function enleverExtension($chaine) {
        $lettres = preg_replace('/\.jpg|\.png/', '', $chaine);
    
        return $lettres;
    }
    function parcourirRepertoire($chemin) {
        $fichiers = array() ;
        if (is_dir($chemin)) {
            $contenu = scandir($chemin); //liste des fichiers et sous-répertoires
            foreach ($contenu as $element) {
                // Exclut les entrées "." et ".." qui représentent le répertoire courant et le répertoire parent
                if ($element != "." && $element != "..") {

                    $cheminComplet = $chemin . '/' . $element;
    
                    // Si c'est un fichier
                    if (is_file($cheminComplet)) {
                        array_push($fichiers,$element) ;
                    }
                }
            }
        return $fichiers;
        }
    } 
  // Fonction pour obtenir l'ID d'un aliment dans la table FoodHierarchy
  function getFoodId($foodName, $conn)
  {
      $sql = "SELECT food_id FROM foodhierarchy WHERE name = :foodName";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':foodName', $foodName, PDO::PARAM_STR);
      $stmt->execute();

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($result) {
          return $result['food_id'];
      } else {
          // Insérer l'aliment s'il n'existe pas encore
          $sql = "INSERT INTO foodhierarchy (name) VALUES (:foodName)";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':foodName', $foodName, PDO::PARAM_STR);
          $stmt->execute();
          return $conn->lastInsertId();
      }
  }
// fonction verifiant si la recette de la boisson a une image
function hasImage($recipe,$fichiers){
    $recipe = recupererLettres(strtolower($recipe)) ;
    foreach ($fichiers as $element) {
        $element_modif = recupererLettres(enleverExtension(strtolower($element))) ;
        echo $element_modif . "  <-" . $recipe . "<br>";
        if (strpos($recipe,$element_modif) == true  || strpos($element_modif,$recipe) == true || $element_modif === $recipe)  {
            echo "treueeeee <br>";
            return $element;
        }
    }
return "";
}
  try {

    // Connexion à MySQL sans spécifier de base de données
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Création de la base de données s'elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");

    // Connexion à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Exécution du script SQL
    $sql = file_get_contents("bdd.sql");
    $conn->exec($sql);

    echo "Le script SQL a été exécuté avec succès.";

    // si la bdd a bien été créée et que le script a bien été exécuté, on peut insérer les données
    if($conn) {
        echo "La base de données a été créée avec succès.";
    

        // Insertion des données de la hiérarchie des aliments
        foreach ($Hierarchie as $categoryName => $categoryData) {
            if (isset($categoryData['sous-categorie']) && is_array($categoryData['sous-categorie'])) {
                foreach ($categoryData['sous-categorie'] as $subCategoryName) {
                    $parentId = getFoodId($categoryName, $conn);
                    $childId = getFoodId($subCategoryName, $conn);

                    // Insérer la relation de hiérarchie
                    $sql = "INSERT INTO hierarchyrelationships (parent_food_id, child_food_id) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$parentId, $childId]);
                }
            }
        }

        $fichiers = parcourirRepertoire('Photos')  ;
        // Insertion des données des recettes
        foreach ($Recettes as $recipe) {
            $title = $recipe['titre'];
            $ingredients = $recipe['ingredients'];
            $preparation = $recipe['preparation'];
            $index = implode(', ', $recipe['index']); // Concaténez les éléments de l'index
            $image = hasImage($title,$fichiers) ;
            if($image != ""){   
                $photo_path = "Photos/". $image ;
                // Insérer la recette avec l'image
                $sql = "INSERT INTO recipes (title, ingredients, preparation,photo_path, food_index) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$title, $ingredients, $preparation,$photo_path, $index]);
            }else{
            // Insérer la recette sans l'image
            $sql = "INSERT INTO recipes (title, ingredients, preparation, food_index) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$title, $ingredients, $preparation, $index]);
            }
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

        echo "Les données ont été insérées avec succès.";

    } else {
        echo "La base de données n'a pas pu être créée.";
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
