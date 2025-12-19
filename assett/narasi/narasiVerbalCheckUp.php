<?php
session_start();

/* ===== PROTEKSI LOGIN ===== */
// if (!isset($_SESSION['id'])) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Verbal Check-Up | Mind Control Room</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background:url('../img/foto6.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
        color: #0d2a44;
    }

    .container {
        max-width: 900px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .card {
        background: #ffffff;
        border-radius: 18px;
        padding: 45px 50px;
        box-shadow: 0 18px 40px rgba(13, 42, 68, 0.12);
    }

    h1 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 32px;
        color: #1a73e8;
    }

    .subtitle {
        font-size: 16px;
        color: #4a6fa5;
        margin-bottom: 35px;
        line-height: 1.7;
    }

    .content p {
        font-size: 16px;
        line-height: 1.9;
        margin-bottom: 22px;
        color: #2f3e55;
    }

    .actions {
        margin-top: 40px;
        text-align: center ;
    }

    .btn-next {
        display: inline-block;
        padding: 14px 34px;
        border-radius: 30px;
        background: linear-gradient(to right, #2196f3, #1a73e8);
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .btn-next:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(33, 150, 243, 0.35);
    }

    @media (max-width: 600px) {
        .card {
            padding: 35px 25px;
        }

        h1 {
            font-size: 26px;
        }
    }
</style>
</head>

<body>

<div class="container">
    <div class="card">
        <h1>Verbal Check-Up</h1>
        <div class="subtitle">
            Ruang refleksi awal untuk memahami kondisi pikiran melalui kata,
            makna, dan kesadaran diri.
        </div>

        <div class="content">
            <p>
                Siap-siap! Ini bukan cuman angket biasa loh.
                Di sini, kata-katamu adalah kunci untuk mengungkap sisi dirimu yang tersembunyi.
                Setiap jawaban akan menyingkap pola pikir,kebiasaan,dan gaya komunikasimu.

                Jangan takut salah jawab. Jangan ragu.
                Yang penting jujur, spontan, dan berani!
            </p>

            <p>
            Bacalah setiap pernyataan dengan cepat dan pilih jawaban yang paling menggambarkanmu. 
            Ingat, ini semua tentang kamu yang sebenarnya. Klik, centang, dan teruskan… 
            ayo, jangan sampai ketinggalan!
            </p>

            <p>
                yuk isi verbal checkup langkah penting untuk memastikan kesehatan mental dan emosionalmu. 
                dengan melakukan verbal check-up, 
                kamu bisa mengidentifikasi stres dan kecemasan,meningkatkan kesadaran diri,
                meningkatkan kemampuan komunikasi,membangun hubungan yang lebih baik
            </p>
        </div>

        <div class="actions">
            <a href="../../survey.php" class="btn-next">Yuk, mulai verbal check-up sekarang!</a>
        </div>
    </div>
</div>

</body>
</html>
