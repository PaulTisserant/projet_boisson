<?php 
include "fonctions.php" ;
function ModifierSexe($sexe){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");

            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET gender = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Binder les valeurs des paramètres

        
            // Exécuter la requête
            $stmt->execute([$sexe,$_SESSION['user_id']]);
        
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

}
function ModifierNom($nom){
    if(verifConn()){
        echo $nom ;
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET last_name = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$nom,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le nom a été mis à jour avec succès.";
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
function ModifierPrenom($prenom){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET first_name = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$prenom,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le prenom a été mis à jour avec succès.";
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
function ModifierEmail($email){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET email = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$email,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "L'email a été mis à jour avec succès.";
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
function ModifierTel($tel){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET phone_number = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$tel,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le telephone a été mis à jour avec succès.";
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

function ModifierVille($ville){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET city = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$ville,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "La ville a été mis à jour avec succès.";
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
function ModifierCodePostal($codePostal){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET postal_code = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$codePostal,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le codePostal a été mis à jour avec succès.";
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
function ModifierAdresse($adresse){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET address = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$adresse,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "L'adresse a été mis à jour avec succès.";
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
function ModifierLogin($login){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET login = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$login,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le login a été mis à jour avec succès.";
                $_SESSION['login'] = $login; // Mise à jour du login dans la session
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
function ModifierMdp($mdp){
    if(verifConn()){
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            // Préparer la requête SQL UPDATE
            $sql = "UPDATE users SET password = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
        
            // Exécuter la requête
            $stmt->execute([$mdp,$_SESSION['user_id']]);

            // Vérifier si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                echo "Le mot de passe a été mis à jour avec succès.";
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
        if(isset($_POST['sexe'])){
            $sexe = $_POST['sexe'];
            ModifierSexe($sexe) ;
        }
        if(isset($_POST['nom']) && verifNom($_POST['nom'])){
            $nom = $_POST['nom'];
            ModifierNom($nom) ;
        }
        if(isset($_POST['prenom']) && verifPrenom($_POST['prenom'])){
            $prenom = $_POST['prenom'];
            ModifierPrenom($prenom) ;
        }
        if(isset($_POST['email']) && verifMail($_POST['email'])){
            $email = $_POST['email'];
            ModifierEmail($email) ;
        }
        if(isset($_POST['tel']) && verifTel($_POST['tel'])){
            $tel = $_POST['tel'];
            ModifierTel($tel) ;
        }
        if(isset($_POST['ville']) && verifVille($_POST['ville'])){
            $ville = $_POST['ville'];
            ModifierVille($ville) ;
        }
        if(isset($_POST['codePostal']) && verifCodePostal($_POST['codePostal'])){
            $codePostal = $_POST['codePostal'];
            ModifierCodePostal($codePostal) ;
        }
        if(isset($_POST['adresse'])){
            $adresse = $_POST['adresse'];
            ModifierAdresse($adresse) ;
        }
        if(isset($_POST['login']) && verifLogin($_POST['login'])){
            $login = $_POST['login'];
            ModifierLogin($login) ;
        }
        if(isset($_POST['mdp']) && verifMdp($_POST['mdp'])){
            $mdp = $_POST['mdp'];
            ModifierMdp($mdp) ;
        }
    }else{
    echo "no http" ;
    }
}







?>