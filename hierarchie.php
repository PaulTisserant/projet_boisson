<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display hierarchie</title>
</head>
<body>

    <?php
    // Inclure le fichier de connexion à la base de données
    
    try {
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");

        // afficher tous les ingredients et leurs parents
        $sql = "SELECT distinct(parent_food_id) FROM hierarchyrelationships where parent_food_id not in (select child_food_id from hierarchyrelationships)";
        $result = $conn->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        // Pour chaque id de parent afficher le nom de l'ingredient
        while ($row = $result->fetch()) {
            $sql2 = "SELECT name FROM foodhierarchy WHERE food_id = ".$row['parent_food_id'];
            $result2 = $conn->query($sql2);
            $result2->setFetchMode(PDO::FETCH_ASSOC);
            while ($row2 = $result2->fetch()) {
                echo "<h1>" . $row2['name'] . "</h1>";

                // afficher tous ses enfants
                $sql3 = "SELECT child_food_id FROM hierarchyrelationships WHERE parent_food_id = ".$row['parent_food_id'];
                $result3 = $conn->query($sql3);
                $result3->setFetchMode(PDO::FETCH_ASSOC);
                while ($row3 = $result3->fetch()) {
                    $sql4 = "SELECT name FROM foodhierarchy WHERE food_id = ".$row3['child_food_id'];
                    $result4 = $conn->query($sql4);
                    $result4->setFetchMode(PDO::FETCH_ASSOC);
                    echo "<ul>";
                    while ($row4 = $result4->fetch()) {
                        echo "<li>" . $row4['name'] . "</li>";
                    }
                    echo "</ul>";
                }
            }
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    


    ?>
        
</body>
</html>