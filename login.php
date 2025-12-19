<?php
session_start();
include 'koneksi.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if(isset($_POST["submit"])) {
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['id'] = $user['id'];

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: assett/narasi/narasiVerbalCheckUp.php");
            }
            exit;
        } else {
            $message = "Email atau password salah!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Form</title>
    <link rel="stylesheet" href="SignUp_LogIn_Form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
  <body>

    <!-- credits to the writter @leonam-silva-de-souza -->
      <div class="container">

          <div class="form-box login" id="login">
              <form method="POST" action="">
                  <h1>Login</h1>
                  <div class="input-box">
                      <input type="email" placeholder="Email" name="email" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <?php if (!empty($message)): ?>
                    <p style="color:red;"><?= $message ?></p>
                  <?php endif; ?>
                  <div class="forgot-link">
                      <a href="recoveryPass.php" style="color: #007bff;">Lupa Password?</a>
                  </div>
                  <button type="submit" class="btn" name="submit">Login</button>
                  <p>© 2025 • Di Buat Oleh Afriyawanti</p>
              </form>
          </div>

          <div class="form-box register" id="register">
              <form method="POST" action="signup.php">
                  <h1>Pendaftaran</h1>
                  <div class="input-box">
                      <input type="text" placeholder="NIS" name="nis" required>
                      <i class='bx bxs-user'></i>
                   </div>
                  <div class="input-box">
                      <input type="text" placeholder="Username" name="nama" required>
                      <i class='bx bxs-user'></i>
                  </div>
                  <div class="input-box">
                      <input type="email" placeholder="Email" name="email" required>
                      <i class='bx bxs-envelope' ></i>
                  </div>
                  <div class="input-box">
                      <input type="password" placeholder="Password" name="password" required>
                      <i class='bx bxs-lock-alt' ></i>
                  </div>
                  <button type="submit" class="btn">Daftar</button>
                  
              </form>
          </div>

          <div class="toggle-box">
              <div class="toggle-panel toggle-left">
                    <img src="assett/img/image.png"
     alt="logo bk"
     style="position:absolute;top:20px;left:20px;width:70px;height:70px;border-radius: 50%;z-index:9999;">

                    <h1>Selamat Datang Guys!</h1>
                  <p>Belum punya akun?</p>
                  <button class="btn register-btn">Daftar</button>
              </div>

              <div class="toggle-panel toggle-right">
                <img src="assett/img/image.png"
         alt="logo bk"
         style="position:absolute;top:20px;right:20px;width:70px;height:70px;border-radius: 50%;z-index:9999;">
                  <h1>Bergabung</h1>
                  <p>Sudah punya akun?</p>
                  <button class="btn login-btn">Login</button>
              </div>
          </div>
      </div>

      <script src="SignUp_LogIn_Form.js"></script>
      <?php if (isset($_SESSION['popup'])): ?>
      <script>
        alert("<?= addslashes($_SESSION['popup']); ?>");
      </script>
      <?php unset($_SESSION['popup']); endif; ?>

  </body>
</html>