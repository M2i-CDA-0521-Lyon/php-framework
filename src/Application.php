<?php

namespace Cda0521Framework;

use Exception;
use AltoRouter;
use Cda0521Framework\Html\NotFoundView;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Interfaces\ControllerInterface;

class Application
{
    public function run(): void
    {
        try {
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
                throw new NotFoundException('Page not found.');
            }

            // Comme la cible de route contient un nom de classe de contrôleur, instancie le contrôleur et exécute sa méthode invoke()
            $className = $match['target'];
            // Vérifie que la classe de contrôleur implémente bien l'interface ControllerInterface
            // sinon, il n'y a aucun garantie que le contrôleur posséde bien une méthode invoke() qui renvoie bien une vue
            if (!in_array(ControllerInterface::class, class_implements($className))) {
                throw new Exception('Controller class ' . $className . ' does not implement ControllerInterface.');
            }
            $params = $match['params'];
            // Crée une instance du contrôleur obtenu et lui demande de générer une réponse
            $controller = new $className(...$params);
            $response = $controller->invoke();
        }
        // Si une erreur de type "non trouvé" a arrêté prématurément le processus
        catch (NotFoundException $exception) {
            // Génére une réponse contenat une page "non trouvé" à la place
            $response = new NotFoundView();
        }
        // Demande à la réponse générée par le contrôleur de construire la page
        \http_response_code($response->getStatusCode());
        $response->send();
    }
}
