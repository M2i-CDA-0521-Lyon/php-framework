<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page d'accueil
 */
class HomeView extends AbstractView
{
    /**
     * Les différents sujets à afficher dans la vue
     * @var array
     */
    private array $topics;

    public function __construct(array $topics)
    {
        parent::__construct('Mini-forum - Accueil');

        $this->topics = $topics;
    }

    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    protected function renderBody(): void
    {
        $topics = $this->topics;

        // Affiche le contenu de la balise body
        include './templates/home.php';
    }
}
