<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;
use Cda0521Framework\Interfaces\NotFoundException;

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
        // Ajoute une méta-donnée signifiant que la réponse est encodée en JSON
        header("Content-Type: application/json; charset=UTF-8");
        
        // Si le contenu de l'objet reçu est incomplet ou vide
        if (!isset($payload['text']) || empty($payload['text'])) {
            // Associe un code "requête invalide" à la réponse HTTP
            http_response_code(400);
            // Sérialise un message d'errur et l'écrit dans la réponse
            echo json_encode(["message"=>"Le texte de la tâche est vide"]);
            die();
        }

        // Sinon, crée un nouvel objet à partir des données envoyées par le client
        $todo = new Todo(null, $payload['text']);
        // Sauvegarde un enregistrement correspondant à l'état de l'objet en base de données
        $todo->save();
        // Associe un code "Créé" à la réponse HTTP
        http_response_code(201);
        // Sérialise l'objet en JSON et l'écrit dans la réponse
        echo json_encode($todo);
        die();
    }
}