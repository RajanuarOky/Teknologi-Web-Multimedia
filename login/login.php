<?php
//session
session_start();

if(isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi format email
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = "Format username harus berupa alamat email yang valid (contoh: user@example.com)";
    } else {
        // Koneksi ke database MySQL
        $conn = new mysqli("localhost", "root", "", "login_oky");

        // Check koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Enkripsi password dengan MD5
        $password_md5 = md5($password);

        // Query untuk memeriksa apakah username dan password sesuai
        $sql = "SELECT id FROM users WHERE username = '$username' and password = '$password_md5'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $result->num_rows;

        // Jika hasil query mengembalikan baris > 0, maka login berhasil
        if($count == 1) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
        } else {
            $error = "Username atau password salah";
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" placeholder="Masukkan email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required><br>
            <button type="submit">Login</button>
        </form>
        <?php if(isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
    </div>
</body>
</html>
