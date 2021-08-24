<?php

namespace Cda0521Framework\Database;

use ReflectionClass;
use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

/**
 * Classe servant de base à toutes les classe de modéles
 */
abstract class AbstractModel
{
    /**
     * Récupére tous les éléments de la table associée à la classe appelante sous forme d'objets
     */
    static public function findAll()
    {
        // Récupère le nom de la classe qui a appelé cette méthode
        $className = get_called_class();
        // Récupère tous les enregistrements de la table concernée
        $data = SqlDatabaseHandler::fetchAll(static::getTableName());
        // Pour chaque enregistrement
        foreach ($data as $item) {
            // Construit un objet de la classe concernée
            // Dans la mesure où chaque table posséde un nombre de colonnes différent
            // (et donc que chaque classe attend un nombre de propriétés différent),
            // utilise l'opérateur ... pour "déplier" la liste des données de l'enregistrement
            // afin de les passer comme des paramètres séparés au constructeur de la classe
            $result []= new $className(...$item);
        }
        return $result;
    }

    /**
     * Récupère un élément de la table associée à la classe appelante en fonction de son identifiant en base de données sous forme d'objet
     *
     * @param integer $id Identifiant en base de données de l'élément désiré
     */
    static public function findById(int $id)
    {
        // Récupère le nom de la classe qui a appelé cette méthode
        $className = get_called_class();

        $item = SqlDatabaseHandler::fetchById(static::getTableName(), $id);
        if (is_null($item)) {
            return null;
        }
        return new $className(...$item);
    }

    /**
     * Récupère tous les éléments de la table associée à la classe appelante  pour lesquels un critère donné correspond à une valeur donnée
     *
     * @param string $columnName Le nom de la colonne à comparer
     * @param string $value La valeur recherchée dans la colonne
     */
    static public function findWhere(string $columnName, string $value)
    {
        // Récupère le nom de la classe qui a appelé cette méthode
        $className = get_called_class();

        // Récupère tous les enregistrements de la table concernée
        $data = SqlDatabaseHandler::fetchWhere(static::getTableName(), $columnName, $value);
        // Pour chaque enregistrement
        foreach ($data as $item) {
            // Construit un objet de la classe concernée
            // Dans la mesure où chaque table posséde un nombre de colonnes différent
            // (et donc que chaque classe attend un nombre de propriétés différent),
            // utilise l'opérateur ... pour "déplier" la liste des données de l'enregistrement
            // afin de les passer comme des paramètres séparés au constructeur de la classe
            $result []= new $className(...$item);
        }
        return $result;
    }

    /**
     * Supprime un enregistrement existant en base de données correspondant à cet objet
     *
     * @return void
     */
    public function delete()
    {
        SqlDatabaseHandler::delete(static::getTableName(), $this->id);
        // Remet l'identifiant à zéro
        $this->id = null;
    }

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
        $this->id = SqlDatabaseHandler::insert(static::getTableName(), $this->getProperties());
    }

    /**
     * Met à jour un enregistrement existant en base de données à partir des propriétés de cet objet
     *
     * @return void
     */
    protected function update()
    {
        SqlDatabaseHandler::update(static::getTableName(), $this->id, $this->getProperties());
    }

    /**
     * Récupère l'ensemble des propriétés de l'objet sous forme d'un tableau de noms de colonnes/valeurs à envoyer en base de données
     *
     * @return void
     */
    protected function getProperties(): array
    {
        // Crée un objet permettant d'accéder aux propriétés de la classe appelante
        $reflection = new ReflectionClass(get_called_class());
        // Pour chaque propriété définie dans la classe
        foreach ($reflection->getProperties() as $property) {
            // Pour chaque attribut associé à la propriété
            foreach ($property->getAttributes() as $reflectionAttribute) {
                // Instancie l'attribut afin de pouvoir le manipuler
                $attribute = $reflectionAttribute->newInstance();
                // Si l'attribut représente une colonne en base de données
                if ($attribute instanceof Column) {
                    // Récupère le nom de la colonne
                    $columnName = $attribute->getName();
                    // Récupère le nom de la propriété et sa valeur dans l'objet
                    $propertyName = $property->getName();
                    $value = $this->$propertyName;
                    // Si la propriété représente une date, sérialise cette date
                    if ($value instanceof \DateTime) {
                        $value = $value->format('Y-m-d H:i:s');
                    }
                    // Si la propriété représente un booléen, convertit le booléan en nombre
                    if (is_bool($value)) {
                        $value = (int)$value;
                    }
                    // Ajoute une entrée associant le nom de la colonne à la valeur de la propriété dans l'objet
                    $result [$columnName] = $value;
                }
            }
        }
        return $result;
    }

    /**
     * Récupère le nom de la table associé à la classe appelante
     *
     * @return string
     */
    static protected function getTableName(): string
    {
        // Crée un objet permettant d'accéder aux propriétés de la classe appelante
        $reflection = new ReflectionClass(get_called_class());

        // Pour chaque attribut associé à la classe
        foreach ($reflection->getAttributes() as $reflectionAttribute) {
            // Instancie l'attribut tel qu'il est écrit dans le code de la classe
            $attribute = $reflectionAttribute->newInstance();
            // S'il s'agit d'un attribut "table"
            if ($attribute instanceof Table) {
                // Renvoie le nom de l'attribut
                return $attribute->getName();
            }
        }

        // Si la boucle s'est terminée sans avoir trouvé d'attribut "table", envoie une erreur
        throw new \Exception('Models must have a Table attribute.');
    }
}
