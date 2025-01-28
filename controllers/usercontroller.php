<?php
require_once "../config/database.php";
require_once "../models/usermodel.php";

class UserController {
    private $userModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $naam = $_POST['naam'];
            $achternaam = $_POST['achternaam'];
            $email = $_POST['email'];
            $gebruikersnaam = $_POST['gebruikersnaam'];
            $wachtwoord = $_POST['wachtwoord'];

            if ($this->userModel->register($naam, $achternaam, $email, $gebruikersnaam, $wachtwoord)) {
                header("Location: ../views/index.php");
                exit();
            } else {
                echo "Er is een fout opgetreden tijdens het registreren.";
            }
        }
    }
    
}



$controller = new UserController();
$controller->register();

// Automatisch inloggen van de gebruiker
$userId = $conn->lastInsertId();
$_SESSION['user_id'] = $userId;
$_SESSION['gebruikersnaam'] = $gebruikersnaam;

// Redirect naar de homepage
header("Location: ../views/index2.php");
exit();
?>
