<?php

// Active l'affichage des erreurs dans la page lors de l'utilisation du serveur local de PHP
ini_set('display_errors', 1);

// Active le chargement automatique des classes dans le projet
require_once __DIR__ . '/vendor/autoload.php';

use AltoRouter;
use App\Controller\HomeController;
use App\Controller\PlayController;
use App\Controller\ProcessAnswerController;

// Instancie le routeur
$router = new AltoRouter();

// Définit les différentes routes du projet
// Page d'accueil
$router->map(
  'GET',
  '/',
  HomeController::class,
  'home'
);
// Page "jouer au quiz"
$router->map(
  'GET',
  '/play',
  PlayController::class,
  'play'
);
// Traitement de la réponse à la page "jouer au quiz"
$router->map(
  'POST',
  '/play',
  ProcessAnswerController::class,
  'process_answer'
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

// Comme la cible de route contient un nom de classe de contrôleur, instancie le contrôleur et exécute sa méthode invoke()
$className = $match['target'];
$controller = new $className();
$response = $controller->invoke();
// Demande à la vue générée par le contrôleur de construire la page
$response->send();

die();
