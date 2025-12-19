<!DOCTYPE html>
<html>
<head><title>Selesai</title></head>
<body>
<h2>Survey selesai</h2>
<p>Terima kasih telah mengisi survey.</p>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>