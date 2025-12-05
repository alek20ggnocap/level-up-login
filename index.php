<?php
require "config.php";

if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kiosk Login</title>
</head>
<body>

<h2>Benvenuto!</h2>
<a href="login.php">Login</a><br><br>
<a href="register.php">Registrati</a>

</body>
</html>
