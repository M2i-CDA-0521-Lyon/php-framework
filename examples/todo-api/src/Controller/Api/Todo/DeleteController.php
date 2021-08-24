<?php

namespace App\Controller\Api\ToDo;

use App\Model\ToDo;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de renvoyer un élément d'une collectionen fonction de son identifiant au format JSON
 */
class DeleteController implements ControllerInterface
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
        header("Content-Type: application/json; charset=utf-8");

        // Vérifie si la tâche existe
        if (is_null($this->todo))  {
            // Associe un code "non trouvé" à la réponse HTTP
            http_response_code(404);
            // Sérialise un message d'errur et l'écrit dans la réponse
            echo json_encode(["message"=>"L'id de la tâche n'existe pas."]);
            die();
        }

        // Efface l'enregistrement correspondant à l'objet dans la base de données
        $this->todo->delete();
        // Associe un code "pas de contenu" à la réponse HTTP
        http_response_code(204);
        die();
    }
}