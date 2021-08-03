<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;

/**
 * Représente un sujet
 */
#[Table('topic')]
class Topic extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var integer|null
     */
    protected ?int $id;
    /**
     * Titre du sujet
     * @var string
     */
    #[Column('title')]
    protected string $title;
    /**
     * Date de création du sujet
     * @var \DateTime
     */
    #[Column('date')]
    protected \DateTime $date;
    /**
     * Identifiant en base de données de l'auteur du sujet
     * @var int
     */
    #[Column('author_id')]
    protected ?int $authorId;

    /**
     * Crée un nouveauu sujet
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $title Titre du sujet
     * @param string|null $date Date de création du sujet
     * @param integer|null $authorId Identifiant en base de données de l'auteur du sujet
     */
    public function __construct(
        ?int $id = null,
        string $title = '',
        ?string $date = null,
        ?int $authorId = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->authorId = $authorId;

        if (is_null($date)) {
            $this->date = new \DateTime();
        } else {
            $this->date = new \DateTime($date);
        }
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
     * Get titre du sujet
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set titre du sujet
     *
     * @param  string  $title  Titre du sujet
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get date du sujet
     *
     * @return  \DateTime
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date du sujet
     *
     * @param  \DateTime  $date  Date du sujet
     *
     * @return  self
     */ 
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get identifiant en base de données de l'auteur du sujet
     *
     * @return  User|null
     */ 
    public function getAuthor()
    {
        return User::findById($this->authorId);
    }

    /**
     * Set identifiant en base de données de l'auteur du sujet
     *
     * @param  User|null  $author  Identifiant en base de données de l'auteur du sujet
     *
     * @return  self
     */ 
    public function setAuthor(?User $author)
    {
        if (is_null($author)) {
            $this->authorId = null;
        } else {
            $this->authorId = $author->getId();
        }

        return $this;
    }

    /**
     * Retourne tous les messages du sujet
     *
     * @return  array
     */ 
    public function getMessages()
    {
        return Message::findWhere('topic_id', $this->id);
    }
}
