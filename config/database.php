<?php
class Database {
    private $host = "localhost";
    private $db_name = "projectmvc";
    private $username = "root"; // Pas aan met jouw DB-gebruiker
    private $password = ""; // Pas aan met jouw DB-wachtwoord
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Database connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
