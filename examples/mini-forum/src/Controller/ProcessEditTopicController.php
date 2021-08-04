<?php

namespace App\Controller;

use App\Model\Topic;
use Cda0521Framework\Exception\NotFoundException;
use Cda0521Framework\Http\RedirectResponse;
use Cda0521Framework\Interfaces\ControllerInterface;
use Cda0521Framework\Interfaces\HttpResponse;

/**
 * Contrôleur permettant de traiter la modification d'un sujet
 */
class ProcessEditTopicController implements ControllerInterface
{
    /**
     * Le sujet à passer à la vue
     * @var Topic
     */
    private Topic $topic;

    /**
     * Crée un nouveau contrôleur
     *
     * @param integer $id Identifiant en base de données du sujet à passer à la vue
     */
    public function __construct(int $id)
    {
        // Récupère le sujet demandé par le client
        $topic = Topic::findById($id);

        // Si le sujet n'existe pas, renvoie à la page 404
        if (is_null($topic)) {
            throw new NotFoundException('Topic #' . $id . ' does not exist.');
        }

        $this->topic = $topic;
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        $errors = [];

        // Vérifie que le champ "title" est bien présent
        if (isset($_POST['title'])) {
            // Vérifie le nombre de caractères du titre
            if (strlen($_POST['title']) < 5 || strlen($_POST['title']) > 100) {
                $errors[] = 'Le titre doit être compris entre 5 et 100 caractères';
            }

            if (empty($errors)) {
                // Modifie le titre du sujet puis le sauvegarde en base de données
                $this->topic->setTitle($_POST['title']);
                $this->topic->save();

                // Redirige vers la page d'accueil
                return new RedirectResponse('/');
            }
        } else {
            $errors[] = 'Vous devez remplir tous les champs';
        }

        if (!empty($errors)) {
            // En cas d'erreur, redirige vers la page d'accueil
            return new RedirectResponse('/');
        }
    }
}
