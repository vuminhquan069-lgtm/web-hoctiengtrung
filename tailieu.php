<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Tài liệu</title>
<link rel="stylesheet" href="style.css">
<style>
  body {
    margin: 0;
    padding: 0;
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

<div class="container main-layout">
    

  <!-- LEFT -->
  <div class="sidebar">
    <div class="menu-card">
        <p>TÀI LIỆU NGỮ PHÁP</p>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="content">

    <a href="https://drive.google.com/drive/folders/1o1JtoZ3MjB1lHC1yxzT2zM1vGy7SE7N_" target="_blank" class="item">
    <img src="giao-trinh-chuan-hsk1.jpg" alt="">
    <div class="info">
      <h3>Giáo trình chuẩn HSK</h3>
      <p class="category">TÀI LIỆU NGỮ PHÁP</p>
    </div>
  </a>

  <a href="https://drive.google.com/drive/folders/1We89rtsD7VHJQObHl0P-XwBKqTE6lvVz" target="_blank" class="item">
    <img src="giao-trinh-chuan-hsk2.jpg" alt="">
    <div class="info">
      <h3>Giáo trình chuẩn HSK 2</h3>
      <p class="category">TÀI LIỆU NGỮ PHÁP 2</p>
    </div>
  </a>

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
</html><