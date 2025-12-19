<?php
// mind_switch_intro.php
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
            font-family: 'Segoe UI', sans-serif;
            background:url('../img/foto6.jpg') no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            color: #333;
            display: flex;
            justify-content: center;
        }

        .container {
            max-width: 800px;
            margin: 80px 20px;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            text-align: center;
        }

        .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d47a1;
            margin-bottom: 20px;
        }

        .prolog {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .cta {
            display: inline-block;
            padding: 14px 36px;
            background: #1976d2;
            border-radius: 30px;
            transition: .3s;
            margin: 50px 15px;
        }

        .cta a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            }

            .title {
                font-size: 2rem;
            }
    </style>
</head>
<body>

<div class="container">
    <div class="title">Welcome di Mind Switch!</div>

    <div class="prolog">
        Tau gak Mind Switch itu apa? jadi begini sobat, di sini kamu akan di ajak untuk mengeksplorasi pola pikir,
        refleksi diri, dan juga memahami proses mental kamu. Udah ready untuk menjawab?

    <div class="cta">
        <a href="../../mind_switch.php">Ready!!</a>
    </div>
</div>

</body>
</html>
