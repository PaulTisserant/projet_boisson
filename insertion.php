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
    //include "connect.php";

    /**
    * Ingredient = (id_ing VARCHAR(50), nom VARCHAR(50));
    * Recette = (id_rec VARCHAR(50), nom_rec VARCHAR(50), preparation VARCHAR(500));
    * SousCategorie = (id_sousCat VARCHAR(50), nom_sousCat VARCHAR(50));
    * SuperCategorie = (id_supCat VARCHAR(50), nom_supCat VARCHAR(50));
    * Quantite = (id_quant VARCHAR(50), quantite VARCHAR(50), #id_ing);
    * rangeDansSupCat = (#id_sousCat, #id_supCat);
    * Composee = (#id_ing, #id_rec);
    * rangeDansSousCat = (#id_ing, #id_sousCat);
    */

    try {
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
        foreach($Hierarchie as $sousCateg => $value){
            $conteur1 = 1;
            echo "<h2>$sousCateg</h2>";
            
            $nom_sousCat = $sousCateg;
            // insert into SousCategorie values (1, 'test');
            $sql = "insert into SousCategorie values ($conteur1, '$nom_sousCat');";
            $conn->exec($sql);
            
    
            foreach($value as $superCateg => $value2){
                $conteur2 = 1;
                echo "<h3>$superCateg</h3>";
                
                $nom_supCat = $value2;
                // insert into SuperCategorie values (1, 'test');
                $sql = "insert into SuperCategorie values ($conteur2, '$value2');";
                $conn->exec($sql);
                
                echo "<ul>";
    
                foreach($value2 as $ingredients){
                    $conteur3 = 1;
                    echo "<li>$ingredients</li>";
                    
                    $nom_rec = $ingredients;
                    // insert into Ingredient values (1, 'test');
                    $sql = "insert into Ingredient values ($conteur3, '$nom_rec');";
                    $conn->exec($sql);
                    
                    $conteur3++;
                }
                echo "</ul>";
                $conteur2++;
            }
            $conteur1++;
        }
    } catch (PDOException $e) {
        // tenter de réessayer la connexion après un certain délai, par exemple
        echo "Erreur !: " . $e->getMessage() . "<br/>";
    }






    ?>
</body>
</html>
<!DOCTYPE html>
