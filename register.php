<?php
require "config.php";
require "db.php";

// Consentire la registrazione SOLO se il PC ha il cookie della postazione
if (!isset($_COOKIE[$KIOSK_COOKIE]) || $_COOKIE[$KIOSK_COOKIE] !== $KIOSK_ID) {
    die("Registrazione consentita solo dalla postazione dedicata.");
}

$users = loadDb("users.json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    foreach ($users as $u)
        if ($u["username"] == $username)
            die("Username già esistente");

    $users[] = [
        "username" => $username,
        "password" => $pass
    ];

    saveDb("users.json", $users);

    echo "Registrazione completata. <a href='login.php'>Vai al login</a>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registrazione</title>
</head>
<body>

<h2>Registrazione</h2>

<form method="POST">
    <input name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Registrati</button>
</form>

</body>
</html>
