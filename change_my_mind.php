<?php
session_start();

/* ===== PROTEKSI LOGIN ===== */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

/* ===== CEK SURVEY ===== */
if (!isset($_SESSION['survey_done'])) {
    header("Location: survey.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Change Your Mind</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
}

body{
    min-height:100vh;
    background:url('assett/img/foto6.jpg') no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* Wrapper utama */
.wrapper{
    width:100%;
    max-width:700px;
    display:flex;
    flex-direction:column;
    align-items:center;
}

/* Title */
.title{
    font-size:50px;
    font-weight:700;
    color:#0d2a44;
    margin-bottom:80px;
    text-align:center;
}

/* Card */
.card{
    width:100%;
    background:rgba(255,255,255,0.9);
    backdrop-filter:blur(12px);
    padding:45px 40px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.25);
    text-align:center;
    animation:fadeUp 0.9s ease;
}

/* Animasi */
@keyframes fadeUp{
    from{opacity:0;transform:translateY(40px);}
    to{opacity:1;transform:translateY(0);}
}

.card p{
    font-size:18px;
    line-height:1.6;
    color:#0d2a44;
    margin-bottom:35px;
}

/* Button-style link */
.btn-next{
    display:inline-block;
    padding:15px 42px;
    font-size:16px;
    border-radius:30px;
    background:linear-gradient(135deg,#2196f3,#64b5f6);
    color:#fff;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.btn-next:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 24px rgba(0,0,0,0.3);
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- TITLE -->
    <h1 class="title">Change Your Mind</h1>

    <div class="card">
        <p>
           nah selanjutnya guys ada survey nih untuk mendapatkan hasil yang maximal,
           marilah jawab survey berikut secara spontan dan jujur ya!
        </p>

        <!-- LINK YANG PASTI BEKERJA -->
        <a href="mind_scanner.php" class="btn-next">
            Let's Go!
        </a>
    </div>

</div>

</body>
</html>
