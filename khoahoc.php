<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// ── Cấu hình Gmail ──────────────────────────────────────────────
$GMAIL_USER = 'vuminhquan069@gmail.com';
$GMAIL_PASS = 'ofsktdqqkesghnke';   // 16 ký tự, không có dấu cách
$NHAN_EMAIL = 'vuminhquan069@gmail.com';
// ────────────────────────────────────────────────────────────────

$thongBao = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoTen       = trim($_POST['hoTen']);
    $soDienThoai = trim($_POST['soDienThoai']);
    $email       = trim($_POST['email']);
    $ghiChu      = trim($_POST['ghiChu']);

    if ($hoTen == '' || $soDienThoai == '') {
        $thongBao = 'error';
    } else {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $GMAIL_USER;
            $mail->Password   = $GMAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom($GMAIL_USER, 'Hán ngữ HW');
            $mail->addAddress($NHAN_EMAIL);
            $mail->Subject = '[Đơn mới] Xác nhận thanh toán khóa học';
            $mail->Body    =
                "Có khách hàng xác nhận đã thanh toán:\n\n" .
                "Họ tên:       $hoTen\n" .
                "SĐT:          $soDienThoai\n" .
                "Email:        $email\n" .
                "Ghi chú:      $ghiChu\n";

            $mail->send();
            $thongBao = 'success';
        } catch (Exception $e) {
            $thongBao = 'email_error';
        }
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Khoá học</title>
<link rel="stylesheet" href="style.css">
<style>
* { box-sizing: border-box; }

.title{
    text-align:center;
    font-size:40px;
    font-weight:bold;
    margin:40px 0;
}

.container_khoahoc{
    display:flex;
    justify-content:center;
    padding-bottom: 60px;
}


.card{
    width:350px;
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}
.card h2{
    text-align:center;
    margin-bottom:20px;
}
.price{
    background:#ddd;
    padding:20px;
    text-align:center;
    border-radius:10px;
    font-weight:bold;
    font-size:20px;
    margin-bottom:20px;
}
.list{
    margin:20px 0;
}
.list li{
    margin:10px 0;
}
.btn{
    width:100%;
    padding:12px;
    border:2px solid black;
    background:white;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
}
.btn:hover{
    background:black;
    color:white;
}




#modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    overflow-y: auto;
}
#modal:target {
    display: block;
}
#modal-box {
    background: white;
    width: 750px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 10px;
}
#modal-body {
    display: flex;
    gap: 30px;
}
#modal-trai {
    flex: 1;
    text-align: center;
}
#modal-phai {
    flex: 1;
}
#modal-phai input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    font-size: 14px;
}
</style>
</head>
<body>


<header class="topbar">
  <div class="container navbar">

    <div class="logo">
      <div class="logo-icon">
        <a href="home.php" style="color: #fff">汉</a>
      </div>
      <div class="logo-text">
        <a href="home.php"><strong>汉语练习</strong></a>
        <a href="home.php"><span>HỌC TIẾNG TRUNG</span></a>
      </div>
    </div>

    <nav class="menu">
      <a href="home.php">Trang chủ</a>
      <a href="dethi.php">Đề thi</a>
      <a href="khoahoc.php">Khoá học</a>
      <a href="tailieu.php">Tài liệu</a>

            <?php if (isset($_SESSION['user'])): ?>

    <a class="lophct" href="lophoc.php">Lớp học của tôi</a>

    <div class="user-menu">
        <img src="avt.jpg" class="avatar" alt="User">

        <div class="dropdown">

  <?php if ($_SESSION['user'] === 'admin'): ?>

                <a href="quanlyhocsinh.php">Quản lý học sinh</a>
                <a href="quanlylophoc.php">Quản lý lớp học</a>
                <a href="quanlybaihoc.php">Quản lý bài học</a>
            <?php endif; ?>

            <a href="doimatkhau.php">Đổi mật khẩu</a>

            <form method="post" action="home.php" style="margin:0;">
               <button type="submit" name="btn-logout" style="font-weight:bold;"> Đăng xuất  </button>

            </form>

        </div>
    </div>

