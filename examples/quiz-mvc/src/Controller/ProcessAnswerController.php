<?php

namespace App\Controller;

use App\View\PlayView;
use App\Model\Question;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter la réponse fournie par un joueur à une question
 */
class ProcessAnswerController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        // Vérifie que tous les champs nécessaires sont bien présents
        if (isset($_POST['answer']) && isset($_POST['current-question'])) {
            // Récupère la question précédente en base de données avec sa bonne réponse
            $previousQuestion = Question::findById($_POST['current-question']);
            // Vérifie si la réponse fournie par l'utilisateur correspond à la bonne réponse à la question précédente
            $rightlyAnswered = intval($_POST['answer']) === $previousQuestion->getRightAnswer()->getId();
        }
    
        // Récupère la question suivante en base de données
        $question = Question::findById(1);
    
        return new PlayView($question, $rightlyAnswered);
    }
}
