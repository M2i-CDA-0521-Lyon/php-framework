<?php

// Active l'affichage des erreurs dans la page lors de l'utilisation du serveur local de PHP
ini_set('display_errors', 1);

// Active le chargement automatique des classes dans le projet
require_once __DIR__ . '/vendor/autoload.php';

use AltoRouter;
use App\View\HomeView;
use App\View\PlayView;
use App\Model\Question;

// Instancie le routeur
$router = new AltoRouter();

// Définit les différentes routes du projet
// Page d'accueil
$router->map(
  'GET',
  '/',
  function() {
    // Code à déplacer dans HomeController
    return new HomeView();
  },
  'home'
);
// Page "jouer au quiz"
$router->map(
  'GET',
  '/play',
  function() {
    // Code à déplacer dans PlayController

    // Récupère la question actuelle en base de données
    $question = Question::findById(1);

    return new PlayView($question);
  },
  'play'
);
// Traitement de la réponse à la page "jouer au quiz"
$router->map(
  'POST',
  '/play',
  function() {
    // Code à déplacer dans ProcessAnswerController

    // Vérifie que tous les champs nécessaires sont bien présents
    if (isset($_POST['answer']) && isset($_POST['current-question'])) {
      // Récupère la question précédente en base de données avec sa bonne réponse
      $previousQuestion = Question::findById($_POST['current-question']);
      // Vérifie si la réponse fournie par l'utilisateur correspond à la bonne réponse à la question précédente
      $rightlyAnswered = intval($_POST['answer']) === $previousQuestion->getRightAnswer()->getId();
    }

    // Récupère la question suivante en base de données
    $question = Question::findById(1);

    return new PlayView($question, $rightlyAnswered);
  },
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

// Comme la cible de la route contient une fonction, exécute la fonction récupérée par le routeur et récupère la vue renvoyée par cette fonction
$response = call_user_func_array( $match['target'], $match['params'] );
// Demande à la vue de construire la page
$response->send();

die();
