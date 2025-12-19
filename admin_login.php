<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email    = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare(
    "SELECT id, nama, password, role 
     FROM users 
     WHERE email=? 
     LIMIT 1"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header("Location: login.php?error=Email tidak terdaftar");
    exit;
}

if (!password_verify($password, $user['password'])) {
    header("Location: login.php?error=Password salah");
    exit;
}

/* LOGIN BERHASIL */
$_SESSION['id']   = $user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role'] = $user['role'];

/* REDIRECT BERDASARKAN ROLE */
if ($user['role'] === 'admin') {
    header("Location: admin_dashboard.php");
} else {
    header("Location: beranda.php");
}
exit;
