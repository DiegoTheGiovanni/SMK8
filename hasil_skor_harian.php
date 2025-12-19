<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$today   = date('Y-m-d');

/* ====== HITUNG TOTAL SKOR HARIAN ====== */
$stmt = $conn->prepare(
    "SELECT SUM(rating) AS total_skor
     FROM survey_answers
     WHERE user_id=? AND survey_date=?"
);
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$stmt->bind_result($totalSkor);
$stmt->fetch();
$stmt->close();

$totalSkor = (int)$totalSkor;
$kataKata = "";

/* ====== KATEGORISASI ====== */
if ($totalSkor >= 102 && $totalSkor <= 120) {
    $kategori = "Sangat Tinggi";
    $kataKata = "Kamu menunjukkan tingkat stres yang sangat tinggi hari ini. Disarankan untuk melakukan relaksasi atau aktivitas yang menyenangkan.";
} elseif ($totalSkor >= 84 && $totalSkor <= 101) {
    $kategori = "Tinggi";
    $kataKata = "Kamu mengalami tingkat stres yang tinggi hari ini. Cobalah untuk mengelola stres dengan baik dan luangkan waktu untuk diri sendiri.";
} elseif ($totalSkor >= 66 && $totalSkor <= 83) {
    $kategori = "Sedang";
    $kataKata = "Tingkat stres Kamu sedang hari ini. Pertahankan keseimbangan antara pekerjaan dan istirahat untuk menjaga kesehatan mental.";
} elseif ($totalSkor >= 48 && $totalSkor <= 65) {
    $kategori = "Rendah";
    $kataKata = "Kamu menunjukkan tingkat stres yang rendah hari ini. Teruslah menjaga keseimbangan dan kesehatan mental Kamu.";
} elseif ($totalSkor >= 30 && $totalSkor <= 47) {
    $kategori = "Sangat Rendah";
    $kataKata = "Kamu menunjukkan tingkat stres yang sangat rendah hari ini. Ini adalah indikasi bahwa Kamu sedang dalam kondisi baik.";
} else {
    $kategori = "Tidak Valid";
}

$_SESSION['survey_done'] = true;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Skor Harian</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    background:url('assett/img/foto6.jpg') no-repeat center center;
    background-size:cover;
    background-attachment:fixed;
}

/* WRAPPER PUSAT */
.page-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 20px;
}

/* CARD */
.card{
    background:#ffffff;
    padding:40px;
    border-radius:20px;
    width:100%;
    max-width:600px;
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
    text-align:center;
    animation:fadeIn 0.8s ease;
}

@keyframes fadeIn{
    from{opacity:0; transform:scale(0.95);}
    to{opacity:1; transform:scale(1);}
}

h2{
    margin-bottom:15px;
    color:#1e293b;
}

.total{
    font-size:52px;
    font-weight:700;
    color:#2196f3;
    margin:20px 0;
}

.kategori{
    font-size:22px;
    font-weight:600;
    margin-bottom:25px;
    color:#1f2937;
}

.kataKata{
    font-size:16px;
    margin-top:10px;
    font-weight:400;
}

.interval{
    background:#f5f5f5;
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
    font-size:16px;
    text-align:left;
}

.interval p{
    margin-bottom:6px;
}

button{
    padding:14px 40px;
    border:none;
    border-radius:30px;
    background:#2196f3;
    color:#ffffff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#1976d2;
    transform:translateY(-2px);
}
</style>
</head>

<body>

<div class="page-wrapper">
    <div class="card">
        <h2>Nilai Skor Kamu</h2>

        <div class="total"><?= $totalSkor ?></div>

        <div class="kategori">
            Kategori: <strong><?= $kategori ?></strong>
            <p class="kataKata"><?= $kataKata ?></p>
        </div>

        <div class="interval">
            <p><strong>Interval Nilai :</strong></p>
            <p><b>102 – 120</b> : Sangat Tinggi</p>
            <p><b>84 – 101</b>  : Tinggi</p>
            <p><b>66 – 83</b>   : Sedang</p>
            <p><b>48 – 65</b>   : Rendah</p>
            <p><b>30 – 47</b>   : Sangat Rendah</p>
        </div>

        <button onclick="location.href='assett/narasi/narasi_changeyourmind.php'">
            Tertarik ke Change Your Mind?
        </button>
    </div>
</div>

</body>
</html>
