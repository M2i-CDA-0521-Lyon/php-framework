<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page de connexion
 */
class LoginView extends AbstractView
{
    public function __construct()
    {
        parent::__construct('Mini-forum - Se connecter');
    }

    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    protected function renderBody(): void
    {
        // Affiche le contenu de la balise body
        include './templates/login.php';
    }
}
