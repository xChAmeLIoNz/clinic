<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//echo "stai per essere disconnesso";

session_destroy();
header("Location: login.php");
exit;
?>