<?php
session_start();

// Cek session apakah pengguna telah login
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fitur logout
if(isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <p>Selamat datang, <?php echo $_SESSION['username']; ?></p>
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
