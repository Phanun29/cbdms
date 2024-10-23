<?php
session_start();

// If user is not logged in, redirect to login page
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit();
}

// Display user information or dashboard content

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?= "Welcome, " . $_SESSION['username']; ?>
</body>

</html>