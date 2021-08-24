<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de renvoyer un élément d'une collection en fonction de son identifiant au format JSON
 */
class GetByIdController implements ControllerInterface
{
    /**
     * La tâche demandée
     * @var Todo|null
     */
    private ?Todo $todo;

    /**
     * Crée un nouveau contrôleur
     * 
     * @param integer $id Identifiant en base de données
     */
    public function __construct(int $id)
    {
        // Récupère la tâche demandée par le client en base de données
        $this->todo = Todo::findById($id);
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        // Ajoute une méta-donnée signifiant que la réponse est encodée en JSON
        header("Content-Type: application/json; charset=UTF-8");

        // Vérifie si la tâche existe
        if (is_null($todo))  {
            // Associe un code "non trouvé" à la réponse HTTP
            http_response_code(404);
            // Sérialise un message d'errur et l'écrit dans la réponse
            echo json_encode(["message"=>"L'id de la tâche n'existe pas."]);
            die();
        }
        
        // Sinon, sérialise les données en JSON et les écrit dans la réponse
        echo json_encode($todo);
        die();
    }
}
