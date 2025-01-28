<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($naam, $achternaam, $email, $gebruikersnaam, $wachtwoord) {
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (naam, achternaam, email, gebruikersnaam, wachtwoord)
                  VALUES (:naam, :achternaam, :email, :gebruikersnaam, :wachtwoord)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':wachtwoord', $hashedPassword);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
