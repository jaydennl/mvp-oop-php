<!-- filepath: /c:/xampp/htdocs/mvp-oop-php/views/logout.php -->
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>