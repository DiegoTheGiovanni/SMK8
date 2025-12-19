<?php
session_start();
include 'koneksi.php';

/* ====== PROTEKSI LOGIN ====== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];
$today   = date('Y-m-d');

/* ====== CEK TANGGAL SURVEY TERAKHIR ====== */
$lastSurveyDate = null;
$stmt = $conn->prepare(
    "SELECT survey_date
     FROM survey_answers
     WHERE user_id=?
     ORDER BY survey_date DESC
     LIMIT 1"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($lastSurveyDate);
$stmt->fetch();
$stmt->close();

/* ====== RESET JIKA HARI BERGANTI ====== */
if ($lastSurveyDate !== null && $lastSurveyDate !== $today) {
    $session = 1;
}

/* ====== SESSION ====== */
$session = isset($_GET['session']) ? (int)$_GET['session'] : 1;
$session = max(1, min(6, $session));

/* ====== AMBIL JAWABAN ====== */
$existingAnswers = [];
$stmt = $conn->prepare(
    "SELECT question_number, rating
     FROM survey_answers
     WHERE user_id=? AND session_number=? AND survey_date=?"
);
$stmt->bind_param("iis", $user_id, $session, $today);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $existingAnswers[$row['question_number']] = $row['rating'];
}
$stmt->close();

/* ====== SIMPAN DATA ====== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($_POST['answers'] as $i => $rating) {

        $rating = (int)$rating;
        if ($rating < 1 || $rating > 4) {
            die("Rating tidak valid");
        }

        $question_number = $i + 1;

        if (isset($existingAnswers[$question_number])) {
            $stmt = $conn->prepare(
                "UPDATE survey_answers
                 SET rating=?
                 WHERE user_id=? AND session_number=? 
                 AND question_number=? AND survey_date=?"
            );
            $stmt->bind_param("iiiis", $rating, $user_id, $session, $question_number, $today);
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO survey_answers
                (user_id, session_number, question_number, rating, survey_date)
                VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("iiiis", $user_id, $session, $question_number, $rating, $today);
        }
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . ($session >= 6 ? "hasil_skor_harian.php" : "survey.php?session=" . ($session + 1)));
    exit;
}

/* ====== 30 PERTANYAAN ====== */
$questions = [
"Saya pernah mempermalukan teman di depan orang lain dengan kata-kata.",
"Saya tetap berbicara sopan meskipun sedang marah kepada teman.",
"Saya pernah menyindir teman hingga membuatnya malu.",
"Saya pernah tidak menanggapi teman karena sedang kesal.",
"Saya menggunakan kata-kata kasar saat marah kepada teman.",

"Saya menggunakan humor untuk mengejek seseorang.",
"Saya menegur teman dengan cara yang lembut.",
"Saya memilih diam saat teman mengajak berbicara.",
"Saya pernah menertawakan kelemahan teman.",
"Saya pernah mengancam teman agar menuruti keinginan saya.",

"Saya berhati-hati memilih kata agar tidak menyakiti perasaan orang lain.",
"Saya merasa lebih baik tidak berbicara dengan teman yang tidak saya sukai.",
"Saya merasa puas jika teman merasa malu karena ucapan saya.",
"Saya berbicara dengan nada tinggi agar teman takut kepada saya.",
"Saya pernah menyinggung perasaan orang lain.",

"Saya tetap menghargai teman walaupun sedang tidak menyukainya.",
"Saya mengejek kesalahan kecil yang dilakukan teman.",
"Saya memaksa orang lain dengan ucapan agar menuruti keinginan saya.",
"Saya merasa senang jika sindiran saya membuat orang lain diam.",
"Saya memilih diam agar teman merasa bersalah.",

"Saya menegur teman dengan kata-kata sopan saat ia melakukan kesalahan.",
"Saya merasa tidak dihargai oleh teman.",
"Saya pernah berbicara sarkas atau kasar saat marah.",
"Saya tidak menegur teman yang berbuat salah karena tidak ingin terlibat.",
"Saya tidak suka mengejek teman walaupun ia melakukan kesalahan.",

"Saya pernah menakut-nakuti teman dengan kata-kata kasar.",
"Saya berusaha menolak berbicara dengan nada sarkas atau kasar.",
"Saya pernah menyinggung perasaan teman dengan ucapan saya.",
"Saya menghormati teman tanpa menggunakan kata-kata kasar.",
"Saya tetap berbicara dengan teman dalam situasi apa pun."
];

