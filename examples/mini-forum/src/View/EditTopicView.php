<?php

namespace App\View;

use App\Model\Topic;
use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page de connexion
 */
class EditTopicView extends AbstractView
{
    /**
     * Topic à afficher
     * @var Topic
     */
    private Topic $topic;

    public function __construct(Topic $topic)
    {
        parent::__construct('Mini-forum - Modifier le sujet "' . $topic->getTitle() . '"');

        $this->topic = $topic;
    }

    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    protected function renderBody(): void
    {
        $topic = $this->topic;

        // Affiche le contenu de la balise body
        include './templates/edit-topic.php';
    }
}
