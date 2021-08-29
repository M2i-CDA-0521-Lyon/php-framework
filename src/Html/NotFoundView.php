<?php

namespace Cda0521Framework\Html;

/**
 * Vue permettant d'afficher la page 404 (page non trouvée)
 */
class NotFoundView extends AbstractView
{
    /**
     * Crée une nouvelle vue
     */
    public function __construct()
    {
        parent::__construct('Page non trouvée');
    }

    /**
     * Récupère le code HTTP de la réponse
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        // Le code HTTP de la page "non trouvé" est forcément 404
        // Cette méthode réimplémente et remplace la méthode du parent qui renvoie toujours 200
        return 404;
    }

    /**
     * Génére le corps de la page HTML
     *
     * @see AbstractView::renderBody()
     * @return void
     */
    public function renderBody(): void
    {
        echo '<h1>Page non trouvée</h1>';
        echo '<p>Cette page n\'existe pas (pour le moment)…</p>';
    }
}
