<?php

namespace Cda0521Framework\Database\Sql;

use Attribute;

/**
 * Attribut représentant la colonne d'une table en base de données SQL associée à une propriété d'une classe
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    /**
     * Le nom de la colonne
     * @var string
     */
    private string $name;

    /**
     * Crée un nouvel attribut "colonne"
     *
     * @param string $name Le nom de la colonne
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get le nom de la colonne
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }
}