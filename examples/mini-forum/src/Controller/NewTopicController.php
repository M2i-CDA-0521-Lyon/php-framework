<?php

namespace App\Controller;

use App\Model\Message;
use App\Model\Topic;
use App\Model\User;
use App\View\HomeView;
use App\View\TopicView;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter l'ajout d'un nouveau sujet
 */
class NewTopicController implements ControllerInterface
{
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
        if (isset($_POST['title']) && isset($_POST['message-content']) && isset($_POST['user-token'])) {
            // Vérifie le nombre de caractères du titre
            if (strlen($_POST['title']) < 5 || strlen($_POST['title']) > 100) {
                $errors[] = 'Le titre doit être compris entre 5 et 100 caractères';
            }

            // Vérifie le nombre de caractères du message
            if (strlen($_POST['message-content']) < 5 || strlen($_POST['message-content']) > 3000) {
                $errors[] = 'Le message doit être compris entre 5 et 3000 caractères';
            }

            if (empty($errors)) {
                // Récupère l'auteur du message via son token
                $author = User::findWhere('token', $_POST['user-token'])[0];

                // Crée une nouvelle instance de Topic et le sauvegarde en base de données
                $topic = new Topic(null, $_POST['title'], date('Y-m-d H:i:s'), $author->getId());
                $topic->save();

                // Crée une nouvelle instance de Message et le sauvegarde en base de données
                $message = new Message(null, $_POST['message-content'], date('Y-m-d H:i:s'), $author->getId(), $topic->getId());
                $message->save();

                // Redirige vers la route correspondant au topic
                header('Location: /topic/' . $topic->getId());
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
