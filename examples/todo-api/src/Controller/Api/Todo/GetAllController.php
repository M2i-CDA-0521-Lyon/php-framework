<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Http\JsonResponse;
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
        // Génère une réponse qui contient les données au format JSON
        return new JsonResponse($todos);
    }
}
