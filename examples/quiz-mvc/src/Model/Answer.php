<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\AbstractModel;
use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

/**
 * Représente une réponse
 */
#[Table('answer')]
class Answer extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var integer|null
     */
    private ?int $id;
    /**
     * Texte de la réponse
     * @var string
     */
    private string $text;
    /**
     * Identifiant en base de données de la question à laquelle la réponse est associée
     * @var int|null
     */
    private ?int $questionId;

    /**
     * Récupère un élément en base de données en fonction des on identifiant
     *
     * @return Answer[]
     */
    static public function findWhere(string $columnName, string $value): array
    {
        $data = SqlDatabaseHandler::fetchWhere('answer', $columnName, $value);
        foreach ($data as $item) {
            $result []= new Answer(
                $item['id'],
                $item['text'],
                $item['question_id']
            );
        }
        return $result;
    }

    /**
     * Crée une nouvelle réponse
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $text Texte de la réponse
     * @param integer|null $question Identifiant en base de données de la question à laquelle la réponse est associée
     */
    public function __construct(
        ?int $id = null,
        string $text = '',
        ?int $questionId = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->questionId = $questionId;
    }

    /**
     * Get identifiant en base de données
     *
     * @return  integer|null
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get texte de la réponse
     *
     * @return  string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set texte de la réponse
     *
     * @param  string  $text  Texte de la réponse
     *
     * @return  self
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get identifiant en base de données de la question à laquelle la réponse est associée
     *
     * @return  Question|null
     */ 
    public function getQuestion()
    {
        return Question::findById($this->questionId);
    }

    /**
     * Set identifiant en base de données de la question à laquelle la réponse est associée
     *
     * @param  Question|null  $question  Identifiant en base de données de la question à laquelle la réponse est associée
     *
     * @return  self
     */ 
    public function setQuestion($question)
    {
        if (is_null($question)) {
            $this->questionId = null;
        } else {
            $this->questionId = $question->getId();
        }

        return $this;
    }
}
