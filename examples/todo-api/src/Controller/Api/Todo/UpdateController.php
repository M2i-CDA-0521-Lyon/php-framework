<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Http\JsonResponse;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de modifier partiellement un élément existant en base de données
 */
class UpdateController implements ControllerInterface
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
        
        // Récupère le contenu au format JSON de la requête HTTP et le convertit en tableau associatif
        $payload = json_decode(file_get_contents('php://input'), true);

        // Si le contenu de l'objet reçu est incomplet ou vide
        if (isset($payload['text']) && empty($payload['text'])) {
            // Associe un code "requête invalide" à la réponse HTTP
            http_response_code(400);
            // Sinon, génère une réponse qui contient un message d'erreur au format JSON
            return new JsonResponse([ "message" => "Le texte de la tâche à ajouter est manquant ou vide." ]);
        }
        
        // Met à jour les propriétés de l'objet existant à partir des données envoyées par le client
        if (isset($payload['text'])) {
            $this->todo->setText($payload['text']);
        }
        if (isset($payload['done'])) {
            $this->todo->setDone($payload['done']);
        }
        // Sauvegarde un enregistrement correspondant à l'état de l'objet en base de données
        $this->todo->save();
        // Génère une réponse qui contient les données au format JSON
        return new JsonResponse($this->todo);
    }
}