$start    = ($session - 1) * 5;
$end      = $start + 5;
$progress = round(($session / 6) * 100);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Survey</title>
<link rel="stylesheet" href="assett/navbar.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI,sans-serif;}
body{
    min-height:100vh;
    background:url('assett/img/foto6.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    display:block;
    justify-content:center;
    align-items:center;
}
.wrapper{max-width:750px;width:100%; margin: auto;}
.progress{height:15px;background:#ddd;border-radius:10px;margin-bottom:20px;margin-top:20px;}
.progress-bar{
    height:100%;
    width:<?= $progress ?>%;
    background: #2196f3;
    color: #ffffff;
    text-align:center;
    font-size:12px;
    font-weight:600;
}
.card{
    background:#fff;padding:35px;border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
}
.question{margin-bottom:30px;}

.likert{
    display:flex;
    justify-content:space-between;
    margin-top:12px;
}
.likert-item{
    width:60px;
    height:60px;
    border-radius:50%;
    border:2px solid #bbb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
    background:#f9f9f9;
}
.likert-item:hover{
    border-color:#2196f3;
    color:#2196f3;
}
.likert-item.active{
    background:#2196f3;
    color:#fff;
    border-color:#2196f3;
}

button{
    padding:14px 40px;border:none;border-radius:30px;
    background:#2196f3;color:#fff;font-size:16px;
    cursor:pointer;
}
</style>
</head>
<body>
    <?php 
    require 'assett/navbar.php';
    ?>
<div class="wrapper">

<div class="progress">
    <div class="progress-bar"><?= $progress ?>%</div>
</div>

<div class="card">
<form method="POST" onsubmit="return validateForm()">
<h3>Sesi <?= $session ?> dari 6</h3><br>

<!-- Penjelasan apa itu SS, S, TS, STS -->
<p>Angket ini berisi 30 item pernyataan tentang kondisi yang sering kalian alami. Bacalah dengan cermat setiap pernyataan tersebut. 
    Kemudian, berikanlah jawaban dengan cara memberi tanda cek () pada salah satu pilihan jawaban yang paling sesuai dengan tingkat persetujuan kamu</p><br>

<?php
$labels = ["SS","S","TS","STS"];
for ($i=$start; $i<$end; $i++):
$qNum=$i+1;
?>
<div class="question">
<p><?= $questions[$i] ?></p>

<div class="likert">
<?php for ($v=1; $v<=4; $v++): ?>
<div class="likert-item <?= (isset($existingAnswers[$qNum]) && $existingAnswers[$qNum]==$v) ? 'active' : '' ?>"
     onclick="selectLikert(<?= $i ?>,<?= $v ?>,this)">
    <?= $labels[$v-1] ?>
</div>
<?php endfor; ?>
</div>

<input type="hidden" name="answers[<?= $i ?>]" id="q<?= $i ?>"
value="<?= $existingAnswers[$qNum] ?? '' ?>">
</div>
<?php endfor; ?>

<button type="submit">Next</button>
</form>
</div>
</div>

<script>
function selectLikert(q,val,el){
    document.getElementById('q'+q).value = val;
    let items = el.parentElement.children;
    for(let i=0;i<items.length;i++){
        items[i].classList.remove('active');
    }
    el.classList.add('active');
}
function validateForm(){
    let inputs=document.querySelectorAll('input[name^="answers"]');
    for(let i of inputs){
        if(i.value===""){
            alert("Semua pertanyaan wajib diisi");
            return false;
        }
    }
    return true;
}
</script>
</body>
</html>
