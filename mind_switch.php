<?php
session_start();

/* STEP CONTROL */
$step = isset($_POST['step']) ? $_POST['step'] : 1;

/* SIMPAN PILIHAN STEP 1 */
if ($step == 2 && isset($_POST['verbal_type'])) {
    $_SESSION['verbal_type'] = $_POST['verbal_type'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Mind Switch</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background:url('assett/img/foto6.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    color: #fff;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.container {
    position: relative;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px); /* Safari */
    padding: 30px;
    border-radius: 16px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}
p {
    text-align: center;
    margin-bottom: 25px;
}
.option, .question {
    background: rgba(255,255,255,0.15);
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 12px;
}
input[type="checkbox"], input[type="radio"] {
    transform: scale(1.3);
}
button {
    margin-top: 25px;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 30px;
    font-size: 1em;
    font-weight: bold;
    cursor: pointer;
    background: #fff;
    color: #2a5298;
    transition: 0.3s;
}
button:disabled {
    background: #aaa;
    cursor: not-allowed;
}
button:hover:not(:disabled) {
    transform: scale(1.03);
}
.choices {
    display: flex;
    gap: 20px;
    margin-top: 8px;
}
</style>

<script>
function limitCheckbox() {
    const boxes = document.querySelectorAll('input[type="checkbox"]');
    const checked = Array.from(boxes).filter(b => b.checked);
    boxes.forEach(b => b.disabled = checked.length >= 1 && !b.checked);
    document.getElementById('btnNext').disabled = checked.length !== 1;
}

// =======================
// Step 2: Pertanyaan dinamis
// =======================
let currentQuestion = 0;
function showQuestion(index) {
    const allQuestions = document.querySelectorAll('.question');
    allQuestions.forEach((q,i)=>q.style.display = i===index?'block':'none');
}

function answerQuestion(radio) {
    // Redirect ke acp.php jika jawaban Tidak
    if(radio.value === 'Tidak'){
        window.location.href = 'acp.php';
        return;
    }

    // Tampilkan pertanyaan berikutnya
    const allQuestions = document.querySelectorAll('.question');
    currentQuestion++;
    if(currentQuestion < allQuestions.length){
        showQuestion(currentQuestion);
    } else {
        // Tampilkan tombol submit jika semua pertanyaan sudah dijawab Ya
        document.getElementById('btnSubmit').style.display = 'block';
    }
}
</script>
</head>
<body>

<div class="container">

<?php if ($step == 1): ?>
<!-- STEP 1 -->
<h1>Kekerasan Verbal</h1>

<form method="post" style="color:black;">
<input type="hidden" name="step" value="2">

<div class="option">
    <input type="checkbox" name="verbal_type" value="SARA" onclick="limitCheckbox()">
    Mengejek teman dengan unsur SARA (Suku, Agama, & Ras)
</div>

<div class="option">
    <input type="checkbox" name="verbal_type" value="Mengancam" onclick="limitCheckbox()">
    Mengancam orang lain
</div>

<div class="option">
    <input type="checkbox" name="verbal_type" value="Sarkas" onclick="limitCheckbox()">
    Sarkas / menyindir
</div>

<div class="option">
    <input type="checkbox" name="verbal_type" value="Mengabaikan" onclick="limitCheckbox()">
    Mengabaikan berbicara dengan orang lain
</div>

<button id="btnNext" disabled>Lanjut</button>
</form>

<?php else: ?>
<!-- STEP 2 -->
<h1 style="color: black">Mind Switch</h1>
<p style="color: black">santai aja jawab dengan pelan namun jujur ya guys!</p>

<form method="post" action="acp.php">

<?php
// Daftar pertanyaan per tipe
$questionsList = [
    "SARA" => [
        "Melakukan Pengejekan yang merupakan budaya / kabirisaan saya sehari.",
        "Saya melakukan pengejekan terlebih dahulu sebelum orang lain melakukan nya ke saya.",
        "Saya menganggap orang lain tidak menyukai sikap saya",
        "Orang yang lebih kuat dapat melakukan apapun sesuka hatinya.",
        "Orang lain wajar untuk diejek",
        "Jika saya tidak melakukan pengejekan, orang lain tidak akan mendengarkan saya.",
        "Saya marah Jadi wajar melakukan Pengejekan"
    ],
    "Mengancam" => [
        "Melakukan Pengancaman verbal yang merupakan budaya / kebiasaan saya sehari-hari di rumah.",
        "Saya melakukan pengancaman terlebih dahulu sebelum orang lain melakukan nya ke saya.",
        "Saya menganggap orang lain tidak menyukai sikap saya",
        "Orang yang lebih kuat dapat melakukan apapun sesuka hatinya.",
        "Orang lain wajar untuk di intimidasi",
        "Jika Saya tidak melakukan pengancaman, orang lain tidak akan mendengarkan saya",
        "Saya marah Jadi wajar melakukan Pengancaman"
    ],
    "Sarkas" => [
        "Melakukan Sarkas yang merupakan budaya / kebiasaan saya sehari-hari di rumah.",
        "Saya melakukan Sarkas terlebih dahulu sebelum orang lain melakukan nya ke saya.",
        "Saya menganggap orang lain tidak menyukai sikap saya",
        "Orang yang lebih kuat dapat melakukan apapun sesuka hatinya.",
        "Orang lain wajar untuk disarkas",
        "Jika Saya tidak melakukan sarkas, orang lain tidak akan mendengarkan saya",
        "Saya marah Jadi wajar melakukan Sarkas."
    ],
    "Mengabaikan" => [
        "Melakukan Pengabaian yang merupakan budaya / kebiasaan saya sehari-hari di rumah.",
        "Saya melakukan Pengabaian terlebih dahulu sebelum orang lain melakukan nya ke saya.",
        "Saya menganggap orang lain tidak menyukai sikap saya",
        "Orang yang lebih kuat dapat melakukan apapun sesuka hatinya.",
        "Orang lain wajar untuk diabaikan",
        "Jika Saya tidak melakukan pengabaian, orang lain tidak akan mendengarkan saya",
        "Saya marah Jadi wajar melakukan pengabaian"
    ]
];

$verbalType = $_SESSION['verbal_type'] ?? '';
$questions = $questionsList[$verbalType] ?? [];

if(empty($questions)){
    echo "<p>Tidak ada pertanyaan. Silakan kembali ke langkah sebelumnya.</p>";
    echo '<a href="mind_switch.php"><button>Kembali</button></a>';
    exit;
}

foreach($questions as $i => $q):
?>
<div class="question" style="display:none;">
    <strong style="color:black;"><?= $q ?></strong>
    <div class="choices"style="color:black;">
        <label><input type="radio" name="q<?= $i ?>" value="Ya" required onclick="answerQuestion(this)"> Ya</label>
        <label><input type="radio" name="q<?= $i ?>" value="Tidak" required onclick="answerQuestion(this)"> Tidak</label>
    </div>
</div>
<?php endforeach; ?>

<button type="submit" id="btnSubmit" style="display:none;">Selesai</button>
</form>

<script>
// Tampilkan pertanyaan pertama saat load
showQuestion(0);
</script>

<?php endif; ?>

</div>
</body>
</html>
