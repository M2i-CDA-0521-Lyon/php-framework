<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Http\JsonResponse;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\NotFoundException;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de créer un nouvel enregistrement en base de données
 */
class CreateController implements ControllerInterface
{   
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        // Récupère le contenu au format JSON de la requête HTTP et le convertit en tableau associatif
        $payload = json_decode(file_get_contents('php://input'), true);
        
        // Si le contenu de l'objet reçu est incomplet ou vide
        if (!isset($payload['text']) || empty($payload['text'])) {
            // Sinon, génère une réponse qui contient un message d'erreur au format JSON
            // Associe un code "requête invalide" à la réponse HTTP
            return new JsonResponse([ "message" => "Le texte de la tâche à ajouter est manquant ou vide." ], 400);
        }

        // Sinon, crée un nouvel objet à partir des données envoyées par le client
        $todo = new Todo(null, $payload['text']);
        // Sauvegarde un enregistrement correspondant à l'état de l'objet en base de données
        $todo->save();
        // Génère une réponse qui contient les données au format JSON
        // Associe un code "Créé" à la réponse HTTP
        return new JsonResponse($todo, 201);
    }
}
