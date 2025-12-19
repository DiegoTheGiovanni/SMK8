<?php
// narasi_change_your_mind.php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Change Your Mind</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background:url('../img/foto6.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            max-width: 900px;
            padding: 60px 40px;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
            text-align: center;
        }

        .title {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0d47a1;
            margin-bottom: 30px;
        }

        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            margin-bottom: 35px;
            border-radius: 14px;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .description {
            font-size: 1.05rem;
            line-height: 1.9;
            color: #444;
            margin-bottom: 40px;
            text-align: justify;
        }

        .btn-start {
            display: inline-block;
            padding: 14px 38px;
            background: #1976d2;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            transition: all .3s ease;
        }

        .btn-start:hover {
            background: #0d47a1;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .wrapper {
                padding: 40px 25px;
            }

            .title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>

<div class="wrapper">
    <div class="title">Change Your Mind</div>

    <!-- VIDEO YOUTUBE -->
    <div class="video-container">
<video src="../video/balon.mp4" controls style="
        width: 100%; 
        max-width: 1200px; 
        height: auto; 
        border-radius: 12px;">
    Browser kamu tidak mendukung video.
</video>
    </div>

    <!-- DESKRIPSI -->
    <div class="description">
        Tertarik sama Change Your Mind? Halaman ini dirancang sebagai ruang tanya jawab interaktif
        yang bertujuan membantu pengguna mengenali, merefleksikan, dan memahami kondisi diri
        secara lebih terstruktur. Setiap pertanyaan disusun secara bertahap dan relevan,
        sehingga pengguna dapat memberikan jawaban yang paling menggambarkan pengalaman,
        perasaan, atau pandangan mereka saat ini.
        <br><br>
        Lewat proses inilah, sistem akan mengumpulkan respon pengguna sebagai dasar
        untuk memberikan gambaran, insight, atau hasil yang bersifat informatif dan personal.
        Seluruh jawaban bersifat rahasia dan hanya digunakan untuk keperluan pengolahan data
        dalam sistem, tanpa disebarluaskan kepada pihak lain.
    </div>

    <a href="../../change_my_mind.php" class="btn-start">
        Yuk Sini!
    </a>
</div>

</body>
</html>
