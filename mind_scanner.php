<?php
session_start();
include 'koneksi.php';

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$today   = date('Y-m-d');

/* ===== DEFINISI ITEM ===== */
$rasionalItems = [2,7,11,16,21,25,27,29,30];
$irasionalItems = [1,3,4,5,6,8,9,10,12,13,14,15,17,18,19,20,22,23,24,26,28];

$showResult = false;
$rasionalScore = 0;
$irasionalScore = 0;
$kategori = "";
$penjelasan = "";
$definisiPolaPikir = "";

/* ===== PROSES SUBMIT ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $selected = $_POST['mind'] ?? [];

    /* ===== SERVER SIDE VALIDATION ===== */
    if (count($selected) < 5) {
        $showResult = false; // TETAP DI FORM
    } else {

        foreach ($selected as $item) {
            $item = (int)$item;

            if (in_array($item, $rasionalItems, true)) $rasionalScore++;
            if (in_array($item, $irasionalItems, true)) $irasionalScore++;
        }

        if ($rasionalScore > $irasionalScore) {
            $kategori = "Rasional";
            $penjelasan = "Pola pikir Anda cenderung rasional dan terkendali. Anda mampu mengekspresikan emosi secara sehat serta menjaga relasi sosial dengan baik.<br><br>Apakah ingin di perbaiki?";
        } elseif ($irasionalScore > $rasionalScore) {
            $kategori = "Irasional";
            $penjelasan = "Pola pikir Anda menunjukkan kecenderungan reaktif atau irasional. Refleksi diri dapat membantu memperbaiki pola ini.<br><br>Apakah ingin di perbaiki?";
        } else {
            $kategori = "Seimbang";
            $penjelasan = "Pola pikir Anda berada dalam kondisi seimbang antara rasional dan irasional.";
        }

        /* ===== SIMPAN DATABASE ===== */
        $stmt = $conn->prepare(
            "INSERT INTO mind_scanner_results
            (user_id, scan_date, rasional_score, irasional_score, kategori)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isiis",$user_id,$today,$rasionalScore,$irasionalScore,$kategori);
        $stmt->execute();
        $stmt->close();

        $showResult = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Mind Scanner</title>
<link rel="stylesheet" href="assett/navbar.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI,sans-serif;}
body{min-height:100vh;background:url('assett/img/foto6.jpg') no-repeat center center;background-size: cover;background-attachment: fixed;}
.card{
    background:#fff;
    margin:20px auto;
    padding:40px;
    border-radius:20px;
    max-width:760px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
}
h1{text-align:center;margin-bottom:10px;}
.instruction{text-align:center;margin-bottom:30px;font-weight:600;}
.checkbox-list{display:flex;flex-direction:column;gap:14px;}
.checkbox-item{
    display:flex;
    gap:12px;
    background:#f7f7f7;
    padding:14px 18px;
    border-radius:12px;
}
.checkbox-item input{margin-top:4px;transform:scale(1.2);}
button{
    margin-top:30px;
    padding:14px 40px;
    border:none;
    border-radius:30px;
    background:#2196f3;
    color:#fff;
    font-size:16px;
    cursor:pointer;
    display:block;
    margin:auto;
}
.result{text-align:center;}
.score{font-size:18px;margin:8px 0;}
.kategori{font-size:26px;font-weight:700;color:#2196f3;margin:15px 0;}
.penjelasan{font-size:15px;line-height:1.7;}
</style>

<script>
function validateCheckbox() {
    const checkboxes = document.querySelectorAll('input[name="mind[]"]:checked');
    if (checkboxes.length < 5) {
        alert("Minimal pilih 5 pernyataan sebelum melanjutkan.");
        return false; // CEGAH SUBMIT
    }
    return true;
}
</script>

</head>
<body>

<?php require 'assett/navbar.php'; ?>

<div class="card">

<?php if (!$showResult): ?>

<h1>Mind Scanner</h1>
<div class="instruction">
      Pada bagian di bawah ini, kamu akan menemukan beberapa pernyataan yang berkaitan dengan
            cara kamu menilai dan merespons suatu situasi. setiap pernyataan punya dua sudut
            pandang, yaitu Rasional dan Irasional.
            <br><br>
            yuk mari kita sama sama membaca setiap pernyataan. habis itu, berikan tanda centang (✓) pada
            checkbox yang paling sesuai dengan cara berpikir atau perasaan yang paling sering kamu
            alami. nggak ada jawaban benar atau salah. isi saja secara jujur dan spontan agar hasilnya
           dapat menggambarkan kondisi kamu lebih akurat.
            <br>
            Pilih minimal 5 pernyataan yang paling menggambarkan dirimu.
</div>

<form method="POST" onsubmit="return validateCheckbox();">
<div class="checkbox-list">
<?php
$statements = [
1=>"Saya pernah mempermalukan teman di depan orang lain dengan kata-kata.",
2=>"Saya tetap berbicara sopan meskipun sedang marah kepada teman.",
3=>"Saya pernah menyindir teman hingga membuatnya malu.",
4=>"Saya pernah tidak menanggapi teman karena sedang kesal.",
5=>"Saya menggunakan kata-kata kasar saat marah kepada teman.",
6=>"Saya menggunakan humor untuk mengejek seseorang.",
7=>"Saya menegur teman dengan cara yang lembut.",
8=>"Saya memilih diam saat teman mengajak berbicara.",
9=>"Saya pernah menertawakan kelemahan teman.",
10=>"Saya pernah mengancam teman agar menuruti keinginan saya.",
11=>"Saya berhati-hati memilih kata agar tidak menyakiti perasaan orang lain.",
12=>"Saya merasa lebih baik tidak berbicara dengan teman yang tidak saya sukai.",
13=>"Saya merasa puas jika teman merasa malu karena ucapan saya.",
14=>"Saya berbicara dengan nada tinggi agar teman takut kepada saya.",
15=>"Saya pernah menyinggung perasaan orang lain.",
16=>"Saya tetap menghargai teman walaupun sedang tidak menyukainya.",
17=>"Saya mengejek kesalahan kecil yang dilakukan teman.",
18=>"Saya memaksa orang lain dengan ucapan agar menuruti keinginan saya.",
19=>"Saya merasa senang jika sindiran saya membuat orang lain diam.",
20=>"Saya memilih diam agar teman merasa bersalah.",
21=>"Saya menegur teman dengan kata-kata sopan saat ia melakukan kesalahan.",
22=>"Saya merasa tidak dihargai oleh teman.",
23=>"Saya pernah berbicara sarkas atau kasar saat marah.",
24=>"Saya tidak menegur teman yang berbuat salah karena tidak ingin terlibat.",
25=>"Saya tidak suka mengejek teman walaupun ia melakukan kesalahan.",
26=>"Saya pernah menakut-nakuti teman dengan kata-kata kasar.",
27=>"Saya berusaha menolak berbicara dengan nada sarkas atau kasar.",
28=>"Saya pernah menyinggung perasaan teman dengan ucapan saya.",
29=>"Saya menghormati teman tanpa menggunakan kata-kata kasar.",
30=>"Saya tetap berbicara dengan teman dalam situasi apa pun."
];

foreach ($statements as $i=>$text): ?>
<label class="checkbox-item">
    <input type="checkbox" name="mind[]" value="<?= $i ?>">
    <?= $text ?>
</label>
<?php endforeach; ?>
</div>

<button type="submit">Lanjut</button>
</form>

<?php else: ?>

<div class="result">
    <h1>Hasil Mind Scanner</h1>
    <div class="score">Rasional: <strong><?= $rasionalScore ?></strong></div>
    <div class="score">Irasional: <strong><?= $irasionalScore ?></strong></div>
    <div class="kategori"><?= $kategori ?></div>
    <div class="penjelasan"><?= $penjelasan ?></div>

    <br>

    <form action="assett/narasi/materi.php">
        <button type="submit">Gas Nonton?</button>
    </form>
</div>

<?php endif; ?>

</div>
</body>
</html>
