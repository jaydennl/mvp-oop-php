    <?php
    require_once '../config/database.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $gebruikersnaam = trim($_POST['gebruikersnaam']);
        $wachtwoord = trim($_POST['wachtwoord']);
        $hashedWachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

        if (!empty($gebruikersnaam) && !empty($wachtwoord)) {
            try {
             
                $checkQuery = "SELECT * FROM users WHERE gebruikersnaam = :gebruikersnaam";
                $checkStmt = $conn->prepare($checkQuery);
                $checkStmt->bindParam(':gebruikersnaam', $gebruikersnaam);
                $checkStmt->execute();

                if ($checkStmt->rowCount() > 0) {
                    $error = "Gebruikersnaam bestaat al. Kies een andere.";
                } else {
           
                    $query = "INSERT INTO users (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
                    $stmt->bindParam(':wachtwoord', $hashedWachtwoord);
                    $stmt->execute();

                
                    $userId = $conn->lastInsertId();
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['gebruikersnaam'] = $gebruikersnaam;

                    header("Location: ../views/index2.php");
                    exit();
                }
            } catch (PDOException $e) {
                $error = "Er is een fout opgetreden: " . $e->getMessage();
            }
        } else {
            $error = "Vul alle velden in.";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registreren</title>
        <link rel="stylesheet" href="../css/style.css">
        <script>
            function validateForm() {
                var password = document.getElementById("wachtwoord").value;
                var confirmPassword = document.getElementById("wachtwoord_bevestigen").value;

                if (password !== confirmPassword) {
                    alert("De wachtwoorden komen niet overeen.");
                    return false;
                }

                var passwordPattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;
                if (!passwordPattern.test(password)) {
                    alert("Het wachtwoord moet minimaal 8 tekens bevatten en zowel letters als cijfers.");
                    return false;
                }

                return true;
            }
        </script>
    </head>
    <body>
        <div class="container">
            <h2>Registreren</h2>
            <form action="../controllers/usercontroller.php" method="post" onsubmit="return validateForm()">
                <input type="hidden" name="action" value="register">

                <div class="form-group">
                    <label for="naam">Naam:</label>
                    <input type="text" id="naam" name="naam" required placeholder="Voornaam" aria-label="Voornaam">
                </div>

                <div class="form-group">
                    <label for="achternaam">Achternaam:</label>
                    <input type="text" id="achternaam" name="achternaam" required placeholder="Achternaam" aria-label="Achternaam">
                </div>

                <div class="form-group">
                    <label for="email">E-mailadres:</label>
                    <input type="email" id="email" name="email" required placeholder="email@example.com" aria-label="E-mailadres">
                </div>

                <div class="form-group">
                    <label for="gebruikersnaam">Gebruikersnaam:</label>
                    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required placeholder="Kies een gebruikersnaam" aria-label="Gebruikersnaam">
                </div>

                <div class="form-group">
                    <label for="wachtwoord">Wachtwoord:</label>
                    <input type="password" id="wachtwoord" name="wachtwoord" required placeholder="Kies een wachtwoord" aria-label="Wachtwoord">
                </div>

                <div class="form-group">
                    <label for="wachtwoord_bevestigen">Bevestig wachtwoord:</label>
                    <input type="password" id="wachtwoord_bevestigen" name="wachtwoord_bevestigen" required placeholder="Bevestig je wachtwoord" aria-label="Bevestig wachtwoord">
                </div>

                <button class="btn" type="submit">Registreren</button>
            </form>

            <div class="form-footer">
                <p>Heb je al een account? <a href="login.php">Inloggen</a></p>
            </div>
        </div>
    </body>
    </html>
    <?php
    // Einde van PHP-bestand
    ?>
