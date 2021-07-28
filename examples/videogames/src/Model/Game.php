<?php

namespace App\Model;

use App\Model\Platform;
use App\Model\Developer;
use Cda0521Framework\Database\Sql\Table;
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
    protected string $title;
    /**
     * Date de sortie du jeu
     * @var \DateTime
     */
    protected \DateTime $releaseDate;
    /**
     * Lien vers la page du jeu
     * @var string
     */
    protected string $link;
    /**
     * Identifiant en base de données du développeur
     * @var int|null
     */
    protected ?int $developerId;
    /**
     * Identifiant en base de données de la plateforme
     * @var int|null
     */
    protected ?int $platformId;

    /**
     * Répercute l'état actuel de l'objet sur un enregistrement en base de données
     *
     * @return void
     */
    public function save()
    {
        // Si aucun l'objet n'a pas d'idenitfiant, c'est donc qu'aucun enregistrement correspondant n'existe encore en base de données
        if (is_null($this->id)) {
            // Crée un nouvel enregistrement en base de données à partir des informations contenues dans l'objet
            $this->create();
        // Sinon, c'est donc qu'il existe déjà un enregistrement correspondant en base de données
        } else {
            // Met à jour un enregistrement existant en base de données à partir des propriétés de cet objet
            $this->update();
        }
    }
    
    /**
     * Crée un nouvel enregistrement en base de données à partir des propriétés de cet objet
     *
     * @return void
     */
    protected function create()
    {
        $this->id = SqlDatabaseHandler::insert('game', [
            'title' => $this->title,
            'link' => $this->link,
            'release_date' => $this->releaseDate->format('Y-m-d H:i:s'),
            'developer_id' => $this->developerId,
            'platform_id' => $this->platformId,
        ]);
    }

    /**
     * Met à jour un enregistrement existant en base de données à partir des propriétés de cet objet
     *
     * @return void
     */
    protected function update()
    {
        SqlDatabaseHandler::update('game', $this->id, [
            'title' => $this->title,
            'link' => $this->link,
            'release_date' => $this->releaseDate->format('Y-m-d H:i:s'),
            'developer_id' => $this->developerId,
            'platform_id' => $this->platformId,
        ]);
    }

    /**
     * Supprime un enregistrement existant en base de données correspondant à cet objet
     *
     * @return void
     */
    public function delete()
    {
        SqlDatabaseHandler::delete('game', $this->id);
        // Remet l'identifiant à zéro
        $this->id = null;
    }

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
