<?php

namespace App\Controller;

use App\Model\Message;
use App\Model\Topic;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Http\RedirectResponse;
use Cda0521Framework\Interfaces\ControllerInterface;
use Cda0521Framework\Interfaces\HttpResponse;

/**
 * Contrôleur permettant de traiter la suppression d'un sujet
 */
class DeleteTopicController implements ControllerInterface
{
    /**
     * Le sujet à supprimer
     * @var Topic
     */
    private Topic $topic;

    /**
     * Crée un nouveau contrôleur
     *
     * @param integer $id Identifiant en base de données du sujet à passer à la vue
     */
    public function __construct(int $id)
    {
        // Récupère le sujet demandé par le client
        $topic = Topic::findById($id);

        // Si le sujet n'existe pas, renvoie à la page 404
        if (is_null($topic)) {
            throw new NotFoundException('Topic #' . $id . ' does not exist.');
        }

        $this->topic = $topic;
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        // Supprime les messages du sujet
        $messages = Message::findWhere('topic_id', $this->topic->getId());

        foreach($messages as $message) {
            $message->delete();
        }

        // Supprime le sujet
        $this->topic->delete();

        // Redirige vers la page d'accueil
        return new RedirectResponse('/');
    }
}
