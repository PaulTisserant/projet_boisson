<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background-color: rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: black;
            font-size: 20px;
        }


        h1 {
            text-align: center;
            margin-top: 100px;
        }


        h3 {
            text-align: center;
        }

        div {
            text-align: center;
            margin-top: 20px;
        }

        div a {
            // button style
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: black;
        }

        div a:hover {
            background-color: rgba(0, 0, 0, 0.2);
            
        }

        
    </style>
</head>
<body>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="recettes.php">Recettes</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
    </nav>

    <h1>Accueil</h1>

    <h3>Bienvenu sur notre site de recettes de cocktail </h3>

    <div>
        <a href="recettes.php">Voir nos recettes</a>
    </div>
    
</body>
</html>