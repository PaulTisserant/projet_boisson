<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>

<?php  
// definition des varaiables
$prenom = TRUE ;
$nom = TRUE ;
$email = TRUE ;
$sexe = TRUE ;
$ville = TRUE ;
$codePostal = TRUE ;
$adresse = TRUE ;
$naissance = TRUE ;
$motDePasse = TRUE ;
$login = TRUE ;
$telephone = TRUE ;
$mdp_SizeError = FALSE ;
$login_SizeError = FALSE ;
$login_ExistError = FALSE ;

$mdp_EqualsError = FALSE ;
$mdp_UpperError = FALSE ;

//Verification des donnees
if($_POST['Submit']){
    //Verif NOM
    if(isset($_POST['Nom'])){
         $pre = $_POST['Nom'] ;
         //Verification si l'utiliateur a remplis le champ Nom
        if(strlen($pre) > 0 ){
            if(preg_match('/\d/',$pre)){
                $nom = FALSE ;
            }
        }
    }
    //Verif PRENOM
    if(isset($_POST['Prenom'])){
        $pre = $_POST['Prenom'] ;
        //Verification si l'utiliateur a remplis le champ Prenom
       if(strlen($pre) > 0 ){
           if(preg_match('/\d/',$pre)){
               $prenom = FALSE ;
           }
       }
    }
    //Verif EMAIL
    if(isset($_POST['email'])){
        $mail = $_POST['email'] ;
        //Verification si l'utiliateur a remplis le champ Email
       if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i',$var_mail ))
       {
            $email = FALSE ;
       }
    }
    //Verif Telephone
    if(isset($_POST['telephone'])){
        $tele = $_POST['telephone'] ;
        //Verification si l'utiliateur a remplis le champ CodePostal
        if(strlen($tele) > 0 ){
            if(!preg_match('/^[0-9]*$/',$tele)){
                $telephone = FALSE ;
            }
        }
    }
    //Verif VILLE
    if(isset($_POST['ville'])){
        $vil = $_POST['ville'] ;
        //Verification si l'utiliateur a remplis le champ Villle
       if(strlen($vil) > 0 ){
           if(!preg_match('/^[a-zA-Z]*$/',$vil)){
               $ville = FALSE ;
           }
       }
    }
    //Verif CodePostal
    if(isset($_POST['Postal'])){
        $post = $_POST['Postal'] ;
        //Verification si l'utiliateur a remplis le champ CodePostal
        if(strlen($post) > 0 ){
            if(!preg_match('/^[0-9]*$/',$post)){
                $codePostal = FALSE ;
            }
        }
    }

    //Verif Sexe
    if (isset($_POST['sexe'])) {
        if (!($_POST['sexe'] ==  'F' || $_POST['sexe'] == 'H')) {
            $sexe=FALSE ;
        }
    }
    //Verif Date Naissance
    if (isset($_POST['naissance'])) {
        $date=$_POST['naissance'] ;
        if (!(checkdate(date("m",strtotime($date) ), date("d",strtotime($date) ), date("Y",strtotime($date) )))) {
          $naissance=FALSE ;
        }
    }

    //Verif Login
    if(isset($_POST['Login'])){
        $log = $_POST['Login'] ;
        //Verification si l'utiliateur a remplis le champ Login avec au moins 5 caracteres
        if(!preg_match('/.{5,}/',$log) ){
                $login = FALSE ;
                $login_SizeError = TRUE ;

        }
        //Verification si le login est disponible
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            
            // Utilisation de requête préparée pour éviter les attaques par injection SQL
            $sql = "SELECT user_id FROM users WHERE login = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$log]);
            // Si une ligne est retournée, le login existe
            if ($stmt->rowCount() > 0) {
                $login= FALSE ;
                $login_ExistError = TRUE ;
            }
        
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
    }    

    //Verif Mot De Passe
    if(isset($_POST['MDP']) && isset($_POST['MDP_confirm'])){
        $log = $_POST['Login'] ;
        $mdp1 = $_POST['MDP'] ; 
        $mdp2 = $_POST['MDP_confirm'] ; 
        //Verification si l'utiliateur a remplis le champ MDP avec au moins 8 caracteres
        if(!preg_match('/.{8,}/',$mdp1)){
                $motDePasse = FALSE ;
                $mdp_SizeError = TRUE ; 
        }
        elseif(!preg_match('/[A-Z]{1,}/',$mdp1)){
            $mdp_UpperError = TRUE ;
            $motDePasse = FALSE ;
        }
        elseif(!($mdp1 === $mdp2)){
                $motDePasse = FALSE ; 
                $mdp_EqualsError = TRUE ; 
        }
    }
    }  
