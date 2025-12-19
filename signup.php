<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis   = trim($_POST['nis']);
    $nama     = trim($_POST['nama']);
    $email    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($nis) || empty($nama) || empty($email) || empty($password)) {
        $_SESSION['popup'] = "Semua field wajib diisi.";
        header("Location: login.php#register");
        exit;
    }

    $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $_SESSION['popup'] = "Email sudah terdaftar.";
        header("Location: login.php#register");
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare(
        "INSERT INTO users (nis, nama, email, password) VALUES (?, ?, ?, ?)"
    );  
    $stmt->bind_param("ssss", $nis, $nama, $email, $hash);

    if ($stmt->execute()) {
        $otp = rand(100000,999999);
                    $_SESSION['otp'] = $otp;
                    $_SESSION['mail'] = $email;
                    require "Mail/phpmailer/PHPMailerAutoload.php";
                    $mail = new PHPMailer;
    
                    $mail->isSMTP();
                    $mail->Host='smtp.gmail.com';
                    $mail->Port=587;
                    $mail->SMTPAuth=true;
                    $mail->SMTPSecure='tls';
    
                    $mail->Username='discordrtmsamp@gmail.com';
                    $mail->Password='tlxkvftplhkjrjkf';

                    $mail->setFrom('discordrtmsamp@gmail.com', 'OTP Verification');
                    $mail->addAddress($_POST["email"]);
    
                    $mail->isHTML(true);
                    $mail->Subject="Kode verifikasi Anda";
                    $mail->Body="<p>Hai, </p> <h3>Kode verifikasi anda adalah $otp <br></h3>
                    <br><br>
                    <p>With regrads,</p>
                    <b>Programming with Lam</b>
                    https://www.youtube.com/channel/UCKRZp3mkvL1CBYKFIlxjDdg";
    
                            if(!$mail->send()){
                                ?>
                                    <script>
                                        alert("<?php echo "Register Failed, Invalid Email "?>");
                                    </script>
                                <?php
                            }else{
                                ?>
                                <script>
                                    alert("<?php echo "Register Successfully, OTP sent to " . $email ?>");
                                    window.location.replace('verification.php');
                                </script>
                                <?php
                            }
    } else {
        $_SESSION['popup'] = "Pendaftaran gagal.";
        header("Location: login.php#register");
        exit;
    }
}
