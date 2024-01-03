<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="compte.css">
    <link rel="stylesheet" type="text/css" href="header.css">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Compte</title>
</head>
<body>

<?php  include_once  "header.php"?>
<?php 
session_start();
include_once "fonctions.php";
?>
</body>

<table>
<tr>
<td>


<div class="conteneur" > 
<h1 >Information Utilisateur</h1>
<?php 
if (isset($_SESSION['user_id']) && isset($_SESSION['login'])) {
    if(!(verifConn())){
        echo 'erreeee' ;
            header('Location: connexion.php');
            exit() ;
        }
        try {
            $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
            $sql = "SELECT * FROM users WHERE login = ? AND user_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$_SESSION['login'], $_SESSION['user_id']]);
            // Si une ligne est retournée, le login existe
            if ($stmt->rowCount() > 0) {
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                // Stockez les données dans des variables individuelles
                $login = $userData['login'];
                $password = $userData['password'];
                $first_name = $userData['first_name'];
                $last_name = $userData['last_name'];
                $gender = $userData['gender'];
                $email = $userData['email'];
                $birthdate = $userData['birthdate'];
                $address = $userData['address'];
                $postal_code = $userData['postal_code'];
                $city = $userData['city'];
                $phone_number = $userData['phone_number'];

            }else{
                echo "Error aucune ligne";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } finally {
            $conn = null;
        }
}else{
    header('Location: connexion.php');
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"]) ){

    //Si l'utilisateur a cliquer sur le bouton supprimer.
    try {
        $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
        $sql = "DELETE FROM users WHERE login =? AND user_id =?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['login'], $_SESSION['user_id']]);
        deconnexion();
            header('Location: inscription.php');
            exit() ;
        
    } catch (PDOException $e) {
        echo "Erreur : ". $e->getMessage();
    } finally {
        $conn = null;
    }
}




$pass = afficherMotDePasse($password) ;
echo "
<table>
<tr>
    <td>
    <p > Nom : <span class='info'> $last_name </span>  </p> 
    </td>
    <td class = 'butCell'>
    <button class='but' onclick=\"afficherCadre('nom')\">Modifier Nom</button>
    </td>
</tr>

<tr>
    <td>
    <p> Prenom : <span class='info'> $first_name </span>
    </td>
    <td class='butCell'> 
    <button class='but' onclick=\"afficherCadre('prenom')\">Modifier Prenom</button> </p> 
    </td>
</tr>

<tr> 
<td>
<p> Civilite : <span class='info'> $gender  </span> </p> 
</td>
<td class='butCell'>
<button class='but' onclick=\"afficherCadre('sexe')\">Modifier Civilite</button>
</td>
</tr>

<tr>
    <td>
    <p> Email : <span class='info'> $email </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('email')\">Modifier Email</button>
    </td>
</tr>

<tr> 
    <td>
    <p> Tel : <span class='info'> $phone_number </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('tel')\">Modifier Numero</button> 
    </td>
</tr>

<tr> 
    <td>
    <p> Ville : <span class='info'> $city </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('ville')\">Modifier Ville</button> 
    </td>
</tr>

<tr> 
    <td>
    <p> Code Postal : <span class='info'>$postal_code </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('codePostal')\">Modifier code Postal</button> 
    </td>
</tr>

<tr> 
    <td>
    <p> Adresse : <span class='info'> $address </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('adresse')\">Modifier Adresse</button>  
    </td>
</tr>

<tr>
    <td>
    <p> Login : <span class='info'> $login </span> </p>
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('login')\">Modifier Login</button> 
    </td>
</tr>

<tr> 
    <td>
    <p> Mot de passe : <span class='info'>$pass </span>  </p> 
    </td>
    <td class='butCell'>
    <button class='but' onclick=\"afficherCadre('mdp')\">Modifier Mot De Passe</button>  
    </td>
</tr>
</table>
<form method='post' action='#'>
    <input type='submit' name='supprimer' value='Supprimer le compte'>
</form>
</td>
<td  class = 'mod' id = 'mod'>
</td>
</table>
</tr>
 "  ?>
</div>
<script>
function afficherCadre(champ) {

        var input_name =  champ + "_input" ; 
                // Créer le cadre
                var cadre = document.createElement('div');
                cadre.className = 'cadre';
                // Créer l'étiquette (label)
                var label = document.createElement('label');
                label.setAttribute('for', champ);
                label.setAttribute('id', champ);
                label.textContent = champ.charAt(0).toUpperCase() + champ.slice(1)+ " : ";

        switch (champ) {
            case "sexe":
                var radioContainer = document.createElement('div');
                var radio1 = document.createElement('input');
                        radio1.type = 'radio';
                        radio1.name = champ;
                        radio1.value = 'H';
                        radio1.id = champ;
                var label_rad1 = document.createElement('label');
                label_rad1.setAttribute('for', champ);
                label_rad1.setAttribute('id', champ);      
                label_rad1.textContent = "Homme"    ;             
                var radio2 = document.createElement('input');
                    radio2.type = 'radio';
                    radio2.name = champ;
                    radio2.value = 'F';
                    radio2.id = champ;
                var label_rad2 = document.createElement('label');
                label_rad2.setAttribute('for', champ);
                label_rad2.setAttribute('id', champ);  
                label_rad2.textContent = "Femme";
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                        if(verifGender(champ)){
                            validerChamp(champ);
                        }else{
                            alert('Veuillez choisir une civilite valide');
                        }
                };
                // Ajouter l'étiquette, le champ d'entrée et le bouton au cadre
                cadre.appendChild(label);
                radioContainer.appendChild(radio1);
                radioContainer.appendChild(label_rad1);

                radioContainer.appendChild(radio2);
                radioContainer.appendChild(label_rad2);
                cadre.appendChild(radioContainer) ;
                cadre.appendChild(bouton);

                // Ajouter le cadre au corps de la page
                if(document.querySelector('.cadre')!== null ){
                    document.querySelector('.cadre').remove();
                }
                document.getElementById('mod').appendChild(cadre);
                // Afficher le cadre
                cadre.style.display = 'grid';
                return ;
                break;

            case "nom":

                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurNom() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un nom valide");
                    }
                };
                    input.onblur = function() {
                    handleBlurNom() ;
                };
            break;

            case "prenom":
                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurPrenom() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un Prenom valide");
                    }
                };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurPrenom() ;
                };
            break;
            case "email":

                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurEmail() == true){
                    validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un Email valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurEmail() ;
                };
         
            break;
            case "tel":
                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                input.setAttribute('maxlength', 10);

                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';

                bouton.onclick = function() {
                    if(handleBlurTel() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un Numero de telephone valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurTel() ;
                };
            break;
            case "ville":


                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurVille() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un nom de Ville valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurVille() ;
                };
            break;
            case "adresse":


                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    validerChamp(champ);
                    };
            break;
            case "codePostal":


                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                input.setAttribute('maxlength', 5);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurCodePostal() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un code postal valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurCodePostal() ;
                };
            break;
            case "login":
                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'text');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurLogin() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un login valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurLogin() ;
                };
            break;
            case "mdp":
                // Créer le champ d'entrée (input)
                var input = document.createElement('input'); 
                input.setAttribute('type', 'password');
                input.setAttribute('id', input_name);
                input.setAttribute('name', input_name);
                // Créer le bouton
                var bouton = document.createElement('button');
                bouton.setAttribute('class', 'but')
                bouton.textContent = 'Valider';
                bouton.onclick = function() {
                    if(handleBlurMdp() == true){
                        validerChamp(champ);
                    }else{
                        alert("Veuillez saisir un cMot de passe valide");
                    }
                    };
                    input.onblur = function() {
                    // Code à exécuter lorsque l'input perd le focus
                    handleBlurMdp() ;
                };
            break;
        }




        // Ajouter l'étiquette, le champ d'entrée et le bouton au cadre
        cadre.appendChild(label);
        cadre.appendChild(input);
        cadre.appendChild(bouton);

        // Ajouter le cadre au corps de la page
        if(document.querySelector('.cadre')!== null ){
            document.querySelector('.cadre').remove();
        }
        document.getElementById('mod').appendChild(cadre);

        // Afficher le cadre
        cadre.style.display = 'grid';
    }
    function verifGender(champ){
        var radios = document.getElementsByName(champ);
            for (var i = 0; i < radios.length; i++) {
                //Recherche de l'element selectionné
                if (radios[i].checked) {
                    var nouvelleVal = radios[i].value;
                    return true ;
                }
            }
        return false ;
    }
    function validerChamp(champ) {
        if (champ == "sexe") {
            var radios = document.getElementsByName(champ);
            for (var i = 0; i < radios.length; i++) {
                //Recherche de l'element selectionné
                if (radios[i].checked) {
                    var nouvelleVal = radios[i].value;
                    break; 
                }
            }
        }else{
            var input_name =  champ + "_input" ; 
            // Récupérer la valeur du champ d'entrée
            var nouvelleVal = document.getElementById(input_name).value;
        }   
        // Créer une instance de l'objet XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Définir la fonction de rappel pour gérer la réponse
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
                location.reload(true) ;
            }
        };

        // Ouvrir une requête POST vers le fichier PHP avec la fonction à appeler
        xhr.open("POST", "modificationBdd.php", true);

        // Définir l'en-tête de la requête pour indiquer que c'est une requête POST
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        console.log(nouvelleVal) ;
        xhr.send(champ+"=" + encodeURIComponent(nouvelleVal)); 




        // Cacher le cadre après validation (vous pouvez ajuster cette logique)
        document.querySelector('.cadre').remove();
    
    }


    function changerCivil(){
        // Créer une instance de l'objet XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // Définir la fonction de rappel pour gérer la réponse
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                //
            }
        };

        // Ouvrir une requête POST vers le fichier PHP avec la fonction à appeler
        xhr.open("POST", "modificationBdd.php", true);

        // Définir l'en-tête de la requête pour indiquer que c'est une requête POST
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr("sexe=" + encodeURIComponent('sexe'))     
    }
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
        console.log("blur nom");

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

        if (!emailReg.test(email_input.value)) {
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
        }else{
            if (mdp.contains(label_mdp)) {
                mdp.removeChild(label_mdp);
            }
            mdp.style.color = "black";
            return true;
        }

    }



</script>

</html>