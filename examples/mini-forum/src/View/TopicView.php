<?php

namespace App\View;

use App\Model\Topic;
use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page de connexion
 */
class TopicView extends AbstractView
{
    /**
     * Topic à afficher
     * @var Topic
     */
    private Topic $topic;
    /**
     * Messages du topic à afficher
     * @var array
     */
    private array $messages;

    public function __construct(Topic $topic)
    {
        parent::__construct('Mini-forum - ' . $topic->getTitle());

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
        include './templates/topic.php';
    }
}
