<?php
session_start();
include 'koneksi.php';

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

/* ===== AMBIL DATA USER ===== */
$stmt = $conn->prepare("
    SELECT nama, nis, kelas, email
    FROM users
    WHERE id = ?
");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$inisial = strtoupper(substr($user['nama'], 0, 1));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya</title>
<link rel="stylesheet" href="assett/navbar.css">

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#2196f3,#64b5f6);
    margin:0;
    min-height:100vh;
}

/* CARD */
.profile-container{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:85vh;
}

.profile-card{
    background:white;
    width:420px;
    border-radius:18px;
    padding:35px;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
    text-align:center;
    animation:fadeIn .6s ease;
}

/* AVATAR */
.avatar{
    width:110px;
    height:110px;
    border-radius:50%;
    background:#2196f3;
    color:white;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:42px;
    font-weight:700;
    margin:0 auto 15px;
}

/* NAMA */
.profile-card h2{
    margin:10px 0 5px;
    color:#0d2a44;
}

/* INFO */
.profile-info{
    margin-top:25px;
    text-align:left;
}

.profile-info div{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid #eee;
    font-size:15px;
}

.profile-info span:first-child{
    color:#777;
    font-weight:500;
}

.profile-info span:last-child{
    font-weight:600;
    color:#333;
}

/* BUTTON */
.profile-actions{
    margin-top:25px;
}

.profile-actions a{
    display:inline-block;
    padding:10px 22px;
    background:#2196f3;
    color:white;
    border-radius:25px;
    text-decoration:none;
    font-weight:500;
    transition:.3s;
}

.profile-actions a:hover{
    background:#1976d2;
}

/* ANIMASI */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

@media(max-width:480px){
    .profile-card{width:90%;}
}
</style>
</head>

<body>

<?php require 'assett/navbar.php'; ?>

<div class="profile-container">
    <div class="profile-card">

        <div class="avatar"><?= $inisial ?></div>

        <h2><?= htmlspecialchars($user['nama']) ?></h2>
        <p style="color:#777;margin:0;">Profil Pengguna</p>

        <div class="profile-info">
            <div>
                <span>NIS</span>
                <span><?= htmlspecialchars($user['nis']) ?></span>
            </div>
            <div>
                <span>Kelas</span>
                <span><?= htmlspecialchars($user['kelas']) ?></span>
            </div>
            <div>
                <span>Email</span>
                <span><?= htmlspecialchars($user['email']) ?></span>
            </div>
        </div>

        <div class="profile-actions">
            <a href="edit_profil.php">Edit Profil</a>
        </div>

    </div>
</div>

</body>
</html>
