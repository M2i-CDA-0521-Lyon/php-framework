<?php

namespace App\View;

use App\Model\Question;

/**
 * Vue permettant d'afficher la page "jouer au quiz"
 */
class PlayView
{
    /**
     * La question à afficher dans la vue
     * @var Question
     */
    private Question $question;
    /**
     * Le joueur a-t-il bien répondu à la question précédente?
     * @var bool|null
     */
    private ?bool $rightlyAnswered;

    /**
     * Crée une nouvelle vue "jouer au quiz"
     *
     * @param Question $question La question à afficher dans la vue
     */
    public function __construct(Question $question, ?bool $rightlyAnswered = null)
    {
        $this->question = $question;
        $this->rightlyAnswered = $rightlyAnswered;
    }

    /**
     * Envoie une réponse HTTP au client
     *
     * @return void
     */
    public function send(): void
    {
        // Met l'objet Question associé à cette vue dans la portée de la fonction
        $question = $this->question;
        $rightlyAnswered = $this->rightlyAnswered;

        include './templates/header.php';
        include './templates/play.php';
        include './templates/footer.php';
    }
}
