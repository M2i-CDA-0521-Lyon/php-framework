<?php

namespace App\Controller;

use App\View\HomeView;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant d'afficher la page d'accueil
 */
class HomeController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        return new HomeView();
    }
}
