<?php

namespace App\Controller;

use App\View\PlayView;
use App\Model\Question;
use Cda0521Framework\Http\RedirectResponse;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

/**
 * Contrôleur permettant de traiter la réponse fournie par un joueur à une question
 */
class ProcessAnswerController implements ControllerInterface
{
    /**
     * La question à passer à la vue
     * @var Question
     */
    private Question $question;

    /**
     * Crée un nouveau contrôleur
     *
     * @param integer $id Identifiant en base de données de la question à passer à la vue
     */
    public function __construct(int $id)
    {
        // Récupère la question demandée par le client
        $question = Question::findById($id);

        // Si la question n'existe pas, renvoie à la page 404
        if (is_null($question)) {
            throw new NotFoundException('Question #' . $id . ' does not exist.');
        }

        $this->question = $question;
    }

    /**
     * Examine la requête HTTP et prépare une réponse HTTP adaptée
     *
     * @see ControllerInterface::invoke()
     * @return HttpResponse
     */
    public function invoke(): HttpResponse
    {
        // Vérifie que tous les champs nécessaires sont bien présents
        if (isset($_POST['answer'])) {
            // Vérifie si la réponse fournie par l'utilisateur correspond à la bonne réponse à la question précédente
            $rightlyAnswered = intval($_POST['answer']) === $this->question->getRightAnswer()->getId();
        }
    
        // Récupère la question suivante en base de données
        $nextQuestion = Question::findWhere('rank', $this->question->getRank() + 1)[0];

        // Redirige vers la page présentant la question suivante
        return new RedirectResponse('/play/' . $nextQuestion->getId());
    }
}
