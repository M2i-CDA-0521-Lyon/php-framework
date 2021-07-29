<?php

namespace App\Model;

use App\Model\Platform;
use App\Model\Developer;
use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;
use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

/**
 * Représente un jeu vidéo
 */
#[Table('game')]
class Game extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var int|null
     */
    protected ?int $id;
    /**
     * Titre du jeu
     * @var string
     */
    #[Column('title')]
    protected string $title;
    /**
     * Date de sortie du jeu
     * @var \DateTime
     */
    #[Column('release_date')]
    protected \DateTime $releaseDate;
    /**
     * Lien vers la page du jeu
     * @var string
     */
    #[Column('link')]
    protected string $link;
    /**
     * Identifiant en base de données du développeur
     * @var int|null
     */
    #[Column('developer_id')]
    protected ?int $developerId;
    /**
     * Identifiant en base de données de la plateforme
     * @var int|null
     */
    #[Column('platform_id')]
    protected ?int $platformId;

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
     * @return  int|null
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
     * Get développeur
     *
     * @return  Developer
     */ 
    public function getDeveloper(): ?Developer
    {
        return Developer::findById($this->developerId);
    }

    /**
     * Set développeur
     *
     * @param  Developer  $developer  Nouveau développeur
     *
     * @return  self
     */ 
    public function setDeveloper(?Developer $developer)
    {
        if (is_null($developer)) {
            $this->developerId = null;
        }

        $this->developerId = $developer->getId();

        return $this;
    }

    /**
     * Get plateforme
     *
     * @return  Platform
     */ 
    public function getPlatform(): ?Platform
    {
        return Platform::findById($this->platformId);
    }

    /**
     * Set plateforme
     *
     * @param  Platform  $platformId  Nouvelle plateforme
     *
     * @return  self
     */ 
    public function setPlatformId(?Platform $platform)
    {
        if (is_null($platform)) {
            $this->platformId = null;
        }

        $this->platformId = $platform->getId();

        return $this;
    }
}
