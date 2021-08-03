<?php

namespace App\Controller;

use App\View\LoginView;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant d'afficher la page de connexion
 */
class LoginController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        return new LoginView();
    }
}
