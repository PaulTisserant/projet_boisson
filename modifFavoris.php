<?php 
include 'bddConnexion.php';
include_once "fonctions.php" ;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {        
        if(isset($_POST['modifFav'])){
            $id = $_POST['modifFav'];
            changerFav($id) ;
        }
    }
}


function changerFav($id){
 if(verifConn()){
    try {
        echo "connecte" ;
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isFavorite($id)){
            echo "favorite" ;

            $stmt = $conn->prepare("DELETE FROM favoriterecipes WHERE recipe_id =? AND user_id =?");
            $stmt->execute([$id,$_SESSION['user_id']]);
            if ($stmt->rowCount() > 0) {   
                // La recette a bien été supprimée dans les favoris
                return true ;                
            }else{
                return false ;
            }
        }else{
            echo " no favorite" ;
            $stmt = $conn->prepare("INSERT INTO favoriterecipes (recipe_id, user_id) VALUES (?,?)");
            $stmt->execute([$id,$_SESSION['user_id']]);
            if ($stmt->rowCount() > 0) {   
                // La recette a bien ete ajoutée dans les favoris
                return true ;                
            }else{
                return false ;
            }
        }

    }catch (PDOException $e) {
        echo "Erreur : " . $e->GETMessage();
        return false ;
    }

 }else{
    if(isset($_SESSION['favorite'])){
        if(in_array($id,$_SESSION['favorite'] )){
            $pos = array_search($id, $_SESSION['favorite']);
            unset($_SESSION['favorite'][$pos]);
            return true ;
        }else{
            array_push($_SESSION['favorite'],$id);
            return true ;

        }
    }else{
        $_SESSION['favorite'] = array() ;
    }
 }
 return false ;

}
?>