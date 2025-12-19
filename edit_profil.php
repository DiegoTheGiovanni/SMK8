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
    SELECT nama, nis, kelas
    FROM users
    WHERE id = ?
");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* ===== PROSES UPDATE ===== */
$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama  = trim($_POST['nama']);
    $nis   = trim($_POST['nis']);
    $kelas = trim($_POST['kelas']);

    if ($nama === '' || $nis === '' || $kelas === '') {
        
        $error = "Semua field wajib diisi.";
        
    } elseif(!preg_match('/^[0-9]{5,7}$/', $nis)) {
        
        $error = "NIS harus berupa angka dengan panjang 5-7 digit.";

    } else {
        
        $stmt = $conn->prepare("
            UPDATE users
            SET nama = ?, nis = ?, kelas = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sssi", $nama, $nis, $kelas, $_SESSION['id']);

        if ($stmt->execute()) {
            $success = "Profil berhasil diperbarui.";
        } else {
            $error = "Gagal memperbarui profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Profil</title>
<link rel="stylesheet" href="assett/navbar.css">

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#2196f3,#64b5f6);
    margin:0;
    min-height:100vh;
}

.edit-container{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:85vh;
}

.edit-card{
    background:white;
    width:440px;
    border-radius:18px;
    padding:35px;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
    animation:fadeIn .5s ease;
}

.edit-card h2{
    margin-bottom:20px;
    color:#0d2a44;
    text-align:center;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    font-weight:600;
    margin-bottom:6px;
    color:#444;
}

.form-group input{
    width:100%;
    padding:10px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:14px;
}

.form-group input:focus{
    outline:none;
    border-color:#2196f3;
}

.alert{
    padding:10px;
    border-radius:10px;
    margin-bottom:15px;
    text-align:center;
    font-size:14px;
}

.alert-success{
    background:#e8f5e9;
    color:#2e7d32;
}

.alert-error{
    background:#ffebee;
    color:#c62828;
}

.form-actions{
    display:flex;
    justify-content:space-between;
    margin-top:20px;
}

.form-actions a,
.form-actions button{
    padding:10px 22px;
    border-radius:25px;
    border:none;
    cursor:pointer;
    font-weight:500;
    text-decoration:none;
}

.form-actions a{
    background:#eee;
    color:#333;
}

.form-actions button{
    background:#2196f3;
    color:white;
}

.form-actions button:hover{
    background:#1976d2;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(15px);}
    to{opacity:1; transform:translateY(0);}
}

@media(max-width:480px){
    .edit-card{width:90%;}
}
</style>
</head>

<body>

<?php require 'assett/navbar.php'; ?>

<div class="edit-container">
    <div class="edit-card">

        <h2>Edit Profil</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" value="<?= htmlspecialchars($user['nis']) ?>" required>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($user['kelas']) ?>" required>
            </div>

            <div class="form-actions">
                <a href="profil.php">Batal</a>
                <button type="submit">Simpan</button>
            </div>
        </form>

    </div>
</div>

</body>
</html>
