<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $port = 8889;
        $db = "test_db";
        $user = "root";
        $pass = "root";
        $charset = "utf8mb4";

        $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
