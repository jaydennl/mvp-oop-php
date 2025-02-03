    <?php
    require_once '../config/database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $wachtwoord = $_POST['wachtwoord'];
        $db = new Database();
        $conn = $db->getConnection();

      
        if (!empty($gebruikersnaam) && !empty($wachtwoord)) {
            try {
          
                $query = "SELECT * FROM users WHERE gebruikersnaam = :gebruikersnaam";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                   
                    if (password_verify($wachtwoord, $user['wachtwoord'])) {

                        session_start();
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['gebruikersnaam'] = $user['gebruikersnaam'];

                        header("Location: index.php");
                        exit();
                    } else {
                        $error = "Onjuist wachtwoord. Probeer het opnieuw.";
                    }
                } else {
                    $error = "Gebruikersnaam bestaat niet.";
                }
            } catch (PDOException $e) {
                $error = "Er is een fout opgetreden: " . $e->getMessage();
            }
        } else {
            $error = "Vul zowel gebruikersnaam als wachtwoord in.";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inloggen</title>
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <div class="container">
            <h2>Inloggen</h2>
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <input type="hidden" name="action" value="login">

                <div class="form-group">
                    <label for="gebruikersnaam">Gebruikersnaam:</label>
                    <input type="text" id="gebruikersnaam" name="gebruikersnaam" required placeholder="Vul je gebruikersnaam in">
                </div>

                <div class="form-group">
                    <label for="wachtwoord">Wachtwoord:</label>
                    <input type="password" id="wachtwoord" name="wachtwoord" required placeholder="Vul je wachtwoord in">
                </div>

                <button class="btn" type="submit">Inloggen</button>
            </form>

            <div class="form-footer">
                <p>Heb je nog geen account? <a href="register.php">Registreren</a></p>
            </div>
        </div>
    </body>
    </html>
