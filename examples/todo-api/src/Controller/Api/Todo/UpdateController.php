<?php

namespace App\Controller\Api\Todo;

use App\Model\Todo;
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

    public function invoke(): HttpResponse
    {
        // Ajoute une méta-donnée signifiant que la réponse est encodée en JSON
        header("Content-Type: application/json; charset=UTF-8");

        // Vérifie si la tâche existe
        if (is_null($this->todo))  {
            // Associe un code "non trouvé" à la réponse HTTP
            http_response_code(404);
            // Sérialise un message d'errur et l'écrit dans la réponse
            echo json_encode(["message"=>"L'id de la tâche n'existe pas."]);
            die();
        }
        
        // Récupère le contenu au format JSON de la requête HTTP et le convertit en tableau associatif
        $payload = json_decode(file_get_contents('php://input'), true);

        // Si le contenu de l'objet reçu est incomplet ou vide
        if (isset($payload['text']) && empty($payload['text'])) {
            // Associe un code "requête invalide" à la réponse HTTP
            http_response_code(400);
            // Sérialise un message d'errur et l'écrit dans la réponse
            echo json_encode(["message"=>"Le texte de la tâche est vide"]);
            die();
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
        // Sérialise l'objet en JSON et l'écrit dans la réponse
        echo json_encode($this->todo);
        die();
    }
}
