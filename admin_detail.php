<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$user_id = (int)($_GET['user'] ?? 0);

$user = $conn->prepare("SELECT nama, email, kelas FROM users WHERE id=?");
$user->bind_param("i", $user_id);
$user->execute();
$userData = $user->get_result()->fetch_assoc();
$user->close();

if (!$userData) {
    die("User tidak ditemukan");
}

$survey = $conn->prepare("SELECT created_at, pdf_file FROM survey_answers WHERE user_id=? ORDER BY created_at ASC");
$survey->bind_param("i", $user_id);
$survey->execute();
$result = $survey->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Survey</title>
<style>
body {
    font-family:'Segoe UI',sans-serif;
    margin:0;
    padding:40px;
    background: url('assett/img/foto3.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
}
.container{
    max-width:800px;
    margin:0 auto;
    padding:20px;
    background: rgba(255,255,255,0.95);
    border-radius:12px;
}
h1,h2{color:#0d2a44;}
table{
    width:100%;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
}
th,td{
    padding:12px;
    text-align:center;
}
th{
    background:#2196f3;
    color:white;
}
tr:nth-child(even){background:#f9f9f9;}
.back{
    display:inline-block;
    margin-bottom:20px;
    color:#2196f3;
    text-decoration:none;
}
</style>
</head>
<body>

<a class="back" href="admin_dashboard.php">← Kembali</a>

<div class="container">
<h1><?= htmlspecialchars($userData['nama']) ?></h1>
<p>Email: <?= htmlspecialchars($userData['email']) ?></p>
<p>Kelas: <?= htmlspecialchars($userData['kelas']) ?></p>

<h2>Laporan</h2>
<table>
<tr>
    <th>Tanggal</th>
    <th>PDF</th>
</tr>
<?php while($s = $result->fetch_assoc()): ?>
<tr>
    <td><?= date('d M Y H:i', strtotime($s['created_at'])) ?></td>
    <td>
        <?php if(!empty($s['pdf_file'])): ?>
            <a href="path/to/pdf/<?= htmlspecialchars($s['pdf_file']) ?>" target="_blank">Buka PDF</a>
        <?php else: ?>
            Tidak ada PDF
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
</div>

</body>
</html>
