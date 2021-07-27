<?php

namespace Cda0521Framework\Database;

use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

class AbstractModel
{
    static public function findAll()
    {
        // Récupère le nom de la classe qui a appelé cette méthode
        $className = get_called_class();
        // Récupère tous les enregistrements de la table concernée
        $data = SqlDatabaseHandler::fetchAll($className::$tableName);
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

    static public function findById(int $id)
    {
        // Récupère le nom de la classe qui a appelé cette méthode
        $className = get_called_class();

        $item = SqlDatabaseHandler::fetchById($className::$tableName, $id);
        if (is_null($item)) {
            return null;
        }
        return new $className(...$item);
    }
}
