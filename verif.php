<?php
        //Verification si le login est disponible
    if(isset($_POST['maVariable'])){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $sql = "SELECT user_id FROM users WHERE login = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_POST['maVariable']]);
            // Si une ligne est retournée, le login existe
            if ($stmt->rowCount() > 0) {
                echo "False";
            }else {
                echo "True";
            }

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }
?>