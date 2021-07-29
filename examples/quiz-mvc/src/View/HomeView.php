<?php

namespace App\View;

/**
 * Vue permettant d'afficher la page d'accueil
 */
class HomeView
{
    /**
     * Envoie une réponse HTTP au client
     *
     * @return void
     */
    public function send(): void
    {
        include './templates/header.php';
        include './templates/home.php';
        include './templates/footer.php';
    }
}
