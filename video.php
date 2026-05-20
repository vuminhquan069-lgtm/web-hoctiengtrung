<?php
session_start();
if (!isset($_SESSION['user'])) { header("location: login.php"); exit(); }

$current_day = isset($_GET['day']) ? (int)$_GET['day'] : 1;
$lop_id = isset($_GET['lop']) ? (int)$_GET['lop'] : 0;
$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");
$vrow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ten_video FROM video WHERE day_id=$current_day"));
$video = $vrow ? $vrow['ten_video'] : "vd{$current_day}.mp4";
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
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
    <div class="container main-layout">
        <main class="content-area">
    <video controls width="1300" height="700">
    <source src="<?php echo $video?>" type="video/mp4">
    Trình duyệt không hỗ trợ video.
</video>
        </main>
    </div>

  
 <div class="btn-group">
        <div class="btnql" onclick="window.location.href='ngayhoc.php?lop_id=<?php echo $lop_id; ?>&day=<?php echo $current_day; ?>'">Quay lại</div>
        
    </div>
</body>
</html>
