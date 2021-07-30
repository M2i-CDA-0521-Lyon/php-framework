<?php

namespace Cda0521Framework\Html;

/**
 * Classe servant de base à toutes les classe de vues
 */
abstract class AbstractView
{
    /**
     * Envoie une réponse HTTP au client
     *
     * @return void
     */
    final public function send(): void
    {
        // Inclue le début du fichier HTML
        include './templates/header.php';
        
        // Laisse la main aux classes dérivées pour définir comment afficher le contenu de la balise body
        $this->renderBody();

        // Inclue la fin du fichier HTML
        include './templates/footer.php';
    }
    
    /**
     * Génére le corps de la page HTML
     *
     * @return void
     */
    abstract protected function renderBody(): void;
}
