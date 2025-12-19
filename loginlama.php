<?php
session_start();
include 'koneksi.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id'] = $user['id'];

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: beranda.php");
        }
        exit;
    } else {
        $message = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="POST">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <?php if($message) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    <p>Belum punya akun? <a href="signup.php">Sign Up</a></p>
</form>
</body>
</html>
