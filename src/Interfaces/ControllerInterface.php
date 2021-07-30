<?php

namespace Cda0521Framework\Interfaces;

use Cda0521Framework\Html\AbstractView;

/**
 * Interface décrivant la structure nécessaire des classes de contrôleurs pour garantir le bon fonctionnement de l'application
 */
interface ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @return AbstractView
     */
    public function invoke(): AbstractView;
}
