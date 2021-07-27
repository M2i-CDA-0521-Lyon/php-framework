<?php

namespace Cda0521Framework\Database;

use Cda0521Framework\Database\Sql\SqlDatabaseHandler;

class AbstractModel
{
    static public function findAllInTable(string $tableName, string $className)
    {
        // Récupère tous les enregistrements de la table concernée
        $data = SqlDatabaseHandler::fetchAll($tableName);
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

    static public function findByIdInTable(int $id, string $tableName, string $className)
    {
        $item = SqlDatabaseHandler::fetchById($tableName, $id);
        if (is_null($item)) {
            return null;
        }
        return new $className(...$item);
    }
}
