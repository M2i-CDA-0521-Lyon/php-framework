<?php

namespace Cda0521Framework;

use Exception;
use AltoRouter;
use Cda0521Framework\Interfaces\ControllerInterface;

class Application
{
    public function run(): void
    {        
        // Active l'affichage des erreurs dans la page lors de l'utilisation du serveur local de PHP
        ini_set('display_errors', 1);

        // Instancie le routeur
        $router = new AltoRouter();

        // Définit les différentes routes du projet
        // Charge le fichier de configuration qui contient les routes
        $fileContent = \file_get_contents('routes.json');
        // Interpréte le contenu du fichier JSON comme un tableau associatif
        $routes = \json_decode($fileContent, true);
        // Pour chaque route
        foreach ($routes as $route) {
            // Configure la route dans le routeur
            $router->map(
                $route['method'],
                $route['uri'],
                'App\\Controller\\' . $route['controller'],
                $route['name']
            );
        }

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
        // Vérifie que la classe de contrôleur implémente bien l'interface ControllerInterface
        // sinon, il n'y a aucun garantie que le contrôleur posséde bien une méthode invoke() qui renvoie bien une vue
        if (!in_array(ControllerInterface::class, class_implements($className))) {
            throw new Exception('Controller class ' . $className . ' does not implement ControllerInterface.');
        }
        $controller = new $className();
        $response = $controller->invoke();
        // Demande à la vue générée par le contrôleur de construire la page
        $response->send();
    }
}