?>

    <h1>Inscription</h1>
    <form style="align-content: center;"  method="post" action="#" >
        <span <?php if(!$login){ echo 'style="color: red;"';} ?> ><strong> Login </strong> 
        <?php 
        if($login_SizeError){ echo '<span style="color: red;font-size: 12px;"> (Erreur le login doit faire au moins 5 caractères)</span>';}
        elseif ($login_ExistError) echo '<span style="color: red;font-size: 12px;"> (Erreur le login existe déjà)</span>';
        ?>
        <br>
        <input type="text" name="Login"  > </span>
        <br>
        <span <?php if(!$motDePasse){ echo 'style="color: red;"';} ?>><strong>Mot de passe :</strong> 
        <?php 
        if($mdp_SizeError == TRUE){ echo '<span style="color: red;font-size: 12px;"> (Erreur le mot de passe doit faire au moins 8 caractères)</span>';
        }elseif ($mdp_UpperError == TRUE) {  echo '<span style="color: red;font-size: 12px;"> (Erreur le mot de passe doit avoir au moins 1 majuscule)</span>';
        }elseif($mdp_EqualsError == TRUE){ echo '<span style="color: red;font-size: 12px;"> (Erreur lors de la confirmation du mot de passe)</span>';
        } 
        ?>
        <br> 
        <input type="password" name="MDP"   > </span>
        <br>
        <span <?php if(!$motDePasse){ echo 'style="color: red;"';} ?>><strong>Confirmer Mot de passe : </strong>
        <br>
        <input type="password" name="MDP_confirm"   ></span>
        <br>
        <h3>Informations Optionnelles</h3>
        <table>
            <tr>
                <td >
                    <span <?php if(!$nom){ echo 'style="color: red;"';} ?>><strong> Nom </strong> </span> <?php if(!$nom){ echo '<span style="color: red;font-size: 12px;"> (Erreur Nom)</span>';} ?>
                </td>
                <td>
                    <span <?php if(!$prenom){ echo 'style="color: red;"';} ?>><strong> Prenom </strong> </span> <?php if(!$prenom){ echo '<span style="color: red;font-size: 12px;"> (Erreur Prenom)</span>';} ?>
                </td>

            </tr>
            <tr>
                <td>
                    <span><input type="text" name="Nom"  ></span>
                </td>
                <td>
                    <span><input type="text" name="Prenom"  ></span>
                </td>
            </tr>
        </table>
        <span <?php if(!$sexe){ echo 'style="color: red;"';} ?>><strong>Sexe  :</strong><br> <input type="radio" name="sexe" value="F">Femme
        <input type="radio" name="sexe" value="H">Homme  <br>
    </span>
        <span <?php if(!$email){ echo 'style="color: red;"';} ?>><strong>Email :</strong> <?php if(!$email){ echo '<span style="color: red;font-size: 12px;"> (Erreur EMAIL)</span>';} ?>
        <br>
         <input type="email" name="email"> </span>
        <br>
        <span <?php if(!$telephone){ echo 'style="color: red;"';} ?>><strong>Telephone :</strong> <?php if(!$telephone){ echo '<span style="color: red;font-size: 12px;"> (Erreur  numero de telephone)</span>';} ?>
        <br> 
        <input type="tel" name="telephone"> </span>
        <br>
        <span <?php if(!$naissance){ echo 'style="color: red;"';} ?>><strong>Date de naissance :</strong> <br> <input type="date" name="naissance" > </span>
        <br>
        <span ><strong>Adresse </strong><br> <input type="" name="adresse" > </span>
        <br>
        <span <?php if(!$ville){ echo 'style="color: red;"';} ?>><strong>Ville </strong> <?php if(!$ville){ echo '<span style="color: red;font-size: 12px;"> (Erreur Ville)</span>';} ?>
        <br>
        <input type="text" name="ville" > </span>
        <br>
        <span <?php if(!$codePostal){ echo 'style="color: red;"';} ?>><strong>Code postal </strong> <?php if(!$codePostal){ echo '<span style="color: red;font-size: 12px;"> (Erreur CodePostal)</span>';} ?>
        <br>
         <input type="text" name="Postal" maxlength="5" >  </span>
        <br>
        <input type="submit" name="Submit" value="Valider">

    </form>

<?php  
if($_POST['Submit']){
    if (($prenom==TRUE) && ($nom==TRUE)  && ($email==TRUE)  && $sexe==TRUE  && $ville==TRUE  && $codePostal==TRUE  && $adresse==TRUE  && $naissance==TRUE  && $motDePasse==TRUE  && $login==TRUE  && $telephone==TRUE ){
        $prenom = isset($_POST['Prenom']) ? $_POST['Prenom'] : null;
        $nom_bdd = isset($_POST['Nom']) ? $_POST['Nom'] : null;
        $email_bdd = isset($_POST['email']) ? $_POST['email'] : null;
        $sexe_bdd = isset($_POST['sexe']) ? $_POST['sexe'] : null;
        $ville_bdd = isset($_POST['ville']) ? $_POST['ville'] : null;
        $codePostal_bdd = isset($_POST['Postal']) ? $_POST['Postal'] : null;
        $adresse_bdd = isset($_POST['adresse']) ? $_POST['adresse'] : null;
        $naissance_bdd = isset($_POST['naissance']) ? date('Y-m-d', strtotime($_POST['naissance'])) : null;
        $motDePasse_bdd = isset($_POST['MDP']) ? $_POST['MDP'] : null;
        $login_bdd = isset($_POST['Login']) ? $_POST['Login'] : null;
        $telephone_bdd = isset($_POST['telephone']) ? $_POST['telephone'] : null;
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $sql = "INSERT INTO users (login, password, first_name, last_name, gender, email, birthdate, address, postal_code, city, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$login_bdd, $motDePasse_bdd, $nom_bdd, $prenom_bdd, $sexe_bdd, $email_bdd, $naissance_bdd, $adresse_bdd, $codePostal_bdd, $ville_bdd, $telephone_bdd]);
        } catch (PDOException $e) {
            echo "Erreur !: " . $e->getMessage() . "<br/>";
            } finally {
                $conn = null;
            }
    }
}

?>

</body>
</html>
