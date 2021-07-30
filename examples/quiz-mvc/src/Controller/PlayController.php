<?php

namespace App\Controller;

use Exception;
use App\View\PlayView;
use App\Model\Question;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant d'afficher la page 'Jouer au quiz' avec la question en cours
 */
class PlayController implements ControllerInterface
{
    /**
     * La question à passer à la vue
     * @var Question
     */
    private Question $question;

    /**
     * Crée un nouveau contrôleur
     *
     * @param integer $id Identifiant en base de données de la question à passer à la vue
     */
    public function __construct(int $id)
    {
        // Récupère la question demandée par le client
        $question = Question::findById($id);

        // Si la question n'existe pas, renvoie à la page 404
        if (is_null($question)) {
            throw new NotFoundException('Question #' . $id . ' does not exist.');
        }

        $this->question = $question;
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        return new PlayView($this->question);
    }
}
