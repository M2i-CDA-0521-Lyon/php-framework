<?php

namespace App\Controller;

use App\Model\Topic;
use App\View\TopicView;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Interfaces\ControllerInterface;
use Cda0521Framework\Interfaces\HttpResponse;

/**
 * Contrôleur permettant d'afficher un sujet
 */
class TopicController implements ControllerInterface
{
    /**
     * Le sujet à passer à la vue
     * @var Topic
     */
    private $topic;

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
        return new TopicView($this->topic);
    }
}
