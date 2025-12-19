<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verification Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet">

    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f8fbff);
            min-height: 100vh;
        }

        .navbar-laravel {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        .otp-wrapper {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0,0,0,.12);
        }

        .card-header {
            background: #2196f3;
            color: #fff;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 14px 14px 0 0;
        }

        .form-control {
            border-radius: 10px;
            height: 45px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 .15rem rgba(33,150,243,.25);
        }

        .btn-verify {
            background: #2196f3;
            color: #fff;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-verify:hover {
            background: #1976d2;
            transform: translateY(-1px);
        }

        .otp-note {
            text-align: center;
            font-size: .9rem;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-light navbar-laravel">
    <div class="container">
        <span class="navbar-brand mb-0 h1">Verification Account</span>
    </div>
</nav>

<div class="otp-wrapper">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-header">OTP Verification</div>
            <div class="card-body">

                <p class="otp-note">
                    Masukkan kode OTP yang telah dikirim ke email Anda
                </p>

                <form method="POST">
                    <div class="form-group">
                        <input type="text"
                               name="otp_code"
                               class="form-control text-center"
                               placeholder="6-digit OTP"
                               required
                               autofocus>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="verify" class="btn btn-verify">
                            Verify Account
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
include('koneksi.php');

if (isset($_POST["verify"])) {
    $otp       = $_SESSION['otp'];
    $email     = $_SESSION['mail'];
    $otp_code  = $_POST['otp_code'];

    if ($otp != $otp_code) {
        echo "<script>alert('Invalid OTP code');</script>";
    } else {
        mysqli_query($conn, "UPDATE users SET status = 1 WHERE email = '$email'");
        echo "<script>
                alert('Verify account done, you may sign in now');
                window.location.replace('login.php');
              </script>";
    }
}
?>