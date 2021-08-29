<?php

namespace App\Controller\Api\ToDo;

use App\Model\Todo;
use Cda0521Framework\Http\JsonResponse;
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
        // Si la tâche n'existe pas
        if (is_null($this->todo))  {
            // Associe un code "non trouvé" à la réponse HTTP
            http_response_code(404);
            // Génère une réponse qui contient un message d'erreur au format JSON
            return new JsonResponse([ "message" => "La tâche demandée n'existe pas." ]);
        }
        
        // Efface l'enregistrement correspondant à l'objet dans la base de données
        $this->todo->delete();
        // Associe un code "pas de contenu" à la réponse HTTP
        http_response_code(204);
        // Génère une réponse vide au format JSON
        return new JsonResponse('');
    }
}
