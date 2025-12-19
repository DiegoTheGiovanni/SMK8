<?php
// materi_dampak_bullying.php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Materi Dampak Bullying</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background:url('../img/foto6.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        }

        .title {
            font-size: 2.3rem;
            font-weight: 700;
            color: #0d47a1;
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            font-size: 1.05rem;
            color: #555;
            margin-bottom: 35px;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 720px;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            border-radius: 16px;
            overflow: hidden;
            margin: 0 auto 35px;
        }

        #player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .content {
            font-size: 1.05rem;
            line-height: 1.9;
            text-align: justify;
            margin-bottom: 35px;
        }

        .impact-box {
            background: #e3f2fd;
            border-left: 6px solid #1976d2;
            padding: 25px 30px;
            border-radius: 14px;
            margin-bottom: 35px;
        }

        .impact-box h3 {
            margin-top: 0;
            color: #0d47a1;
        }

        .impact-box ul {
            padding-left: 20px;
        }

        .impact-box li {
            margin-bottom: 10px;
        }

        .cta {
            text-align: center;
        }

        .cta a {
            display: inline-block;
            padding: 14px 36px;
            background: #1976d2;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            border-radius: 30px;
            transition: .3s;
            pointer-events: auto; /* langsung bisa diklik */
            opacity: 1; /* tombol terlihat aktif */
        }

        .cta a:hover {
            background: #0d47a1;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            .container {
                padding: 35px 25px;
                margin: 30px 15px;
            }

            .title {
                font-size: 1.9rem;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="title">Dampak Bullying terhadap Kesehatan Mental</div>
    <div class="subtitle">
        Materi edukasi untuk meningkatkan kesadaran, empati, dan pemahaman diri
    </div>

    <!-- VIDEO -->
   <div class="video-container">
<video src="../video/balon.mp4" controls autoplay 
    style="width: 100%;      
    max-width: 1200px; 
    height: auto;     
    border-radius: 12px;"
    alt="Browser kamu tidak mendukung video.">
</video>
    </div>

    <!-- MATERI -->
    <div class="content">
        Bullying dapat berdampak serius pada psikologis korban. Pemahaman mengenai dampak ini
        membantu kita membangun empati dan menciptakan lingkungan yang aman dan suportif.
    </div>

    <div class="impact-box">
        <h3>Dampak Psikologis</h3>
        <ul>
            <li>Menurunnya rasa percaya diri dan harga diri</li>
            <li>Kecemasan berlebihan dan rasa takut bersosialisasi</li>
            <li>Stres kronis dan gangguan tidur</li>
            <li>Depresi dan perasaan tidak berharga</li>
            <li>Menarik diri dari lingkungan sosial</li>
        </ul>
    </div>

    <!-- CTA -->
    <div class="cta">
        <a href="prolog_mind_switch.php" id="btn-lanjut">Seru kan? Ayo Lanjutkan!</a>
    </div>

</div>

</body>
</html>
