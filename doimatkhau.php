<?php
session_start();
global $conn;
if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");

$message = "";

if (isset($_POST['doimk'])) {
    $user = $_SESSION['user'];
    $mk_cu = $_POST['mk_cu'];
    $mk_moi = $_POST['mk_moi'];
    $xacnhan = $_POST['xacnhan'];


    $sql = "SELECT * FROM users WHERE username='$user' AND password='$mk_cu'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $message = "Mật khẩu cũ không đúng";
    } elseif ($mk_moi != $xacnhan) {
        $message = "Mật khẩu xác nhận không khớp";
    } 
    elseif (
    strlen($mk_moi) < 8 ||
    !preg_match('/[A-Z]/', $mk_moi) ||    
    !preg_match('/[a-z]/', $mk_moi) ||   
    !preg_match('/[\W_]/', $mk_moi)      
) {
    $message = "Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt.";
    
}else {
        $update = "UPDATE users SET password='$mk_moi' WHERE username='$user'";
        mysqli_query($conn, $update);
        $message = "Đổi mật khẩu thành công";
    }
}
?>

<!doctype html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Học Tiếng Trung</title>
    <link rel="stylesheet" href="style.css">

  
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

<div class="change-box">
  <h2>Đổi mật khẩu</h2>

  <form method="post">
    <input type="password" name="mk_cu" placeholder="Mật khẩu cũ" required>
    <input type="password" name="mk_moi" placeholder="Mật khẩu mới" required>
    <input type="password" name="xacnhan" placeholder="Xác nhận mật khẩu" required>

    <button type="submit" name="doimk">Cập nhật</button>
  </form>

  <div class="msg">
    <?= $message ?>
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
        <p>https://hannguhw.com/</p>
    </div>
</footer>

  </body>
</html>
