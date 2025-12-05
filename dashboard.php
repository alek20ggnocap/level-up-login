<?php
require "config.php";
require "db.php";

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user"];

$logs = loadDb("logs.json");

// filtri
$my_logs = array_filter($logs, fn($l)=>$l["username"] === $user);
$kiosk_count = count(array_filter($my_logs, fn($l)=>$l["source"]=="kiosk"));
?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>

<h1>Ciao <?=htmlspecialchars($user)?></h1>

<p><b>Accessi dalla postazione dedicata:</b> <?=$kiosk_count?></p>

<h2>Storico accessi</h2>
<table border="1" cellpadding="5">
<tr><th>Data Login</th><th>Logout</th><th>Sorgente</th></tr>

<?php foreach ($my_logs as $l): ?>
<tr>
    <td><?=$l["login"]?></td>
    <td><?=$l["logout"] ?? "-"?></td>
    <td><?=$l["source"]?></td>
</tr>
<?php endforeach; ?>
</table>

<br><br>
<a href="logout.php">Logout</a>

</body>
</html>
