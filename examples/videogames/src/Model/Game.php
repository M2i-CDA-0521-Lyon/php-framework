<?php

namespace App\Model;

use Cda0521Framework\Database\AbstractModel;

/**
 * Représente un jeu vidéo
 */
#[Table('game')]
class Game extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var int
     */
    protected ?int $id;
    /**
     * Titre du jeu
     * @var string
     */
    protected int $title;
    /**
     * Date de sortie du jeu
     * @var \DateTime
     */
    protected int $releaseDate;
    /**
     * Lien vers la page du jeu
     * @var string
     */
    protected int $link;
    /**
     * Identifiant en base de données du développeur
     * @var int
     */
    protected int $developerId;
    /**
     * Identifiant en base de données de la plateforme
     * @var int
     */
    protected int $platformId;

    /**
     * Crée un nouveau jeu
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $title Titre du jeu
     * @param string|null $releaseDate Date de sortie du jeu
     * @param string $link Lien vers la page du jeu
     * @param integer|null $developerId Identifiant en base de données du développeur
     * @param integer|null $platformId Identifiant en base de données de la plateforme
     */
    public function __construct(
        ?int $id = null,
        string $title = '',
        ?string $releaseDate = null,
        string $link = '',
        ?int $developerId = null,
        ?int $platformId = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->developerId = $developerId;
        $this->platformId = $platformId;

        if (is_null($releaseDate)) {
            $this->releaseDate = new \DateTime();
        } else {
            $this->releaseDate = new \DateTime($releaseDate);
        }
    }

    /**
     * Get identifiant en base de données
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get titre du jeu
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set titre du jeu
     *
     * @param  string  $title  Titre du jeu
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get date de sortie du jeu
     *
     * @return  \DateTime
     */ 
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set date de sortie du jeu
     *
     * @param  \DateTime  $releaseDate  Date de sortie du jeu
     *
     * @return  self
     */ 
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get lien vers la page du jeu
     *
     * @return  string
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set lien vers la page du jeu
     *
     * @param  string  $link  Lien vers la page du jeu
     *
     * @return  self
     */ 
    public function setLink(string $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get identifiant en base de données du développeur
     *
     * @return  int
     */ 
    public function getDeveloperId()
    {
        return $this->developerId;
    }

    /**
     * Set identifiant en base de données du développeur
     *
     * @param  int  $developerId  Identifiant en base de données du développeur
     *
     * @return  self
     */ 
    public function setDeveloperId(int $developerId)
    {
        $this->developerId = $developerId;

        return $this;
    }

    /**
     * Get identifiant en base de données de la plateforme
     *
     * @return  int
     */ 
    public function getPlatformId()
    {
        return $this->platformId;
    }

    /**
     * Set identifiant en base de données de la plateforme
     *
     * @param  int  $platformId  Identifiant en base de données de la plateforme
     *
     * @return  self
     */ 
    public function setPlatformId(int $platformId)
    {
        $this->platformId = $platformId;

        return $this;
    }
}
