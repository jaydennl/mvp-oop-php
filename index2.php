<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['gebruikersnaam'])) {
    // Redirect naar de inlogpagina
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="path/to/your/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['gebruikersnaam']); ?></h2>
        <div class="profile">
            <img src="../images/default-profile.png" alt="Profielfoto" class="profile-photo">
            <span class="profile-username">
                <?php 
                echo htmlspecialchars($_SESSION['gebruikersnaam']); // Gebruik de veilige methode
                ?>
            </span>
            <button id="profileButton">Profile</button>
            <div id="profileMenu" class="profile-menu" style="display: none;">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profileButton').addEventListener('click', function() {
            var menu = document.getElementById('profileMenu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>
</html>