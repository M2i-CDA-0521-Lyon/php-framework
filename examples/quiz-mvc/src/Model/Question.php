<?php

namespace App\Model;

use Cda0521Framework\Database\AbstractModel;
use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

/**
 * Représente une question
 */
class Question extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var integer|null
     */
    private ?int $id;
    /**
     * Texte de la question
     * @var string
     */
    private string $text;
    /**
     * Rang de la question
     * @var integer|null
     */
    private ?int $rank;
    /**
     * Identifiant en base de données de la bonne réponse
     * @var integer|null
     */
    private ?int $rightAnswerId;

    /**
     * Crée une nouvelle question
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $text Texte de la question
     * @param integer|null $rank Rang de la question
     * @param integer|null $rightAnswerId Identifiant en base de données de la bonne réponse
     */
    public function __construct(
        ?int $id = null,
        string $text = '',
        ?int $rank = null,
        ?int $rightAnswerId = null
    )
    {
        $this->id = $id;
        $this->text = $text;
        $this->rank = $rank;
        $this->rightAnswerId = $rightAnswerId;
    }

    /**
     * Récupère tous les éléments en base de données
     *
     * @return Question[]
     */
    static public function findAll(): array
    {
        return static::findAllInTable('question', Question::class);
    }

    /**
     * Récupère un élément en base de données en fonction des on identifiant
     *
     * @return Question|null
     */
    static public function findById(int $id): ?Question
    {
        return static::findByIdInTable($id, 'question', Question::class);
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
     * Get texte de la question
     *
     * @return  string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set texte de la question
     *
     * @param  string  $text  Texte de la question
     *
     * @return  self
     */ 
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get rang de la question
     *
     * @return  integer|null
     */ 
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set rang de la question
     *
     * @param  integer|null  $rank  Rang de la question
     *
     * @return  self
     */ 
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get la bonne réponse
     *
     * @return  Answer|null
     */ 
    public function getRightAnswer()
    {
        return Answer::findById($this->rightAnswerId);
    }

    /**
     * Set la bonne réponse
     *
     * @param  Answer|null  $rightAnswer  la bonne réponse
     *
     * @return  self
     */ 
    public function setRightAnswer($rightAnswer)
    {
        if (is_null($rightAnswer)) {
            $this->rightAnswerId = null;
        } else {
            $this->rightAnswerId = $rightAnswer->getId();
        }

        return $this;
    }

    /**
     * Récupère toutes les réponses associées à la question
     *
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return Answer::findWhere('question_id', $this->id);
    }
}
