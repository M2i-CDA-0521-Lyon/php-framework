<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;

/**
 * Représente un message
 */
#[Table('message')]
class Message extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var integer|null
     */
    protected ?int $id;
    /**
     * Contenu du message
     * @var string
     */
    #[Column('content')]
    protected string $content;
    /**
     * Date de création du message
     * @var \DateTime
     */
    #[Column('date')]
    protected \DateTime $date;
    /**
     * Identifiant en base de données de l'auteur du message
     * @var int|null
     */
    #[Column('author_id')]
    protected ?int $authorId;
    /**
     * Identifiant en base de données du sujet du message
     * @var int|null
     */
    #[Column('topic_id')]
    protected ?int $topicId;

    /**
     * Crée un nouveauu sujet
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $content Contenu du message
     * @param string|null $date Date de création du message
     * @param integer|null $authorId Identifiant en base de données de l'auteur du sujet
     * @param integer|null $topicId Identifiant en base de données du sujet du message
     */
    public function __construct(
        ?int $id = null,
        string $content = '',
        ?string $date = null,
        ?int $authorId = null,
        ?int $topicId = null
    )
    {
        $this->id = $id;
        $this->content = $content;
        $this->authorId = $authorId;
        $this->topicId = $topicId;

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
     * Get contenu du message
     *
     * @return  string
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set contenu du message
     *
     * @param  string  $content  Contenu du message
     *
     * @return  self
     */ 
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

        /**
     * Get date du message
     *
     * @return  \DateTime
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date du message
     *
     * @param  \DateTime  $date  Date du message
     *
     * @return  self
     */ 
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get identifiant en base de données de l'auteur du message
     *
     * @return  User|null
     */ 
    public function getAuthor()
    {
        return User::findById($this->authorId);
    }

    /**
     * Set identifiant en base de données de l'auteur du message
     *
     * @param  User|null  $author  Identifiant en base de données de l'auteur du message
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
     * Retourne le sujet du message
     *
     * @return  Topic|null
     */ 
    public function getTopic()
    {
        return Topic::findById($this->topicId);
    }

    /**
     * Set identifiant en base de données du sujet du message
     *
     * @param  Topic|null  $topic  Identifiant en base du sujet du message
     *
     * @return  self
     */ 
    public function setTopic(?Topic $topic)
    {
        if (is_null($topic)) {
            $this->topicId = null;
        } else {
            $this->topicId = $topic->getId();
        }

        return $this;
    }
}
