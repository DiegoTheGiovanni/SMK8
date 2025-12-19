<?php
session_start();
include 'koneksi.php';

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

/* ===== SESSION ===== */
$session = isset($_GET['session']) ? (int)$_GET['session'] : 1;
if ($session < 1 || $session > 2) {
    $session = 1;
}

/* ===== CEK SESSION SUDAH DIISI ===== */
$exists = 0;

$cek = $conn->prepare(
    "SELECT COUNT(*) FROM checkbox_answers 
     WHERE user_id=? AND session_number=?"
);

if ($cek) {
    $cek->bind_param("ii", $user_id, $session);
    $cek->execute();
    $cek->bind_result($exists);
    $cek->fetch();
    $cek->close();
}

// Pertanyaan untuk setiap sesi
$questions = [
    // sesi 1 (1–10)
    "Pertanyaan 1",
    "Pertanyaan 2",
    "Pertanyaan 3",
    "Pertanyaan 4",
    "Pertanyaan 5",
    "Pertanyaan 6",
    "Pertanyaan 7",
    "Pertanyaan 8",
    "Pertanyaan 9",
    "Pertanyaan 10",

    // sesi 2 (11–20)
    "Pertanyaan 11",
    "Pertanyaan 12",
    "Pertanyaan 13",
    "Pertanyaan 14",
    "Pertanyaan 15",
    "Pertanyaan 16",
    "Pertanyaan 17",
    "Pertanyaan 18",
    "Pertanyaan 19",
    "Pertanyaan 20",
];

$start = ($session - 1) * 10;
$end   = $start + 10;
$progress = ($session / 2) * 100;

/* ===== SIMPAN DATA JAWABAN ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($_POST['answers'] as $qIndex => $options) {

        if (!is_array($options) || count($options) === 0) {
            die("Semua pertanyaan wajib diisi");
        }

        if (count($options) > 3) {
            die("Maksimal 3 pilihan per pertanyaan");
        }

        if (in_array("other", $options)) {
            $custom = trim($_POST['custom'][$qIndex] ?? '');
            if ($custom === '') {
                die("Jawaban lainnya wajib diisi");
            }
            $options[array_search("other", $options)] = "Lainnya: " . $custom;
        }

        $json = json_encode($options);
        $questionText = $questions[$qIndex];

        $stmt = $conn->prepare(
            "INSERT INTO checkbox_answers 
            (user_id, session_number, question, selected_options)
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("iiss", $user_id, $session, $questionText, $json);
        $stmt->execute();
        $stmt->close();
    }

    if ($session < 2) {
    header("Location: checkbox_survey.php?session=" . ($session + 1));
    } else {
        header("Location: hasil_checkbox.php");
    }
    exit;
}


?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Survey</title>
<link rel="stylesheet" href="assett/navbar.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#74ebd5,#ACB6E5);
    display:block;
    justify-content:center;
    align-items:center;
}
.wrapper{max-width:700px;width:100%; margin: auto; margin-top: 10px;}
.progress{
    height:12px;
    background:#e0e0e0;
    border-radius:10px;
    overflow:hidden;
    margin-bottom:20px;
}
.progress-bar{
    height:100%;
    background:linear-gradient(135deg,#2196f3,#64b5f6);
    transition:0.4s;
}
.card{
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
}
.options label{
    display:block;
    margin:12px 0;
    font-size:1rem;
}
.options input[type=text]{
    width:100%;
    padding:8px;
    margin-top:6px;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    margin-top:25px;
    padding:14px 40px;
    border:none;
    border-radius:30px;
    background:#2196f3;
    color:#fff;
    font-size:16px;
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
    <div class="progress-bar" style="width: <?= $progress ?>%;"></div>
</div>
<div class="card">
<form method="POST" onsubmit="return validateForm()">
<h3>Sesi <?= $session ?> dari 2</h3><br>
<?php for ($i = $start; $i < $end; $i++): ?>
<p><strong><?= $questions[$i] ?></strong></p>

<div class="options">
<label><input type="checkbox" name="answers[<?= $i ?>][]" data-question="<?= $i ?>" value="Pekerjaan"> Pekerjaan</label>
<label><input type="checkbox" name="answers[<?= $i ?>][]" data-question="<?= $i ?>" value="Keluarga"> Keluarga</label>
<label><input type="checkbox" name="answers[<?= $i ?>][]" data-question="<?= $i ?>" value="Pendidikan"> Pendidikan</label>
<label><input type="checkbox" name="answers[<?= $i ?>][]" data-question="<?= $i ?>" value="Lingkungan Sosial"> Lingkungan Sosial</label>
<label>
    <input type="checkbox" 
       data-question="<?= $i ?>" 
       value="other"
       name="answers[<?= $i ?>][]">
       Lainnya
    <input type="text" name="custom[<?= $i ?>]">
</label>
</div>
<hr><br>
<?php endfor; ?>

<button type="submit">
    <?= ($session < 2) ? 'Next' : 'Kirim' ?>
</button>

</form>
</div>
</div>
<script>
document.querySelectorAll('input[type=checkbox]').forEach(cb => {
    cb.addEventListener('change', () => {

        const q = cb.dataset.question;

        const checked = document.querySelectorAll(
            'input[type=checkbox][data-question="'+q+'"]:checked'
        );

        if (checked.length > 3) {
            cb.checked = false;
            alert("Maksimal 3 pilihan per pertanyaan");
            return;
        }

        // handle "other"
        const other = document.querySelector(
            'input[type=checkbox][data-question="'+q+'"][value="other"]'
        );

        const text = document.querySelector(
            'input[name="custom['+q+']"]'
        );

        if (other && text) {
            text.disabled = !other.checked;
        }
    });
});

function validateForm(){
    let valid = true;

    document.querySelectorAll('.options').forEach(block => {
        const checked = block.querySelectorAll('input[type=checkbox]:checked');

        if (checked.length === 0) {
            valid = false;
        }
    });

    if (!valid) {
        alert("Semua pertanyaan wajib diisi minimal 1 pilihan");
        return false;
    }

    return true;
}
</script>

</body>
</html>
