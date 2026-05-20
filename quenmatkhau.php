<?php
session_start();
$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");

require_once __DIR__ . '/mail_config.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/phpmailer/src/SMTP.php';

$buoc = 1;
$message = "";

function guiOTPEmail($toEmail, $otp) {
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = MAIL_PORT;
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($toEmail);
        $mail->Subject = 'Mã xác nhận đặt lại mật khẩu';
        $mail->Body    = "Xin chào,\n\nMã OTP của bạn là: $otp\n\nMã này có hiệu lực trong 10 phút.\nNếu bạn không yêu cầu, hãy bỏ qua email này.";
        $mail->send();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

if (isset($_POST['gui_ma'])) {
    $email = trim($_POST['email']);

    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        $otp = rand(100000, 999999);

        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_code']  = $otp;
        $_SESSION['reset_expire'] = time() + 600; // hết hạn sau 10 phút

        if (guiOTPEmail($email, $otp)) {
            $buoc = 2;
        } else {
            $message = "Không thể gửi email. Vui lòng kiểm tra cấu hình SMTP.";
            $buoc = 1;
        }
    } else {
        $message = "Email này không tồn tại trong hệ thống.";
        $buoc = 1;
    }
    mysqli_stmt_close($stmt);
}

if (isset($_POST['xac_nhan_ma'])) {
    $ma_nhap = trim($_POST['ma_xac_nhan']);

    if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_expire'])) {
        $message = "Phiên làm việc hết hạn. Vui lòng thử lại.";
        $buoc = 1;
    } elseif (time() > $_SESSION['reset_expire']) {
        unset($_SESSION['reset_code'], $_SESSION['reset_expire'], $_SESSION['reset_email']);
        $message = "Mã OTP đã hết hạn (10 phút). Vui lòng yêu cầu mã mới.";
        $buoc = 1;
    } elseif ($ma_nhap == $_SESSION['reset_code']) {
        $buoc = 3;
    } else {
        $message = "Mã xác nhận không chính xác. Vui lòng thử lại.";
        $buoc = 2;
    }
}

if (isset($_POST['dat_lai'])) {
    if (!isset($_SESSION['reset_email'])) {
        header("location: quenmatkhau.php");
        exit();
    }
    
    $mk_moi   = $_POST['mk_moi'];
    $xacnhan  = $_POST['xacnhan'];
    $email    = $_SESSION['reset_email'];

    if ($mk_moi !== $xacnhan) {
        $message = "Mật khẩu xác nhận không khớp.";
        $buoc = 3;
    } elseif (
    strlen($mk_moi) < 8 ||
    !preg_match('/[A-Z]/', $mk_moi) ||    
    !preg_match('/[a-z]/', $mk_moi) ||   
    !preg_match('/[\W_]/', $mk_moi)      
) {
    $message = "Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt.";
    $buoc = 3;
} else {
        $update = "UPDATE users SET password='$mk_moi' WHERE email='$email'";
        mysqli_query($conn, $update);
        
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_code']);

        $buoc = 4;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .reset-box { max-width: 400px; margin: 60px auto; padding: 20px; border: 1px solid #ccc; text-align: center; font-family: sans-serif; }
        .reset-box h2 { margin-bottom: 20px; }
        .reset-box input { width: 100%; padding: 8px; margin: 8px 0; box-sizing: border-box; }
        .reset-box button { width: 100%; padding: 10px; background: #000; color: #fff; border: none; cursor: pointer; margin-top: 10px; border-radius: 10px;}
        .reset-box .msg-error { color: red; font-size: 14px; margin-top: 10px; }
        .reset-box .msg-ok { color: green; font-size: 16px; font-weight: bold; }
.reset-box a { display: block; margin-top: 15px; font-size: 14px; color: blue; text-decoration: none; }
    </style>
</head>
<body>

<header class="topbar">
  <div class="container navbar">
    <div class="logo">
      <div class="logo-icon"><a href="home.php" style="color:#fff">汉</a></div>
      <div class="logo-text">
        <a href="home.php"><strong>汉语练习</strong></a>
        <a href="home.php"><span>HỌC TIẾNG TRUNG</span></a>
      </div>
    </div>
    <nav class="menu">
      <a href="home.php">Trang chủ</a>
      <a href="login.php" class="btn-login">Đăng nhập</a>
    </nav>
  </div>
</header>

<div class="reset-box">

<?php if ($buoc == 1): ?>
    <h2>Quên mật khẩu</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Nhập địa chỉ Email" required>
        <button type="submit" name="gui_ma">Gửi mã xác nhận</button>
    </form>
    <?php if ($message): ?>
        <p class="msg-error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <a href="login.php">Quay lại đăng nhập</a>

<?php elseif ($buoc == 2): ?>
    <h2>Nhập mã xác nhận</h2>
    <p style="font-size:14px;color:#555;">Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư (kể cả thư mục Spam).</p>
    <form method="post">
        <input type="text" name="ma_xac_nhan" placeholder="Nhập mã 6 số" required autocomplete="off">
        <button type="submit" name="xac_nhan_ma">Xác nhận</button>
    </form>
    <?php if ($message): ?>
        <p class="msg-error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <a href="quenmatkhau.php">quay lại</a>

<?php elseif ($buoc == 3): ?>
    <h2>Đặt lại mật khẩu</h2>
    <form method="post">
        <input type="password" name="mk_moi" placeholder="Mật khẩu mới" required>
        <input type="password" name="xacnhan" placeholder="Xác nhận mật khẩu" required>
        <button type="submit" name="dat_lai">Lưu mật khẩu mới</button>
    </form>
    <?php if ($message): ?>
        <p class="msg-error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

<?php elseif ($buoc == 4): ?>
    <h2>Thành công!</h2>
    <p class="msg-ok">Mật khẩu của bạn đã được thay đổi.</p>
    <a href="login.php">Đăng nhập ngay</a>
<?php endif; ?>

</div>

</body>
</html>
