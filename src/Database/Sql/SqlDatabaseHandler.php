<?php

namespace Cda0521Framework\Database\Sql;

use PDO;

/**
 * Service permettant de communiquer avec une base de données SQL
 */
class SqlDatabaseHandler
{
    /**
     * L'unique instance du service
     * @var 
     */
    static private SqlDatabaseHandler $instance;
    /**
     * Interface permettant de communiquer avec la base de données
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Récupère l'unique instance du service
     *
     * @return void
     */
    static public function getInstance()
    {
        // Si aucune instance du service n'existe, en crée une, sinon renvoie l'instance existante
        if (!isset(self::$instance)) {
            self::$instance = new SqlDatabaseHandler();
        }
        return self::$instance;
    }

    /**
     * Crée un nouveau getsionnaire de base de données
     */
    private function __construct()
    {
        // Récupère le contenu du fichier database.json défini dans le dossier du projet client
        $fileContent = \file_get_contents('database.json');
        // Interpréte le contenu du fichier JSON comme un tableau associatif
        $config = \json_decode($fileContent, true);

        // Configure la connexion à la base de données
        $this->pdo = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
    }

    /**
     * Récupère tous les enregistrements provenant d'une table donnée
     *
     * @param string $tableName Le nom de la table dans laquelle récupérer les enregistrements
     * @return array
     */
    static public function fetchAll(string $tableName): array
    {
        $statement = self::getInstance()->pdo->query('SELECT * FROM `' . $tableName . '`');
        return $statement->fetchAll();
    }

    /**
     * Récupère un enregistrement d'une table donnée en fonction de son identifiant
     *
     * @param string $tableName Le nom de la table dans laquelle récupérer l'enregistrement
     * @param integer $id L'identifiant de l'enregistrement désiré
     * @return array|null
     */
    static public function fetchById(string $tableName, int $id): ?array
    {
        $results = self::fetchWhere($tableName, 'id', $id);
        if (empty($results)) {
            return null;
        }
        return $results[0];
    }

    /**
     * Undocumented function
     *
     * @param string $tableName Le nom de la table dans laquelle récupérer les enregistrements
     * @param string $columnName Le nom de la colonne à comparer
     * @param string $value La valeur recherchée dans la colonne
     * @return array
     */
    static public function fetchWhere(string $tableName, string $columnName, string $value): array
    {
        $statement = self::getInstance()->pdo->prepare('SELECT * FROM `' . $tableName . '` WHERE `' . $columnName . '` = :value');
        $statement->execute([ ':value' => $value ]);
        return $statement->fetchAll();
    }
}
