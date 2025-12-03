<?php
require_once "../app/config/database.php";
require_once "../app/controllers/AuthController.php";

$db = (new Database())->connect();
$auth = new AuthController($db);

session_start();

if ($auth->isLogged()) {
    header("Location: dashboard.php");
    exit;
}

include "../app/views/header.php";
?>
<h1>Welcome to LevelUp Login</h1>
<a href="login.php">Login</a> |
<a href="register.php">Register</a>
<?php include "../app/views/footer.php"; ?>