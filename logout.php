<?php
require "config.php";
require "db.php";

$logs = loadDb("logs.json");

$user = $_SESSION["user"] ?? null;

if ($user) {
    foreach ($logs as &$l)
        if ($l["username"] == $user && !isset($l["logout"]))
            $l["logout"] = date("Y-m-d H:i:s");
}

saveDb("logs.json", $logs);

session_destroy();
header("Location: index.php");
exit;
