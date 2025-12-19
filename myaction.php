<?php
session_start();
$autoPrint = isset($_GET['pdf']);


/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>My Action</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#74ebd5,#ACB6E5);
    display:flex;
    justify-content:center;
    align-items:center;
}
.card{
    background:#fff;
    padding:50px 60px;
    border-radius:24px;
    text-align:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
    width:100%;
    max-width:420px;
}
h2{
    margin-bottom:30px;
    color:#333;
}
.actions{
    display:flex;
    flex-direction:column;
    gap:18px;
}
.actions a{
    display:block;
    padding:15px;
    border-radius:30px;
    font-size:16px;
    font-weight:600;
    text-decoration:none;
    color:#fff;
    transition:transform .2s, box-shadow .2s;
}
.actions a:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 18px rgba(0,0,0,.25);
}
.jurnal{ background:#4caf50; }
.self{ background:#2196f3; }
.hasil{ background:#ff9800; }
</style>
</head>

<body>

<div class="card">
    <h2>Pilih Aksi</h2>

    <div class="actions">
        <a href="journal.php" class="jurnal">📘 Jurnal</a>
        <a href="self_control.php" class="self">🧠 Self</a>
        <a href="laporan_pdf.php" target="_blank" class="hasil">📄 Download PDF</a>
    </div>
</div>

<?php if ($autoPrint): ?>
<script>
    window.onload = function(){
        window.print();
    }
</script>
<?php endif; ?>


</body>
</html>
