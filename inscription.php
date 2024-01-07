<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="inscription.css">
    <link rel="stylesheet" type="text/css" href="header.css">

</head>
<body>
    <?php
function move_to(){
echo "<script>window.top.location='compte.php'</script>" ;
ob_end_flush();
exit ;
}


session_start();

include "fonctions.php" ;

if(verifConn()){
deconnexion() ;
echo "<script>alert('Deconnexion reussis');</script>" ;
}
?>
<script>
        var label_nom = document.createElement("label");
        label_nom.textContent = "(Erreur Le nom est obligatoire)" ;
        label_nom.style.fontSize = "10px" ;
        label_nom.style.color = "red" ;

        var label_prenom = document.createElement("label");

        label_prenom.textContent = "(Erreur Le prenom est obligatoire)" ;
        label_prenom.style.fontSize = "10px" ;
        label_prenom.style.color = "red" ;

        var label_email = document.createElement("label");
        label_email.textContent = "(Erreur Email incorrect)" ;
        label_email.style.fontSize = "10px" ;
        label_email.style.color = "red" ;

        label_tel = document.createElement("label");
        label_tel.textContent = "(Erreur Le nom est obligatoire)" ;
        label_tel.style.fontSize = "10px" ;
        label_tel.style.color = "red" ;

        label_ville = document.createElement("label");
        label_ville.textContent = "(Erreur Le nom est obligatoire)" ;
        label_ville.style.fontSize = "10px" ;
        label_ville.style.color = "red" ;

        label_codePostal = document.createElement("label");
        label_codePostal.textContent = "(Erreur Le nom est obligatoire)" ;
        label_codePostal.style.fontSize = "10px" ;
        label_codePostal.style.color = "red" ;

        label_login = document.createElement("label");
        label_login.textContent = "(Erreur Le nom est obligatoire)" ;
        label_login.style.fontSize = "10px" ;
        label_login.style.color = "red" ;

        label_mdp = document.createElement("label");
        label_mdp.textContent = "(Erreur Le nom est obligatoire)" ;
        label_mdp.style.fontSize = "10px" ;
        label_mdp.style.color = "red" ;

    function handleBlurNom() {

    var button = document.getElementById("button");

        var nom_input = document.getElementById("nom_input");
        var nom = document.getElementById("nom") ;
        if ( /\d/.test(nom_input.value) ) {
            if(!nom.contains(label_nom)){
                label_nom.textContent = "(Le nom ne dois pas contenir de chiffres)" ;
                nom.appendChild(label_nom) ;
            }
            console.log("error nom");
            nom.style.color = "red" ;  
            return false ;
        }else{
            if(nom.contains(label_nom)){
                nom.removeChild(label_nom) ;
            }
            nom.style.color = "black" ;
            return true ;

        }
    }
    function handleBlurPrenom() {
        var button = document.getElementById("button");
        var prenom_input = document.getElementById("prenom_input");
        var prenom = document.getElementById("prenom");
        if ( /\d/.test(prenom_input.value)) {
            if (!prenom.contains(label_prenom)) {
                label_prenom.textContent = "(Le prenom ne dois pas contenir de chiffres)" ;
                prenom.appendChild(label_prenom);
            }
            console.log("error prenom");
            prenom.style.color = "red";
            return false;

        } else {
            if (prenom.contains(label_prenom)) {
                prenom.removeChild(label_prenom);
            }
            prenom.style.color = "black";
            return true;

        }
    }
    function handleBlurEmail() {
        var button = document.getElementById("button");
        var email_input = document.getElementById("email_input");
        var email = document.getElementById("email");
        var emailReg = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))/i);

        if (emailReg.test(email_input.value)) {
            if (!email.contains(label_email)) {
                label_email.textContent = "(Le format de l'adresse email est incorrect)" ;
                email.appendChild(label_email);
            }
            console.log("error mail");
            email.style.color = "red";
            return false;
        } else {
            if (email.contains(label_email)) {
                email.removeChild(label_email);
            }
            email.style.color = "black";
            return true;
        }
    }  
    function handleBlurVille() {
        var button = document.getElementById("button");
        var ville_input = document.getElementById("ville_input");
        var ville = document.getElementById("ville");

        if (! /^[a-zA-Z-]*$/.test(ville_input.value)) {
            if (!ville.contains(label_ville)) {
                label_ville.textContent = "(Le nom d'une ville ne doit contenir que des lettres et des tirets)" ;
                ville.appendChild(label_ville);
            }
            console.log("error ville");
            ville.style.color = "red";
            return false;
        } else {
            if (ville.contains(label_ville)) {
                ville.removeChild(label_ville);
            }
            ville.style.color = "black";
            return true;
        }
    } 
    function handleBlurCodePostal() {
        var button = document.getElementById("button");
        var codePostal_input = document.getElementById("codePostal_input");
        var codePostal = document.getElementById("codePostal");

        if (!/^.{0}$/.test(codePostal_input.value)  && !/\d{5}/.test(codePostal_input.value)) {
            if (!codePostal.contains(label_codePostal)) {
                label_codePostal.textContent = "(Le code postal ne doit contenir que 5 chiffres)" ;
                codePostal.appendChild(label_codePostal);
            }
            codePostal.style.color = "red";
            console.log("error postal");
            return false;
        } else {
            if (codePostal.contains(label_codePostal)) {
                codePostal.removeChild(label_codePostal);
            }
            codePostal.style.color = "black";
            return true;
        }
    }
    function handleBlurTel() {
        var tel_input = document.getElementById("tel_input");
        var tel = document.getElementById("tel");

        if ( !/^.{0}$/.test(tel_input.value)  && !/(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}/.test(tel_input.value)) {
            if (!tel.contains(label_tel)) {
                label_tel.textContent = "(Le format du numero de telephone est incorrect)" ;
                tel.appendChild(label_tel);
            }
            console.log("error tel");
            tel.style.color = "red";
            return false;
        } else {
            if (tel.contains(label_tel)) {
                tel.removeChild(label_tel);
            }
            tel.style.color = "black";
            return true;
        }
    }
    function handleBlurLogin() {
        var login_input = document.getElementById("login_input");
        var login = document.getElementById("login");

        $.ajax({
        type: "POST",
        url: "verif.php",  // Assurez-vous de spécifier le chemin correct vers votre script PHP
        data: { 
            maVariable: login_input.value 
        },        success: function(response) {
            console.log("Succès :", response);
            if (response == "False") {
                if (!login.contains(label_login)) {
                    label_login.textContent = "(Ce login est déjà utilisé)" ;
                    login.appendChild(label_login);
                }
                console.log("error login");
                login.style.color = "red";
                return false;
            }
        },
        error: function(error) {
            console.error("Erreur :", error);
        }
    });
        if (!/.{5,}/.test(login_input.value)) {
            if (!login.contains(label_login)) {
                label_login.textContent = "(Le login doit contenir au moins 5 caractères)" ;
                login.appendChild(label_login);
            }
            console.log("error login");
            login.style.color = "red";
            return false;
        } else {
            if (login.contains(label_login)) {
                login.removeChild(label_login);
            }
            login.style.color = "black";
            return true;
        } 
    }    
    function handleBlurMdp() {
        var mdp_input = document.getElementById("mdp_input");
        var mdp_confirm_input = document.getElementById("mdp_confirm_input");
        var mdp = document.getElementById("mdp");

        if (!(/.{8,}/.test(mdp_input.value ))|| !/[A-Z]{1,}/.test(mdp_input.value)   ) {
            if (!mdp.contains(label_mdp)) {
                label_mdp.textContent = "(Le mot de passe doit contenir au moins 8 caractères et une majuscule)" ;
                mdp.appendChild(label_mdp);
            }
            console.log("error MDP");
            mdp.style.color = "red";
            return false;
        } else if (!(mdp_confirm_input.value === mdp_input.value)) {
            if (!mdp.contains(label_mdp)) {
                label_mdp.textContent = "(La confirmation du mot de passe ne correspond pas)" ;
                mdp.appendChild(label_mdp);
            }
            console.log("error MDP");
            mdp.style.color = "red";
            return false;

        }else{
            if (mdp.contains(label_mdp)) {
                mdp.removeChild(label_mdp);
            }
            mdp.style.color = "black";
            return true;
        }

    }
    function verifAll() {
        handleBlurNom() ;  
        handleBlurPrenom();  
        handleBlurEmail();
        handleBlurTel();
        handleBlurVille();
        handleBlurCodePostal();
        handleBlurMdp();
        handleBlurLogin();
        if(handleBlurNom()==true && handleBlurPrenom()==true && handleBlurEmail()==true && handleBlurTel()==true && handleBlurVille()==true && handleBlurCodePostal()==true && handleBlurMdp()==true && handleBlurLogin()==true ) {
            //Faire un submit
            alert('submit') ;
            document.getElementById("form_insc").submit('Submit');
        }else{
            alert("Veuillez remplir correctement tous les champs") ;
        }
    }


