<?php 
function verifConn() {
    // Fonction qui verrifie si un utilisateur est connecté
    session_start();

        if (isset($_SESSION['user_id']) && isset($_SESSION['login'])) {
            
            try {
                $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
                $sql = "SELECT user_id FROM users WHERE login = ? AND user_id =?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$_SESSION['login'], $_SESSION['user_id']]);               
                 // Si une ligne est retournée, le login existe
                if ($stmt->rowCount() > 0) {   
                    // L'utilisateur est connecté
                    return true ;                
                }else{
                    return false ;
                }

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            } finally {
                $conn = null;
            }
        }
    return false;
}
function deconnexion(){
    session_start();
    session_unset();
    session_destroy();
}
function afficherMotDePasse($mdp){
    $txt = "";
    for ($i=0; $i < strlen($mdp); $i++) { 
        $txt = $txt . "*";
    }
    return $txt;
}

?>