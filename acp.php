<?php
// action_plan.php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Action Plan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f0f4ff);
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 40px 35px;
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
        }

        .title {
            font-size: 2rem;
            font-weight: 700;
            color: #0d47a1;
            text-align: center;
            margin-bottom: 25px;
        }

        .checkbox-group {
            margin-bottom: 25px;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 15px;
            margin-top: 4px;
            transform: scale(1.2);
        }

        .checkbox-item label {
            font-size: 1rem;
            line-height: 1.6;
        }

        .additional-plan {
            margin-top: 20px;
        }

        .additional-plan p {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .additional-plan textarea {
            width: 100%;
            min-height: 120px;
            padding: 12px;
            font-size: 1rem;
            border-radius: 12px;
            border: 1px solid #b3c6f0;
            resize: vertical;
            outline: none;
        }

        .additional-plan textarea:focus {
            border-color: #1976d2;
            box-shadow: 0 0 5px rgba(25, 118, 210, 0.4);
        }

        .btn-submit {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 32px;
            background: #1976d2;
            color: #fff;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: .3s;
        }

        .btn-submit:hover {
            background: #0d47a1;
        }

        @media (max-width: 600px) {
            .container {
                padding: 30px 20px;
            }

            .title {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title">Rencana Jangka Panjang</div>

    <form action="myaction.php" method="post">
        <div class="checkbox-group">
            <div class="checkbox-item">
                <input type="checkbox" id="plan1" name="plans[]" value="saya mampu menahan diri sebelum berbicara">
                <label for="plan1">Saya mampu menahan diri sebelum berbicara</label>
            </div>
            <div class="checkbox-item">
                <input type="checkbox" id="plan2" name="plans[]" value="saya mampu memilih kata yang tepat">
                <label for="plan2">Saya mampu memilih kata yang tepat</label>
            </div>

            <div class="checkbox-item">
                <input type="checkbox" id="plan3" name="plans[]" value="mampu mengurangi kata kasar">
                <label for="plan3">Mampu mengurangi kata kasar</label>
            </div>

            <div class="checkbox-item">
                <input type="checkbox" id="plan4" name="plans[]" value="kesadaran diri saat ingin mengatakan hal negatif">
                <label for="plan4">Kesadaran diri saat ingin mengatakan hal negatif</label>
            </div>
        </div>

        <div class="additional-plan">
            <p>Kalau kamu punya rencana yang lain, tuliskan dibawah ini:</p>
            <textarea name="additional_plan" placeholder="Tulis rencana tambahan kamu disini..."></textarea>
        </div>

        <div class="cta" style="text-align:center;">
            <button type="submit" class="btn-submit">Simpan Rencana</button>
        </div>
    </form>
</div>

</body>
</html>
