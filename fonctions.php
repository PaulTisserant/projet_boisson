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
function verifPrenom($pre){
    if(strlen($pre) > 0 ){
        if(preg_match('/\d/',$pre)){
            return false ;
        }
    }
    return true;
}
function verifNom($pre){
    if(strlen($pre) > 0 ){
        if(preg_match('/\d/',$pre)){
            return false ;
        }
    }
    return true;
}
function verifMail($mail){
    if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i',$mail ))
    {
         return true ;
    }
    return false;
}
function verifTel($tel){
    if(strlen($tel) > 0 ){
        if(!preg_match('/(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}/',$tel)){
            return false ;
        }
    }
    return true ;
}
function verifVille($ville){
    if(strlen($ville) > 0 ){
        if(!preg_match('/^[a-zA-Z-]*$/',$ville)){
            return false ;
        }
    }
    return true ;
}
function verifCodePostal($post){
    if(strlen($post) > 0 ){
        if(!preg_match('/^[0-9]{5}$/',$post)){
            return false ;
        }
    }
    return true ;
}
function verifMdp($mdp){
    if(!preg_match('/.{8,}/',$mdp)){
        return false ;
    }
    elseif(!preg_match('/[A-Z]{1,}/',$mdp)){
        return false ;
    }
return true ;
}
function verifLogin($login){
    if(!preg_match('/.{5,}/',$login)){
        return false ;
    }
        //Verification si le login est disponible
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $sql = "SELECT user_id FROM users WHERE login = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$login]);
            // Si une ligne est retournée, le login existe
            if ($stmt->rowCount() > 0) {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }    
return true ;
}
?>