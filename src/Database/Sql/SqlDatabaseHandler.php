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
        // TODO Vérifier que le fichier de configuration existe
        // Récupère le contenu du fichier database.json défini dans le dossier du projet client
        $fileContent = \file_get_contents('database.json');
        // Interpréte le contenu du fichier JSON comme un tableau associatif
        $config = \json_decode($fileContent, true);
        // TODO Vérifier que le fichier de configuration contient bien toutes les informations attendues

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
        return $statement->fetchAll(PDO::FETCH_NUM);
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
     * Récupère tous les enregistrements provenant d'une table donnée correspondant à un critère fourni
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
        return $statement->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * Crée un nouvel enregistrement dans la table fournie à partir des données fournies
     *
     * @param string $tableName La table sur laquelle créer un enregistrement
     * @param array $data Un tableau associatif contenant la liste de toutes les colonnes associées à leur valeur
     * @return integer
     */
    static public function insert(string $tableName, array $data): int
    {
        // Pour chaque couple de nom de colonne/valeur présent dans les données fournies
        // Exemple: $data = [ 'title' => 'Coucou', 'link' => 'http://www.google.com', ... ];
        foreach ($data as $columnName => $value) {
            // Construit un tableau contenant tous les noms de colonnes
            // Exemple: $columnNames = [ '`title`', '`link`', ... ]
            $columnNames []= '`' . $columnName . '`';
            // Construit un tableau contenant tous les noms des champs à remplacer lors de l'exécution de la requête préparée
            // Exemple: $valueNames = [ ':title', ':link', ... ]
            $valueNames []= ':' . $columnName;
            // Construit un tableau contenant toutes les valeurs associées au nom du champ remplaçable
            // Exemple: $parameters = [ ':title' => 'Coucou', ':link' => 'http://www.google.com', ... ];
            $parameters [':' . $columnName] = $value;
        }

        $sql = 'INSERT INTO `' . $tableName . '` (' . join(', ', $columnNames) . ') VALUES (' . join(', ', $valueNames) . ')';
        $statement = self::getInstance()->pdo->prepare($sql);
        $statement->execute($parameters);
        // Renvoie le dernier identifiant crée en base de données (afin qu'il puisse être assigné à l'objet correspondant)
        return self::getInstance()->pdo->lastInsertId();
    }

    /**
     * Modifie un enregistrement existant dans la table fournie à partir des données fournies
     *
     * @param string $tableName La table sur laquelle créer un enregistrement
     * @param integer $id Identifiant en base de données de l'enregistrement à modifier
     * @param array $data Un tableau associatif contenant la liste de toutes les colonnes associées à leur valeur
     * @return void
     */
    static public function update(string $tableName, int $id, array $data): void
    {
        // Pour chaque couple de nom de colonne/valeur présent dans les données fournies
        // Exemple: $data = [ 'title' => 'Coucou', 'link' => 'http://www.google.com', ... ];
        foreach ($data as $columnName => $value) {
            // Construit un tableau contenant chaque nom de colonne associé à un nom de champ à remplacer lors de l'exécution de la requête préparée
            // Exemple: $setNames = [ '`title` = :title', '`link` = :link', ... ]
            $setNames []= '`' . $columnName . '` = :' . $columnName;
            // Construit un tableau contenant toutes les valeurs associées au nom du champ remplaçable
            // Exemple: $parameters = [ ':title' => 'Coucou', ':link' => 'http://www.google.com', ... ];
            $parameters [':' . $columnName] = $value;
        }

        // Ajoute l'identifiant dans la liste des paramètres à remplacer lors de l'exécution
        $parameters[':id'] = $id;

        $sql = 'UPDATE `' . $tableName . '` SET ' . join(', ', $setNames) . ' WHERE `id` = :id';
        $statement = self::getInstance()->pdo->prepare($sql);
        $statement->execute($parameters);
    }

    /**
     * Supprime un enregistrement existant dans la table fournie à partir des données fournies
     *
     * @param string $tableName La table sur laquelle créer un enregistrement
     * @param integer $id L'identifiant de l'enregistrement à supprimer
     * @return void
     */
    static public function delete(string $tableName, int $id)
    {
        $statement = self::getInstance()->pdo->prepare('DELETE FROM `' . $tableName . '` WHERE `id` = :id');
        $statement->execute([ ':id' => $id ]);
    }
}