</script>
<?php  include "header.php"?>

    <div class="conteneur" style="align-self: center;">




    <form style="align-content: center;" id="form_insc"  method="post" action="#" > 
    <h1>S'inscrire</h1>

    <h3>Information Optionel :</h3>
    <label id="nom" >Nom :</label>
  
    <input name="nom_input" id ="nom_input" type="text"  onblur="handleBlurNom()">
    <label id="prenom" >Prenom :</label>
    <input name="prenom_input" id ="prenom_input" type="text" onblur="handleBlurPrenom()" >
    <br>
    <label id="sexe" >Civilite :</label> 
    <br>
    <input type="radio" name="sexe" value="F">Femme
    <input type="radio" name="sexe" value="H">Homme  
    <br>
    <label id="email" >Email :</label>
    <input name ="email_input" id ="email_input" type="email" onblur="handleBlurEmail()" >
    <br>
    <label id="tel" >Numero de telephone :</label>
    <input name ="tel_input" id ="tel_input" type="text" maxlength="10" onblur="handleBlurTel()" >
    <br>
    <label id="ville" >Ville :</label>
    <input name ="ville_input" id ="ville_input" type="text" onblur="handleBlurVille()" >
    <br>
    <label id="codePostal" >Code Postal :</label>
    <input name ="codePostal_input" id ="codePostal_input" type="text" maxlength="5" onblur="handleBlurCodePostal()" >
    <br>
    <label id="adresse" >Adresse :</label>
    <input name="adresse_input" id ="adresse_input" type="text" >
    <br>

    <h3 >Information Obligatoire : </h3>
    <label id="login" >Login :</label>
    <input name="login_input" id ="login_input" type="text" onblur="handleBlurLogin()" >
    <br>

    <label id="mdp" >Mot de passe :</label>
    <input name="mdp_input" id ="mdp_input" type="password"  onblur="handleBlurMdp()">
    <br>
    <label id="mdp_confirm" > Confirmation Mot de passe :</label>
    <input name="mdp_confirm_input"id ="mdp_confirm_input" type="password" onblur="handleBlurMdp()" >
    <br>
    <button id = "button" type="button" onclick="verifAll()">S'inscrire</button>

   
    </form>
