<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
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
        var nom_input = document.getElementById("nom_input");
        var nom = document.getElementById("nom") ;
        if ( /\d/.test(nom_input.value) ) {
            if(!nom.contains(label_nom)){
                nom.appendChild(label_nom) ;
            }
            nom.style.color = "red" ;      
        }else{
            if(nom.contains(label_nom)){
                nom.removeChild(label_nom) ;
            }
            nom.style.color = "black" ;
        }
    }
    function handleBlurPrenom() {
        var prenom_input = document.getElementById("prenom_input");
        var prenom = document.getElementById("prenom");
        if ( /\d/.test(prenom_input.value)) {
            if (!prenom.contains(label_prenom)) {
                prenom.appendChild(label_prenom);
            }
            prenom.style.color = "red";
        } else {
            if (prenom.contains(label_prenom)) {
                prenom.removeChild(label_prenom);
            }
            prenom.style.color = "black";
        }
    }
    function handleBlurEmail() {
        var email_input = document.getElementById("email_input");
        var email = document.getElementById("email");

        if ( /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/.test(email_input.value)) {
            if (!email.contains(label_email)) {
                email.appendChild(label_email);
            }
            email.style.color = "red";
        } else {
            if (email.contains(label_email)) {
                email.removeChild(label_email);
            }
            email.style.color = "black";
        }
    }  
    function handleBlurVille() {
        var ville_input = document.getElementById("ville_input");
        var ville = document.getElementById("ville");

        if (! /^[a-zA-Z-]*$/.test(ville_input.value)) {
            if (!ville.contains(label_ville)) {
                ville.appendChild(label_ville);
            }
            ville.style.color = "red";
        } else {
            if (ville.contains(label_ville)) {
                ville.removeChild(label_ville);
            }
            ville.style.color = "black";
        }
    } 
    function handleBlurCodePostal() {
        var codePostal_input = document.getElementById("codePostal_input");
        var codePostal = document.getElementById("codePostal");

        if (!/\d{5}/.test(codePostal_input.value)) {
            if (!codePostal.contains(label_codePostal)) {
                codePostal.appendChild(label_codePostal);
            }
            codePostal.style.color = "red";
        } else {
            if (codePostal.contains(label_codePostal)) {
                codePostal.removeChild(label_codePostal);
            }
            codePostal.style.color = "black";
        }
    }
    function handleBlurTel() {
        var tel_input = document.getElementById("tel_input");
        var tel = document.getElementById("tel");

        if ( !/^.{0}$/.test(tel_input.value)  && !/(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}/.test(tel_input.value)) {
            if (!tel.contains(label_tel)) {
                tel.appendChild(label_tel);
            }
            tel.style.color = "red";
        } else {
            if (tel.contains(label_tel)) {
                tel.removeChild(label_tel);
            }
            tel.style.color = "black";
        }
    }
    function handleBlurLogin() {
        var login_input = document.getElementById("login_input");
        var login = document.getElementById("login");

        if (!/.{5,}/.test(login_input.value)) {
            if (!login.contains(label_login)) {
                login.appendChild(label_login);
            }
            login.style.color = "red";
        } else {
            if (login.contains(label_login)) {
                login.removeChild(label_login);
            }
            login.style.color = "black";
        }
    }    
    function handleBlurMdp() {
        var mdp_input = document.getElementById("mdp_input");
        var mdp_confirm_input = document.getElementById("mdp_confirm_input");
        var mdp = document.getElementById("mdp");

        if (!(/.{8,}/.test(mdp_input.value ))|| !/[A-Z]{1,}/.test(mdp_input.value) || !mdp_confirm_input.value === mdp_input.value ) {
            if (!mdp.contains(label_mdp)) {
                mdp.appendChild(label_mdp);
            }
            mdp.style.color = "red";
        } else {
            if (mdp.contains(label_mdp)) {
                mdp.removeChild(label_mdp);
            }
            mdp.style.color = "black";
        }
    }


</script>
<?php  
session_start() ;
?>
    <h1>Inscription</h1>

    <form style="align-content: center;"  method="post" action="#" >
    <?php  ?>
    <h3>Information Optionel :</h3>
    <label id="nom" >Nom :</label>
  
    <input id ="nom_input" type="text"  onblur="handleBlurNom()">
    <label id="prenom" >Prenom :</label>
    <input id ="prenom_input" type="text" onblur="handleBlurPrenom()" >
    <br>
    <label id="sexe" >Civilite :</label> 
    <br>
    <input type="radio" name="sexe" value="F">Femme
    <input type="radio" name="sexe" value="H">Homme  
    <br>
    <label id="email" >Email :</label>
    <input id ="email_input" type="email" onblur="handleBlurEmail()" >
    <br>
    <label id="tel" >Numero de telephone :</label>
    <input id ="tel_input" type="text" maxlength="10" onblur="handleBlurTel()" >
    <br>
    <label id="ville" >Ville :</label>
    <input id ="ville_input" type="text" onblur="handleBlurVille()" >
    <br>
    <label id="codePostal" >Code Postal :</label>
    <input id ="codePostal_input" type="text" maxlength="5" onblur="handleBlurCodePostal()" >
    <br>
    <label id="adresse" >Adresse :</label>
    <input id ="adresse_input" type="text" >
    <br>

    <h3 >Information Obligatoire : </h3>
    <label id="login" >Login :</label>
    <input id ="login_input" type="text" onblur="handleBlurLogin()" >
    <br>

    <label id="mdp" >Mot de passe :</label>
    <input id ="mdp_input" type="text"  onblur="handleBlurMdp()">
    <br>
    <label id="mdp_confirm" > Confirmation Mot de passe :</label>
    <input id ="mdp_confirm_input" type="text" onblur="handleBlurMdp()" >
    <br>
    <input type="submit" name="Submit" value="S'inscrire">

    
   
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
