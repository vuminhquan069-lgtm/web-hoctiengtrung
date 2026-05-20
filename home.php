<?php
session_start();
global $conn;
function disconnect_db(){
    global $conn;
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }
}

if (isset($_POST['btn-logout'])) {
    disconnect_db();
    session_unset();
    session_destroy();
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Tiếng Trung</title>

   <link rel="stylesheet" href="style.css">

  </head>

  <body>

    <!-- HEADER -->
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

    <section class="hero">
      <div class="container">
        <div class="hero-title-box">
          <h1>Học & Luyện đề<br />Tiếng Trung hiệu quả</h1>
        </div>

        <div class="hero-actions">
          <p>Hàng trăm đề thi HSK từ cơ bản đến nâng cao. Học theo chủ đề, theo cấp độ, có giải thích chi tiết.</p>
        </div>

        <div class="hero-stats">
          <div class="stat"><strong>500+</strong><span>Câu hỏi</span></div>
          <div class="stat"><strong>HSK 1-6</strong><span>Cấp độ</span></div>
          <div class="stat"><strong>20+</strong><span>Chủ đề</span></div>
          <div class="stat">
            <strong>Miễn phí</strong><span>Hoàn toàn</span>
          </div>
        </div>
      </div>
    </section>

    <main class="content">
      <div class="container">
        <div class="section-title">
          <h2>Chọn chủ đề luyện thi</h2>
        </div>

        <div class="topic-grid">
          <a href="kiemtra.php?topic=chaohoi" class="topic-card">
            <div class="hanzi">你好</div>
            <h3>Chào hỏi</h3>
          </a>

          <a href="kiemtra.php?topic=giadinh" class="topic-card">
            <div class="hanzi">家</div>
            <h3>Gia đình</h3>
          </a>

          <a href="kiemtra.php?topic=thoigian" class="topic-card">
            <div class="hanzi">时间</div>
            <h3>Thời gian</h3>
          </a>
        </div>
      </div>
    </main>


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