</div>
<?php
// definition des variables
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
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //Verif NOM
    if(isset($_POST['nom_input'])){
         $pre = $_POST['nom_input'] ;
         if(strlen($var_mail) > 0){
            //Verification si l'utiliateur a remplis le champ Nom
            if(!verifNom($pre)){
                $nom = FALSE ;
            }
        }
    }
    //Verif PRENOM
    if(isset($_POST['prenom_input'])){
        $pre = $_POST['prenom_input'] ;
        //Verification si l'utiliateur a remplis le champ Prenom
        if(strlen($pre) > 0){
           if(!verifPrenom($pre)){
               $prenom = FALSE ;
           }
        }
       
    }
    //Verif EMAIL
    if(isset($_POST['email_input'])){
        $mail = $_POST['email_input'] ;
        //Verification si l'utiliateur a remplis le champ Email
        if(strlen($var_mail) > 0){
            if(!verifMail($var_mail))
            {
                    $email = FALSE ;
            }
        }
    }
    //Verif Telephone
    if(isset($_POST['tel_input'])){
        $tele = $_POST['tel_input'] ;
        //Verification si l'utiliateur a remplis le champ telephone
        if(strlen($tele) > 0 ){
            if(!verifTel($tele)){
                    $telephone = FALSE ;
                }
        }
        
    }
    //Verif VILLE
    if(isset($_POST['ville_input'])){
        $vil = $_POST['ville_input'] ;
        //Verification si l'utiliateur a remplis le champ Ville
       if(strlen($vil) > 0 ){
           if(!verifVille($vil)){
               $ville = FALSE ;
           }
       }
    }
    //Verif CodePostal
    if(isset($_POST['codePostal_input'])){
        $post = $_POST['codePostal_input'] ;
        //Verification si l'utiliateur a remplis le champ CodePostal
        if(strlen($post) > 0 ){
            if(!verifCodePostal($post)){
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
    if(isset($_POST['login_input'])){
        $log = $_POST['login_input'] ;
        //Verification si l'utiliateur a remplis le champ Login avec au moins 5 caracteres
        if(!preg_match('/.{5,}/',$log) ){
                $login = FALSE ;
                $login_SizeError = TRUE ;

        }
        //Verification si le login est disponible
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
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
    if(isset($_POST['mdp_input']) && isset($_POST['mdp_confirm_input'])){
        $mdp1 = $_POST['mdp_input'] ;
        $mdp2 = $_POST['mdp_confirm_input'] ;
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
if(($_SERVER["REQUEST_METHOD"] == "POST")){
    if (($prenom==TRUE) && ($nom==TRUE)  && ($email==TRUE)  && $sexe==TRUE  && $ville==TRUE  && $codePostal==TRUE  && $adresse==TRUE  && $naissance==TRUE  && $motDePasse==TRUE  && $login==TRUE  && $telephone==TRUE ){
        $prenom_bdd = isset($_POST['prenom_input']) ? $_POST['prenom_input'] : null;
        $nom_bdd = isset($_POST['nom_input']) ? $_POST['nom_input'] : null;
        $email_bdd = isset($_POST['email_input']) ? $_POST['email_input'] : null;
        $sexe_bdd = isset($_POST['sexe']) ? $_POST['sexe'] : null;
        $ville_bdd = isset($_POST['ville_input']) ? $_POST['ville_input'] : null;
        $codePostal_bdd = isset($_POST['codePostal_input']) ? $_POST['codePostal_input'] : null;
        $adresse_bdd = isset($_POST['adresse_input']) ? $_POST['adresse_input'] : null;
        $naissance_bdd = isset($_POST['naissance_input']) ? date('Y-m-d', strtotime($_POST['naissance_input'])) : null;
        $motDePasse_bdd = isset($_POST['mdp_input']) ? $_POST['mdp_input'] : null;
        $login_bdd = isset($_POST['login_input']) ? $_POST['login_input'] : null;
        $telephone_bdd = isset($_POST['tel_input']) ? $_POST['tel_input'] : null;

        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $hashedPassword = password_hash($motDePasse_bdd, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (login, password, first_name, last_name, gender, email, birthdate, address, postal_code, city, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$login_bdd, $hashedPassword, $nom_bdd, $prenom_bdd, $sexe_bdd, $email_bdd, $naissance_bdd, $adresse_bdd, $codePostal_bdd, $ville_bdd, $telephone_bdd]);
            move_to() ;
            exit();
        } catch (PDOException $e) {
            echo "Erreur !: " . $e->getMessage() . "<br/>";
            } finally {
                $conn = null;
            }

    }
}else{
    //echo "<h1>Erreur</h1>";
}

?>

</body>
</html>
