<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'projectmvc');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Controleer of de gebruiker bestaat
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['wachtwoord'])) {
        $_SESSION['user_id'] = $user['id'];
        echo "Inloggen succesvol! Welkom, " . $user['naam'];
    } else {
        echo "Onjuiste gegevens.";
    }
}
?>

<form method="post">
    <label for="email">E-mailadres:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Inloggen</button>
</form>
