<?php
require_once('../app/config/config.php');
class DB {
    protected $pdo;

    public function __construct() {
        
        try {
            $dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME;
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }
}
?>