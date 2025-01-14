<?php
$db = new mysqli('localhost', 'root', '', 'projectmvc');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $password = password_hash($_POST['wachtwoord'], PASSWORD_BCRYPT);

    // Voeg de nieuwe gebruiker toe aan de database
    $stmt = $db->prepare("INSERT INTO users (naam, achternaam, email, gebruikersnaam, wachtwoord) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $naam, $achternaam, $email, $gebruikersnaam, $password);

    if ($stmt->execute()) {
        echo "Registratie succesvol! <a href='login.php'>Ga naar login</a>";
    } else {
        echo "Er is een fout opgetreden bij het registreren.";
    }
}
?>

<form method="post">
    <label for="naam">Naam:</label>
    <input type="text" id="naam" name="naam" required>
    <label for="achternaam">Achternaam:</label>
    <input type="text" id="achternaam" name="achternaam" required>
    <label for="email">E-mailadres:</label>
    <input type="email" id="email" name="email" required>
    <label for="gebruikersnaam">Gebruikersnaam:</label>
    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required>
    <label for="wachtwoord">Wachtwoord:</label>
    <input type="password" id="wachtwoord" name="wachtwoord" required>
    <button type="submit">Registreren</button>
</form>
    