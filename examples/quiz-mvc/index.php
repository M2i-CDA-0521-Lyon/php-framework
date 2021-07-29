<?php

// Active l'affichage des erreurs dans la page lors de l'utilisation du serveur local de PHP
ini_set('display_errors', 1);

// Active le chargement automatique des classes dans le projet
require_once __DIR__ . '/vendor/autoload.php';

use AltoRouter;

// Instancie le routeur
$router = new AltoRouter();

// Définit les différentes routes du projet
// Page d'accueil
$router->map(
  'GET',
  '/',
  function() {
    echo 'Page d\'accueil';
  }
);
// Page "jouer au quiz"
$router->map(
  'GET|POST',
  '/play',
  function() {
    include 'play.php';
  }
);

// Cherche une correspondance entre les routes connues et la requête du client
$match = $router->match();
// Si aucune correspondance n'a été trouvée, affiche la page 404
if ($match === false) {
  // Renvoie le code d'erreur "non trouvé" avec la réponse HTTP
  http_response_code(404);
  echo 'Page non trouvée!';
  die();
}

// Comme la cible de la route contient une fonction, exécute la fonction récupérée par le routeur
call_user_func_array( $match['target'], $match['params'] );

die();
