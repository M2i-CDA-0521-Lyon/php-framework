<?php

namespace App\Controller;

use App\Model\Topic;
use App\View\EditTopicView;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter l'ajout d'un nouveau sujet
 */
class EditTopicController implements ControllerInterface
{
    /**
     * Le sujet à passer à la vue
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
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        return new EditTopicView($this->topic);
    }
}
