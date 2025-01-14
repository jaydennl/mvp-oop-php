<?php
class AuthController {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Check of de gebruiker bestaat
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['wachtwoord'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: /dashboard"); // Stuur de gebruiker door naar het dashboard
                exit;
            } else {
                echo "Onjuiste inloggegevens!";
            }
        }
        require 'views/login.html';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $naam = $_POST['naam'];
            $achternaam = $_POST['achternaam'];
            $email = $_POST['email'];
            $gebruikersnaam = $_POST['gebruikersnaam'];
            $password = password_hash($_POST['wachtwoord'], PASSWORD_BCRYPT);

            // Insert de gebruiker in de database
            $stmt = $this->db->prepare("INSERT INTO users (naam, achternaam, email, gebruikersnaam, wachtwoord) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $naam, $achternaam, $email, $gebruikersnaam, $password);

            if ($stmt->execute()) {
                echo "Registratie succesvol! <a href='/login'>Ga naar login</a>";
            } else {
                echo "Er is een fout opgetreden bij het registreren.";
            }
        }
        require 'views/registreren.html';
    }
}
