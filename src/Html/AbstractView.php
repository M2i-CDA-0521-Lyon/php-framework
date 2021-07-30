<?php

namespace Cda0521Framework\Html;

/**
 * Classe servant de base à toutes les classe de vues
 */
abstract class AbstractView
{
    /**
     * Le titre de la page, qui s'affiche dans l'onglet du navigateur
     * @var string
     */
    protected string $pageTitle;

    /**
     * Crée une nouvelle vue
     *
     * @param string $pageTitle Le titre de la page, qui s'affiche dans l'onglet du navigateur
     */
    public function __construct(string $pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * Envoie une réponse HTTP au client
     *
     * @return void
     */
    final public function send(): void
    {
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html lang="fr">' . PHP_EOL;

        echo '<head>' . PHP_EOL;
        echo '<title>' . $this->pageTitle . '</title>' . PHP_EOL;
        include './templates/head.php';
        echo '</head>' . PHP_EOL;
        
        echo '<body>' . PHP_EOL;
        // Laisse la main aux classes dérivées pour définir comment afficher le contenu de la balise body
        $this->renderBody();
        echo '</body>' . PHP_EOL;
        echo '</html>' . PHP_EOL;
    }
    
    /**
     * Génére le corps de la page HTML
     *
     * @return void
     */
    abstract protected function renderBody(): void;
}
