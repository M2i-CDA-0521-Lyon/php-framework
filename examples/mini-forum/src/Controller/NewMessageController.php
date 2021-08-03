<?php

namespace App\Controller;

use App\Model\Message;
use App\Model\Topic;
use App\Model\User;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter l'ajout d'un nouveau message à un sujet
 */
class NewMessageController implements ControllerInterface
{
    /**
     * Le sujet sur lequel ajouter le nouveau message
     * @var Topic
     */
    private Topic $topic;

    /**
     * Crée un nouveau contrôleur
     *
     * @param integer $id Identifiant en base de données du sujet sur lequel ajouter le nouveau message
     */
    public function __construct(int $topicId)
    {
        // Récupère le sujet demandé par le client
        $topic = Topic::findById($topicId);

        // Si le sujet n'existe pas, renvoie à la page 404
        if (is_null($topic)) {
            throw new NotFoundException('Topic #' . $topicId . ' does not exist.');
        }

        $this->topic = $topic;
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        $errors = [];

        // Vérifie que tous les champs nécessaires sont bien présents
        if (isset($_POST['content']) && isset($_POST['user-token'])) {
            // Vérifie le nombre de caractères du message
            if (strlen($_POST['content']) < 5 || strlen($_POST['content']) > 3000) {
                $errors[] = 'Le message doit être compris entre 5 et 3000 caractères';
            }

            if (empty($errors)) {
                // Récupère l'auteur du message via son token
                $author = User::findWhere('token', $_POST['user-token'])[0];

                // Crée une nouvelle instance de Message et le sauvegarde en base de données
                $message = new Message(null, $_POST['content'], date('Y-m-d H:i:s'), $author->getId(), $this->topic->getId());
                $message->save();

                // Redirige vers la route correspondant au topic
                header('Location: /topic/' . $this->topic->getId());
            }
        } else {
            $errors[] = 'Vous devez remplir tous les champs';
        }

        if (!empty($errors)) {
            // En cas d'erreur, redirige vers la page d'accueil
            header('Location: /');
        }
    }
}
