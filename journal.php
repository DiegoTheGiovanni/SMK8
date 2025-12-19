<?php
session_start();
include 'koneksi.php';

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['save'])) {

    $user_id = $_SESSION['id'];
    $journal_date = date('Y-m-d');

    $mood        = trim($_POST['mood'] ?? '');
    $experience  = trim($_POST['experience'] ?? '');
    $feelings    = trim($_POST['feelings'] ?? '');
    $response    = trim($_POST['response'] ?? '');
    $affirmation = trim($_POST['affirmation'] ?? '');
    $learned     = trim($_POST['learned'] ?? '');

    if (
        empty($mood) || empty($experience) || empty($feelings) ||
        empty($response) || empty($affirmation) || empty($learned)
    ) {
        $error = "Semua kolom wajib diisi.";
    } else {

        $check = $conn->prepare(
            "SELECT id FROM journals WHERE user_id = ? AND journal_date = ?"
        );
        $check->bind_param("is", $user_id, $journal_date);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Kamu sudah mengisi jurnal hari ini.";
        } else {

            $stmt = $conn->prepare(
                "INSERT INTO journals
                (user_id, journal_date, mood, experience, feelings, response, affirmation, learned)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "isssssss",
                $user_id,
                $journal_date,
                $mood,
                $experience,
                $feelings,
                $response,
                $affirmation,
                $learned
            );

            if ($stmt->execute()) {
                echo "<script>
                    alert('Journal berhasil disimpan. Terima kasih sudah refleksi hari ini.');
                    window.location.href = 'myaction.php';
                </script>";
                exit;
            } else {
                $error = "Gagal menyimpan jurnal.";
            }

            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reflection Journal</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: #eaf4ff;
    padding: 30px;
}
.container {
    max-width: 700px;
    margin: auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
h1 {
    text-align: center;
    color: #2b6cb0;
}
h2 {
    color: #2c5282;
    margin-top: 20px;
}
textarea {
    width: 100%;
    height: 80px;
    margin-top: 8px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #cbd5e0;
}
.mood label,
.affirmation label {
    display: block;
    margin: 6px 0;
}
button,
.btn-back {
    margin-top: 20px;
    width: 30%;
    padding: 12px;
    background: #3182ce;
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
}
button:hover,
.btn-back:hover {
    background: #2b6cb0;
}
.btn-back {
    display: inline-block;
    text-decoration: none;
}
.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="container">
<h1>My Reflection Journal</h1>

<?php if (!empty($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">

<h2>1. Cek Perasaan Harian</h2>
<div class="mood">
    <label><input type="radio" name="mood" value="Senang"> 😊 Senang</label>
    <label><input type="radio" name="mood" value="Santai"> 🙂 Santai</label>
    <label><input type="radio" name="mood" value="Biasa"> 😐 Biasa</label>
    <label><input type="radio" name="mood" value="Cemas"> 😟 Cemas</label>
    <label><input type="radio" name="mood" value="Marah"> 😡 Marah</label>
</div>

<h2>2. Pengalaman Hari Ini</h2>
<textarea name="experience"></textarea>

<h2>3. Perasaanku</h2>
<textarea name="feelings"></textarea>

<h2>4. Respon Hari Ini</h2>
<textarea name="response"></textarea>

<h2>5. Afirmasi Positif</h2>
<div class="affirmation">
    <label><input type="radio" name="affirmation" value="Saya mampu mengendalikan diri"> Saya mampu mengendalikan diri</label>
    <label><input type="radio" name="affirmation" value="Perasaan ini valid"> Perasaan ini valid</label>
    <label><input type="radio" name="affirmation" value="Saya belajar menjadi lebih baik"> Saya belajar menjadi lebih baik</label>
    <label><input type="radio" name="affirmation" value="Saya memilih kata-kata baik"> Saya memilih kata-kata baik</label>
</div>

<h2>6. Pelajaran Hari Ini</h2>
<textarea name="learned"></textarea>

<button type="submit" name="save">Save Journal</button>
<a href="myaction.php" class="btn-back">Kembali</a>

</form>
</div>

</body>
</html>