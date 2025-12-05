<?php

/**
 * Classe qui permet de se connecter à la base de données.
 * Cette classe est un singleton. Cela signifie qu'il n'est pas possible de créer plusieurs instances de cette classe.
 * Pour récupérer une instance de cette classe, il faut utiliser la méthode getInstance().
 */
class DBManager 
{
    // Création d'une classe singleton qui permet de se connecter à la base de données.
    // On crée une instance de la classe DBConnect qui permet de se connecter à la base de données.
    private static $instance;

    private PDO $db;

    /**
     * Constructeur de la classe DBManager.
     * Initialise la connexion à la base de données.
     * Ce constructeur est privé. Pour récupérer une instance de la classe, il faut utiliser la méthode getInstance().
     * @see DBManager::getInstance()
     */
    private function __construct() 
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        // On se connecte à la base de données.
        try {
            $this->db = new PDO($dsn, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            // Si la base n'existe pas encore, on la crée pour permettre l'initialisation via les fixtures.
            if (str_contains($e->getMessage(), 'Unknown database')) {
                $this->db = new PDO('mysql:host=' . DB_HOST . ';charset=utf8mb4', DB_USER, DB_PASS);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->db->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
                $this->db->exec('USE `' . DB_NAME . '`');
            } else {
                throw $e;
            }
        }

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Méthode qui permet de récupérer l'instance de la classe DBManager.
     * @return DBManager
     */
    public static function getInstance() : DBManager
    {
        if (!self::$instance) {
            self::$instance = new DBManager();
        }
        return self::$instance;
    }

    /**
     * Raccourci pour récupérer directement la connexion PDO.
     */
    public static function getConnection() : PDO
    {
        return self::getInstance()->getPDO();
    }

    /**
     * Méthode qui permet de récupérer l'objet PDO qui permet de se connecter à la base de données.
     * @return PDO
     */
    public function getPDO() : PDO
    {
        return $this->db;
    }

    /**
     * Méthode qui permet d'exécuter une requête SQL.
     * Si des paramètres sont passés, on utilise une requête préparée.
     * @param string $sql : la requête SQL à exécuter.
     * @param array|null $params : les paramètres de la requête SQL.
     * @return PDOStatement : le résultat de la requête SQL.
     */
    public function query(string $sql, ?array $params = null) : PDOStatement
    {
        if ($params == null) {
            $query = $this->db->query($sql);
        } else {
            $query = $this->db->prepare($sql);
            $query->execute($params);
        }
        return $query;
    }
    
}