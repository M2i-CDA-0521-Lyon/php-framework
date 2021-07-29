<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;

/**
 * Représente un développeur de jeux
 */
#[Table('developer')]
class Developer extends AbstractModel
{
    /**
     * Identifiant en base de données
     * @var int|null
     */
    protected ?int $id;
    /**
     * Nom du développeur
     * @var string
     */
    #[Column('name')]
    protected string $name;
    /**
     * Lien vers la page du développeur
     * @var string
     */
    #[Column('link')]
    protected string $link;
    
    /**
     * Crée un nouveau développeur
     *
     * @param integer|null $id Identifiant en base de données
     * @param string $name Nom du développeur
     * @param string $link Lien vers la page du développeur
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
     * Get nom du développeur
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nom du développeur
     *
     * @param  string  $name  Nom du développeur
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get lien vers la page du développeur
     *
     * @return  string
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set lien vers la page du développeur
     *
     * @param  string  $link  Lien vers la page du développeur
     *
     * @return  self
     */ 
    public function setLink(string $link)
    {
        $this->link = $link;

        return $this;
    }
}
