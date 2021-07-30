<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page d'accueil
 */
class HomeView extends AbstractView
{
    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    protected function renderBody(): void
    {
        // Affiche le contenu de la balise body
        include './templates/home.php';
    }
}
