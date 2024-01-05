<?php
    // Connexion à la base de données
    $conn = new PDO('mysql:host=localhost;dbname=boissons', "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération du terme de recherche depuis la requête AJAX
    $searchTerm = $_GET['search'] ?? '';

    // Requête pour obtenir des suggestions basées sur le terme de recherche (recherche dans les noms d'ingrédients et les noms des recettes) 
    $stmt = $conn->prepare("SELECT nom FROM ingredients WHERE nom LIKE :searchTerm UNION SELECT title FROM recipes WHERE title LIKE :searchTerm");
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Extraire les valeurs pertinentes
    $suggestions = array_map(function ($row) {
        return $row['nom'] ?? $row['title'] ?? null;
    }, $result);

    // Retourner les 5 premières suggestions au format JSON
    $suggestions = array_slice($suggestions, 0, 5);
    echo json_encode($suggestions);

?>
