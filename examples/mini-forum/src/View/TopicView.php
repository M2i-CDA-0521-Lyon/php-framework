<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;
use App\Model\Topic;

/**
 * Vue permettant d'afficher un topic et ses messages
 */
class TopicView extends AbstractView
{
     /**
     * Le sujet à passer au template
     * @var Topic
     */
    private $topic;

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
