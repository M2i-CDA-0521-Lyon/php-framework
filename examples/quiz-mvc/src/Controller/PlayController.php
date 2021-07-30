<?php

namespace App\Controller;

use App\View\PlayView;
use App\Model\Question;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant d'afficher la page 'Jouer au quiz' avec la question en cours
 */
class PlayController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        // Récupère la question actuelle en base de données
        $question = Question::findById(1);

        return new PlayView($question);
    }
}
