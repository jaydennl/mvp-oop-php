<?php
require 'controllers/AuthController.php';

// Maak een verbinding met de database
$db = new mysqli('localhost', 'root', '', 'projectmvc');
if ($db->connect_error) {
    die("Verbinding mislukt: " . $db->connect_error);
}

$authController = new AuthController($db);

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/login':
        $authController->login();
        break;
    case '/registreren':
        $authController->register();
        break;
    default:
        http_response_code(404);
        echo "Pagina niet gevonden.";
        break;
}
