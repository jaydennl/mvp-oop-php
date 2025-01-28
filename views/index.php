<?php
session_start(); // Zorg ervoor dat de sessie wordt gestart

// Databaseverbinding
$dsn = 'mysql:host=localhost;dbname=projectmvc';
$username = 'root';
$password = '';
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Clubs ophalen
    $stmtClubs = $pdo->query("SELECT * FROM clubs");
    $clubs = $stmtClubs->fetchAll(PDO::FETCH_ASSOC);

    // Spelers ophalen
    $stmtPlayers = $pdo->query("SELECT * FROM players");
    $players = $stmtPlayers->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Fout bij het verbinden met de database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JZ Layout</title>
    <link rel="stylesheet" href="../css/HomepaginaMVC.css">
</head>
<body>
    <header class="header">
        <h1>JZ</h1>
        <div class="profile">
            <img src="../images/default-profile.png" alt="Profielfoto" class="profile-photo">
            <span class="profile-username">
                <?php 
                if (isset($_SESSION['gebruikersnaam'])) {
                    echo htmlspecialchars($_SESSION['gebruikersnaam']); // Gebruik de veilige methode
                } else {
                    echo "Gast"; // Toon 'Gast' als er geen gebruiker is ingelogd
                }
                ?>
            </span>
        </div>
    </header>
    <main class="main">
        <section class="section clubs">
            <h2>Clubs</h2>
            <div class="carousel">
                <button class="arrow left" onclick="scrollCarousel('clubs', -1)">&#9664;</button>
                <div class="items" id="clubs">
                    <?php foreach ($clubs as $club): ?>
                        <div class="item"><?= htmlspecialchars($club['name']) ?></div>
                    <?php endforeach; ?>
                </div>
                <button class="arrow right" onclick="scrollCarousel('clubs', 1)">&#9654;</button>
            </div>
        </section>
        <hr>
        <section class="section spelers">
            <h2>Spelers</h2>
            <div class="carousel">
                <button class="arrow left" onclick="scrollCarousel('spelers', -1)">&#9664;</button>
                <div class="items" id="spelers">
                    <?php foreach ($players as $player): ?>
                        <div class="item"><?= htmlspecialchars($player['name']) ?></div>
                    <?php endforeach; ?>
                </div>
                <button class="arrow right" onclick="scrollCarousel('spelers', 1)">&#9654;</button>
            </div>
        </section>
    </main>
    <form action="logout.php" method="post" style="display: inline;">
        <button type="submit" class="logout-button">Uitloggen</button>
    </form>
</body>
<script src="index.js"></script>
</html>
