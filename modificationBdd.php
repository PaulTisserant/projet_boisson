<?php 
include "fonction.php" ;
function ModifierSexe($sexe){
    try {
        $conn = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'votre_nom_utilisateur', 'votre_mot_de_passe');

        // Préparer la requête SQL UPDATE
        $sql = "UPDATE utilisateurs SET sexe = :nouveau_sexe WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
    
        // Binder les valeurs des paramètres
        $stmt->bindParam(':nouveau_sexe', $sexe, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
        // Exécuter la requête
        $stmt->execute();
    
        // Vérifier si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            echo "Le sexe a été mis à jour avec succès.";
        } else {
            echo "Aucune mise à jour effectuée. L'ID de l'utilisateur pourrait ne pas exister.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    } finally {
        $conn = null;
    }



}
function ModifierNom($nom){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=nom_de_votre_base_de_donnees', 'votre_nom_utilisateur', 'votre_mot_de_passe');

            // Préparer la requête SQL UPDATE
            $sql = "UPDATE utilisateurs SET first_name = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute($nom,$_SESSION['user_id']);
        
            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le sexe a été mis à jour avec succès.";
            } else {
                echo "Aucune mise à jour effectuée. L'ID de l'utilisateur pourrait ne pas exister.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }{
        echo "Connexion impossible";
    }


}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {        
        echo "resquets" ;
        if(isset($_POST['sexe'])){
            $sexe = $_POST['sexe'];
            ModifierSexe($sexe) ;
        }
        if(isset($_POST['nom'])){
            echo "nom" ;
            $nom = $_POST['nom'];
            ModifierNom($nom) ;
        }
    }else{


    echo "no http" ;
    }
}







?>