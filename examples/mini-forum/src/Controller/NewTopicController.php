<?php

namespace App\Controller;

use App\View\HomeView;
use Cda0521Framework\Html\AbstractView;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter l'ajout d'un nouveau sujet
 */
class NewTopicController implements ControllerInterface
{
    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return AbstractView
     */
    public function invoke(): AbstractView
    {
        // Vérifie que tous les champs nécessaires sont bien présents
        if (isset($_POST['title']) && isset($_POST['message-content']) && isset($_POST['user-token'])) {
            // Check title data
            // Check content data
            
            // Create new topic and save it
            // Create new message and save it

            // Redirect to topic page
        }

        // Redirige vers la page d'accueil
        // header('Location: /');
    }
}
