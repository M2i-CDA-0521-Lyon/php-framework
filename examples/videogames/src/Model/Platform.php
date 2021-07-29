<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;

/**
 * Représente une plateforme ludique
 */
#[Table('platform')]
class Platform extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var int|null
     */
    protected ?int $id;
    /**
     * Nom de la plateforme
     * @var string
     */
    #[Column('name')]
    protected string $name;
    /**
     * Lien vers la page de la plateforme
     * @var string
     */
    #[Column('link')]
    protected string $link;
    
    /**
     * Crée une nouvelle plateforme
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $name Nom de la plateforme
     * @param string $link Lien vers la page de la plateforme
     */
    public function __construct(
        ?int $id = null,
        string $name = '',
        string $link = ''
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
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
     * Get nom de la plateforme
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nom de la plateforme
     *
     * @param  string  $name  Nom de la plateforme
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get lien vers la page de la plateforme
     *
     * @return  string
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set lien vers la page de la plateforme
     *
     * @param  string  $link  Lien vers la page de la plateforme
     *
     * @return  self
     */ 
    public function setLink(string $link)
    {
        $this->link = $link;

        return $this;
    }
}