<?php else: ?>

    <a href="login.php" class="btn-login">Đăng nhập</a>

<?php endif; ?>

    </nav>

  </div>
</header>


<div class="title">Danh sách sản phẩm</div>
<div class="container_khoahoc">
    <div class="card">
        <h2>Khóa học</h2>
        <div class="price">
            12.000.000đ / 12 tháng
        </div>
        <ul class="list">
            <li>✔ Học từ HSK 1 → 6</li>
            <li>✔ Luyện đề có đáp án</li>
            <li>✔ Video giảng chi tiết</li>
            <li>✔ Hỗ trợ 24/7</li>
        </ul>
        <?php if(isset($_SESSION['user'])): ?>
        <button class="btn" disabled style="background:#e6f4ea;border-color:#4caf50;color:#2e7d32;cursor:default;">✔ Đã mua</button>
            <?php else: ?>
        <a href="#modal"><button class="btn">Mua ngay</button></a>
        <?php endif;?>
    </div>
</div>



<div id="modal">
    <div id="modal-box">
        <h2 style="text-align: center;">Thông tin thanh toán</h2>
        <hr>

        <div id="modal-body">

            <div id="modal-trai">
                <p><strong>Ngân hàng:</strong> MB Bank</p>
                <p><strong>Chủ tài khoản:</strong> NGUYEN HUU THANG</p>
                <p><strong>Số tài khoản:</strong> 0325778258</p>
                <p><strong>Số tiền:</strong> 1.200.000đ</p>
                <img src="https://img.vietqr.io/image/MB-0325778258-compact2.png?amount=1200000&addInfo=Mua%20khoa%20hoc&accountName=NGUYEN%20HUU%20THANG"
                     alt="QR thanh toán" width="220">
            </div>


            <div id="modal-phai">
                <h3 style="text-align: center;">Thông tin liên lạc</h3>

                <?php if ($thongBao == 'success'): ?>
                    <p style="color:green">Cảm ơn! Chúng tôi sẽ liên hệ với bạn sớm.</p>
                <?php elseif ($thongBao == 'error'): ?>
                    <p style="color:red">Vui lòng nhập đầy đủ họ tên và số điện thoại.</p>
                <?php endif; ?>

                <form action="khoahoc.php#modal" method="post">
                    <p class="tt" style="text-align: center;">
                    <input type="text"  name="hoTen"       placeholder="Họ và tên *"     required><br>
                    <input type="tel"   name="soDienThoai" placeholder="Số điện thoại *" required><br>
                    <input type="email" name="email"       placeholder="Email"><br>
                    <input type="text"  name="ghiChu"      placeholder="Ghi chú"><br> <br> <br>
                    <button type="submit" style="padding:10px 24px;background:#fff;border:1px solid #639922;border-radius:6px;color:#3B6D11;font-size:14px;cursor:pointer;">Xác nhận đã thanh toán</button>
                </p>
                </form>
            </div>

        </div>

        <hr>
        <a href="#">Đóng</a>
    </div>
</div>

<footer>
    <div>
        <h3>GIỚI THIỆU</h3>
        <p>Hán ngữ HW - chuyên giảng dạy HSK cho mọi đối tượng.</p>
    </div>
    <div>
        <h3>ĐỊA CHỈ</h3>
        <p>Hai Phong, Vietnam</p>
    </div>
    <div>
        <h3>THÔNG TIN LIÊN HỆ</h3>
        <p>Hotline: 0357107936<br><br>Email: hannguhw@gmail.com<br><br>Website: https://hannguhw.com/</p>
    </div>
    <div>
        <h3>LỐI TẮT</h3>
        <p>Link nhanh</p>
    </div>
</footer>

</body>
</html>