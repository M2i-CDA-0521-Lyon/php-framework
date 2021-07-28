<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Model\Game;

try {
    // Si la méthode HTTP utilisée dans cette requête n'est pas POST, c'est donc que l'utilisateur a tenté d'accéder à ce script manuellement
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('This script must be accessed via a POST HTTP request.', 0);
    }

    // S'il manque un seul des champ présents dans le formulaire, c'est donc que l'utilisateur a contourné le formulaire
    if (!isset($_POST['id'])) {
        throw new Exception('Form field missing in request.', 1);
    }

    // Récupère une copie de l'enregistrement à supprimer sous forme d'objet
    $game = Game::findById($_POST['id']);

    // Supprime un enregistrement existant en base de données correspondant à cet objet
    $game->delete();

    // Redirige sur la liste des jeux
    header('Location: /');
}
catch (Exception $exception) {
    // Redirige sur la liste des jeux
    header('Location: /?error=' . $exception->getCode());
}
