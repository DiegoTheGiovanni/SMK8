<?php
// narasi_mind_switch.php
session_start();
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
            overflow: hidden;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease-out;
        }
        p {
            font-size: 1.2em;
            max-width: 700px;
            line-height: 1.6;
            margin-bottom: 30px;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.2);
            animation: fadeInUp 1s ease-out;
        }
        .btn {
            background-color: #fff;
            color: #4A90E2;
            font-weight: bold;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
            animation: pulse 1.5s infinite;
        }
        .btn:hover {
            background-color: #50E3C2;
            color: #fff;
            transform: scale(1.05);
        }
        @keyframes fadeInDown {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeInUp {
            from {opacity: 0; transform: translateY(50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        @keyframes pulse {
            0%, 100% {transform: scale(1);}
            50% {transform: scale(1.1);}
        }
    </style>
</head>
<body>
    <h1>Mind Switch</h1>
    <p>
        Selamat datang di <strong>Mind Switch</strong>, arena di mana pikiranmu menari dan ide-ide baru menantang cara berpikirmu!  
        Di sini, setiap jawabanmu bukan sekadar pilihan, tapi sebuah kunci untuk memahami pola pikirmu sendiri.  
        Jangan hanya lewatkan ini—jawablah dengan jujur dan rasakan bagaimana pikiranmu bisa terbuka ke perspektif baru.
    </p>
    <p>
        Siap men-switch mindset-mu dan menemukan sisi baru dari dirimu? Klik tombol di bawah untuk memulai petualangan seru ini!
    </p>
    <a class="btn" href="mind_switch.php">Mulai Mind Switch</a>
</body>
</html>
