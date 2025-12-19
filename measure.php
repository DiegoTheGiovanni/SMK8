<?php
session_start();
include 'koneksi.php';

// Simulasi user_id dari session login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // sementara hardcode
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level = $_POST['level'];
    $mood = trim($_POST['mood']);
    $date = $_POST['date'];
    $user_id = $_SESSION['user_id'];

    if (empty($mood) || empty($date)) {
        $error = "Semua field wajib diisi!";
    } else {
        $stmt = $conn->prepare("INSERT INTO responses (user_id, level, mood, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $level, $mood, $date);
        $stmt->execute();
        $stmt->close();

        // Redirect ke halaman berikutnya namun sebelum itu diarahkan ke narasi survey agar user mengerti apa yang ia kerjakan.
        // header("Location: survey.php?session=1");
        // exit;
        header("Location: narasi_survey.html");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verbal measure</title>
    <link rel="stylesheet" href="assett/navbar.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: #e0f7fa;
    display: block;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    padding: 0;
}
.container {
    background: white;
    padding: 55px 65px;
    margin: auto;
    margin-top: 3%;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 400px;
    text-align: center;
}
h2 { color: #00796b; margin-bottom: 20px; }
.slider-container { margin: 20px 0; }
input[type=range] { width: 100%; }
.value-display { font-size: 18px; margin-top: 10px; color: #00796b; }
label { display: block; margin: 15px 0 5px 0; font-weight: bold; text-align: left; }
input[type=text], input[type=date] {
    width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;
}
button {
    margin-top: 20px; padding: 12px 25px; background: #00796b; color: white;
    border: none; border-radius: 10px; cursor: pointer; font-size: 16px;
}
button:hover { background: #004d40; }
.error { color: red; font-size: 14px; margin-top: 10px; }
</style>
</head>
<body>
    <?php
  // Menyisipkan navbar dari file eksternal
  require 'assett/navbar.php';
  ?>



<div class="container">
    <h2>Verbal Check-Up</h2>
    <form method="POST">
        <div class="slider-container">
            <input type="range" id="level" name="level" min="0" max="100" value="50">
            <div class="value-display">Nilai: <span id="level-value">50%</span></div>
        </div>

        <label for="mood">Nama</label>
        <input type="text" id="mood" name="mood" placeholder="Tulis di sini" value="<?= $_SESSION['nama'] ?>">

        <label for="date">Tanggal:</label>
        <input type="date" id="date" name="date">

        <?php if($error) echo "<div class='error'>$error</div>"; ?>

        <button type="submit">Next</button>
    </form>
</div>

<script>
const slider = document.getElementById('level');
const levelValue = document.getElementById('level-value');
slider.addEventListener('input', () => {
    levelValue.textContent = slider.value + '%';
});
</script>
</body>
</html>
