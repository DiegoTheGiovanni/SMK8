<?php
// index.php landing page sederhana
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mind Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --blue-light: #eaf4ff;
            --blue-main: #4da3ff;
            --blue-dark: #1e6fd9;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            background: linear-gradient(180deg, var(--blue-light), #ffffff);
            color: var(--text-dark);
            min-height: 100vh;
        } 

        /* ===== HERO ===== */
        .hero {
            padding: 80px 10% 60px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-text h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            color: var(--blue-dark);
            margin-bottom: 16px;
        }

        .hero-text p {
            font-size: 1rem;
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .hero-text button {
            background: var(--blue-main);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .hero-text button:hover {
            background: var(--blue-dark);
        }

        .hero-box {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .hero-box h3 {
            margin-bottom: 12px;
            color: var(--blue-dark);
        }

        .hero-box p {
            color: var(--text-light);
            line-height: 1.6;
        }

        /* ===== SECTION ===== */
        section {
            padding: 60px 10%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 2rem;
            color: var(--blue-dark);
            margin-bottom: 10px;
        }

        .section-title p {
            color: var(--text-light);
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-6px);
        }

        .card h4 {
            margin-bottom: 10px;
            color: var(--blue-dark);
        }

        .card p {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 30px 10%;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .hero {
                grid-template-columns: 1fr;
                padding-top: 50px;
            }

            header {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
    <link rel="stylesheet" href="assett/navbar.css">
</head>
<body>

<header>
    <?php include 'assett/navbar.php'; ?>
</header>

<div class="hero">
    <div class="hero-text">
        <h2>Lorem Ipsum Dolor Sit Amet</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
            Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
        <a href="login.php"><button>Get Started</button></a>
    </div>

    <div class="hero-box">
        <h3>Lorem Ipsum</h3>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
        </p>
    </div>
</div>

<section>
    <div class="section-title">
        <h2>Lorem Ipsum Section</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
    </div>

    <div class="cards">
        <div class="card">
            <h4>Lorem Ipsum</h4>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt.
            </p>
        </div>

        <div class="card">
            <h4>Lorem Ipsum</h4>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt.
            </p>
        </div>

        <div class="card">
            <h4>Lorem Ipsum</h4>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed do eiusmod tempor incididunt.
            </p>
        </div>
    </div>
</section>

<?php include 'assett/footer.html'; ?>

</body>
</html>
