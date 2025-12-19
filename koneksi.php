<?php
$servername = "localhost";
$username = "root"; // ganti sesuai MySQL Anda
$password = "";
$dbname = "user_db"; // ganti sesuai database Anda  

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) die("Koneksi gagal: " . mysqli_connect_error());
?>
