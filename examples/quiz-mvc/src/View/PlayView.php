<?php

namespace App\View;

use App\Model\Question;
use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page "jouer au quiz"
 */
class PlayView extends AbstractView
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
        parent::__construct('Jouer - Question ' . $question->getRank());

        $this->question = $question;
        $this->rightlyAnswered = $rightlyAnswered;
    }

    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    protected function renderBody(): void
    {
        // Met l'objet Question associé à cette vue dans la portée de la fonction
        $question = $this->question;
        $rightlyAnswered = $this->rightlyAnswered;

        include './templates/play.php';
    }
}
