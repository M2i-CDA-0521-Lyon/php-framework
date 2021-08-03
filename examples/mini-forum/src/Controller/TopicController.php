<?php

namespace App\Controller;

use App\Model\Topic;
use App\Model\Message;
use App\View\TopicView;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant d'afficher la page d'accueil
 */
class TopicController implements ControllerInterface
{
    /**
     * Le sujet à passer à la vue
     * @var Topic
     */
    private Topic $topic;
    /**
     * Les messages du sujet à passer à la vue
     * @var array
     */
    private array $messages;

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
            throw new NotFoundException('Question #' . $id . ' does not exist.');
        }

        $this->topic = $topic;

        // Récupère tous les messages du topic
        $this->messages = Message::findWhere('topic_id', $topic->getId());
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        return new TopicView($this->topic, $this->messages);
    }
}
