<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de renvoyer tous les éléments d'une collection au format JSON
 */
class GetAllController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        // Récupère toutes les tâches à faire en base de données
        $todos = Todo::findAll();
        
        // Ajoute une méta-donnée signifiant que la réponse est encodée en JSON
        header("Content-Type: application/json; charset=UTF-8");
        // Sérialise les données en JSON et les écrit dans la réponse
        echo json_encode($todos);

        die();
    }
}
