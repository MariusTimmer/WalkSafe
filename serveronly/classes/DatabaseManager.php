<?php

class DatabaseManager {

    protected static $manager;
    protected $pdo;

    public function __construct() {
        $this->connect();
    }

    public static function Build() {
        if (!DatabaseManager::$manager) {
            DatabaseManager::$manager = new DatabaseManager();
        }
        return DatabaseManager::$manager;
    }

    public function getConnection() {
        return $this->pdo;
    }

    protected function connect() {
        $json = json_decode(trim(file_get_contents(SERVERONLY_ROOT . DIRECTORY_SEPARATOR .'var'. DIRECTORY_SEPARATOR .'database.json')), false);
        if (!$json) {
            return false;
        }
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            $json->host,
            $json->port,
            $json->dbname
        );
        $this->pdo = new PDO($dsn, $json->username, $json->password, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ));
    }

    public function executeQuery($query, $param = array(), $fetch_all = true) {
        $statement = $this->pdo->prepare($query);
        foreach ($param AS $key => &$value) {
            $statement->bindParam(':'. $key, $value);
        }
        if (!$statement->execute()) {
            return false;
        }
        if ($fetch_all) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

}
