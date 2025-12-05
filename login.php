<?php
require "config.php";
require "db.php";

$users = loadDb("users.json");
$logs  = loadDb("logs.json");

// Se è la prima visita dalla postazione dedicata → imposto cookie
if (!isset($_COOKIE[$KIOSK_COOKIE])) {
    setcookie($KIOSK_COOKIE, $KIOSK_ID, time() + 3600*24*365, "/");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // verifica credenziali
    $found = null;
    foreach ($users as $u)
        if ($u["username"] == $username && password_verify($password, $u["password"]))
            $found = $u;

    if (!$found) die("Credenziali errate");

    // Detect se l'accesso è da kiosk o no
    $source = (isset($_COOKIE[$KIOSK_COOKIE]) && $_COOKIE[$KIOSK_COOKIE] == $KIOSK_ID)
        ? "kiosk"
        : "remote";

    // logout forzato del precedente utente del kiosk
    if ($source == "kiosk") {
        foreach ($logs as &$l)
            if (!isset($l["logout"]) && $l["source"] == "kiosk")
                $l["logout"] = date("Y-m-d H:i:s");
    }

    // registra nuovo login
    $logs[] = [
        "username" => $username,
        "login"    => date("Y-m-d H:i:s"),
        "source"   => $source
    ];

    saveDb("logs.json", $logs);

    $_SESSION["user"] = $username;

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Login</title></head>
<body>

<h2>Login</h2>

<form method="POST">
    <input name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Accedi</button>
</form>

</body>
</html>
