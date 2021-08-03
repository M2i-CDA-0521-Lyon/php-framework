<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la page de création de compte
 */
class SignInView extends AbstractView
{
    public function __construct()
    {
        parent::__construct('Mini-forum - Créer un compte');
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
        include './templates/sign-in.php';
    }
}
