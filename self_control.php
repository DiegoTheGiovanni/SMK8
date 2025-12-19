<?php
session_start();
include 'koneksi.php';

/* ===== TIMEZONE ===== */
date_default_timezone_set('Asia/Jakarta');

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $user_id = $_SESSION['id'];
    $control_date = $_POST['tanggal'] ?? date('Y-m-d');

    /* ===== SANITASI INPUT ===== */
    $nama  = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');

    $skala1 = isset($_POST['skala1']) ? (int)$_POST['skala1'] : -1;
    $skala2 = isset($_POST['skala2']) ? (int)$_POST['skala2'] : -1;
    $skala3 = isset($_POST['skala3']) ? (int)$_POST['skala3'] : -1;
    $skala4 = isset($_POST['skala4']) ? (int)$_POST['skala4'] : -1;
    $skala5 = isset($_POST['skala5']) ? (int)$_POST['skala5'] : -1;

    $situasi   = $_POST['situasi'] ?? '';
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $respon    = isset($_POST['respon']) ? implode(', ', $_POST['respon']) : '';
    $evaluasi  = $_POST['evaluasi'] ?? '';
    $catatan   = trim($_POST['catatan'] ?? '');

    /* ===== VALIDASI ===== */
    if (
        $nama === '' || $kelas === '' || $control_date === '' ||
        $skala1 < 0 || $skala2 < 0 || $skala3 < 0 || $skala4 < 0 || $skala5 < 0 ||
        $situasi === '' || $evaluasi === ''
    ) {
        die("ERROR: Data wajib belum lengkap.");
    }

    /* ===== CEK DUPLIKASI ===== */
    $check = $conn->prepare(
        "SELECT id FROM self_controls 
         WHERE user_id = ? AND DATE(control_date) = ?"
    );
    $check->bind_param("is", $user_id, $control_date);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("ERROR: Data sudah diisi pada tanggal ini.");
    }

    /* ===== INSERT ===== */
    $stmt = $conn->prepare(
        "INSERT INTO self_controls
        (user_id, control_date, nama, kelas,
         skala1, skala2, skala3, skala4, skala5,
         situasi, deskripsi, respon, evaluasi, catatan)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "isssiiiiisssss",
        $user_id, $control_date, $nama, $kelas,
        $skala1, $skala2, $skala3, $skala4, $skala5,
        $situasi, $deskripsi, $respon, $evaluasi, $catatan
    );

    if ($stmt->execute()) {
        header("Location: myaction.php");
        exit;
    } else {
        die("ERROR SQL: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Self-Report Tracker</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background:url('assett/img/foto6.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    padding: 40px;
    min-height: 100vh;
}

.container {
    max-width: 900px;
    margin: auto;
    background: rgba(255,255,255,0.92);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 25px 40px rgba(0,0,0,0.15);
}

h1 {
    text-align: center;
    color: #1e3a8a;
}

.subtitle {
    text-align: center;
    color: #475569;
    margin-bottom: 35px;
}

.section {
    background: #f8fbff;
    border: 1px solid #dbeafe;
    padding: 22px;
    margin-bottom: 26px;
    border-radius: 16px;
}

.section h2 {
    color: #2563eb;
    margin-bottom: 14px;
}

label {
    display: block;
    margin-bottom: 12px;
}

input[type="text"],
input[type="date"],
input[type="number"],
textarea {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #bfdbfe;
}

textarea {
    min-height: 90px;
}

/* ===== SKALA BARU ===== */
.scale-box {
    background: #ffffff;
    border: 1px solid #dbeafe;
    padding: 16px;
    border-radius: 14px;
    margin-bottom: 16px;
}

.scale-label {
    font-weight: 600;
    color: #1e3a8a;
    margin-bottom: 10px;
    display: block;
}

.scale-input {
    text-align: center;
    font-size: 16px;
}

.options label {
    margin-bottom: 8px;
}

button {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    border: none;
    font-size: 17px;
    border-radius: 14px;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="container">
<h1>Self-Report Tracker</h1>
<p class="subtitle">Refleksi singkat untuk mengendalikan perilaku verbalmu hari ini</p>

<form method="POST">

<div class="section">
<h2>1. Identitas Singkat</h2>
<label>Nama
<input type="text" name="nama" value="<?= $_SESSION['nama'] ?>"></label>

<label>Kelas
<input type="text" name="kelas"></label>

<label>Tanggal
<input type="date" name="tanggal"></label>
</div>

<div class="section">
<h2>2. Skala Kendali Diri (0–10)</h2>

<p>Masukkan angka dari 1-10 sesuai dengan beberapa pernyataan di bawah ini. Masukkan angka sesuai dengan keadaan diri Anda. <b>TOLONG DI ISI DENGAN JUJUR!!</b></p>

<div class="scale-box">
<label class="scale-label">Menahan diri sebelum berbicara (1-10)</label>
<input type="number" name="skala1" min="0" max="10" class="scale-input">
</div>

<div class="scale-box">
<label class="scale-label">Memilih kata-kata yang tepat (1-10)</label>
<input type="number" name="skala2" min="0" max="10" class="scale-input">
</div>

<div class="scale-box">
<label class="scale-label">Frekuensi bicara kasar / nyinyir (1-10)</label>
<input type="number" name="skala3" min="0" max="10" class="scale-input">
</div>

<div class="scale-box">
<label class="scale-label">Kesadaran saat berkata negatif (1-10)</label>
<input type="number" name="skala4" min="0" max="10" class="scale-input">
</div>

<div class="scale-box">
<label class="scale-label">Kemampuan mengubah pikiran negatif (1-10)</label>
<input type="number" name="skala5" min="0" max="10" class="scale-input">
</div>
</div>

<div class="section">
<h2>3. Apakah Ada Perilaku Verbal Negatif?</h2>
<label><input type="radio" name="situasi" value="Ya"> Ya</label>
<label><input type="radio" name="situasi" value="Tidak"> Tidak</label>
<textarea name="deskripsi" placeholder="Jika ya, jelaskan"></textarea>
</div>

<div class="section">
<h2>4. Respon yang Dipilih</h2>
<label><input type="checkbox" name="respon[]" value="Menarik napas"> Menarik napas</label>
<label><input type="checkbox" name="respon[]" value="Menghitung"> Menghitung</label>
<label><input type="checkbox" name="respon[]" value="Netral"> Kata netral</label>
<label><input type="checkbox" name="respon[]" value="Diam"> Diam</label>
</div>

<div class="section">
<h2>5. Evaluasi</h2>
<label><input type="radio" name="evaluasi" value="Sangat berhasil"> Sangat berhasil</label>
<label><input type="radio" name="evaluasi" value="Cukup berhasil"> Cukup berhasil</label>
<label><input type="radio" name="evaluasi" value="Masih sulit"> Masih sulit</label>
<label><input type="radio" name="evaluasi" value="Tidak berhasil"> Tidak berhasil</label>
</div>

<div class="section">
<h2>6. Catatan</h2>
<textarea name="catatan"></textarea>
</div>

<button type="submit" name="simpan">Simpan Refleksi</button>

</form>
</div>

</body>
</html>