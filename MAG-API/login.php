<?php

session_start();
require_once('functions.php');

if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $role = authenticate($username, $password);

    if ($role) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['id_user'] = $username;
        header('Location: dashboard.php');
    } else {
        $error = 'Username o password non corretti.';
        header('Location: index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
    <?php if ($error) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>