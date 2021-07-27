<?php

namespace Cda0521Framework\Database\Sql;

use Attribute;

/**
 * Attribut représentant la table d'une base de données SQL associée à une classe
 */
#[Attribute]
class Table
{
    /**
     * Le nom de la table
     * @var string
     */
    private string $name;

    /**
     * Crée un nouvel attribut "table"
     *
     * @param string $name Le nom de la table
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get le nom de la table
     */ 
    public function getName()
    {
        return $this->name;
    }
}
