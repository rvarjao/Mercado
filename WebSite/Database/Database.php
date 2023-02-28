<?php

namespace Database;

use PDO;
use PDOException;

class Database {

    private $conn;

    public function __construct() {
        $settings = require_once __DIR__ . "/../settings/settings.php";

        if (!isset($settings['DATABASE'])) {
            die("Database settings not found");
        }

        $database = $settings['DATABASE'];
        $host = $database['HOST'];
        $username = $database['USER'];
        $password = $database['PASSWORD'];
        $dbname = $database['NAME'];

        try {
            $dsn = "pgsql:host={$host};dbname={$dbname}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->conn = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
