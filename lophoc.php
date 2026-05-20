<?php
session_start();
function connection_db(){
    $conn = mysqli_connect("localhost","root","","login_db");
    mysqli_set_charset($conn,"utf8mb4");
    return $conn;
}

if (!isset($_SESSION['user'])) {
    header("location: login.php");
    exit();
}

$conn = connection_db();
$user = $_SESSION['user'];
$is_admin = ($user === 'admin');

if ($is_admin) {
    // Admin: lấy tất cả lớp
    $result = mysqli_query($conn, "SELECT id, ten_lop FROM lopHoc ORDER BY id ASC");
    $all_classes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $all_classes[] = $row;
    }
} else {
    // Học sinh: lấy lớp của mình
    $sql = "SELECT lh.id, lh.ten_lop
            FROM users u
            INNER JOIN lopHoc lh ON u.id_lop = lh.id
            WHERE u.username = '$user'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lớp học của tôi</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #fff5f8; }
        .class-wrap {
            flex: 1; display: flex; justify-content: center; align-items: center;
        }
        .class-card {
            background: white; padding: 50px; border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center;
            max-width: 400px; width: 90%;
        }
        .btn-class {
            display: block; background: #ff69b4;
            color: white; padding: 30px; border-radius: 15px;
            font-size: 24px; font-weight: bold; margin: 20px 0;
            text-decoration: none;
        }
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
      <a href="dethi.php">Đề thi</a>
      <a href="khoahoc.php">Khoá học</a>
      <a href="tailieu.php">Tài liệu</a>
      <a class="lophct" href="lophoc.php">Lớp học của tôi</a>
      <div class="user-menu">
        <img src="avt.jpg" class="avatar" alt="User">
        <div class="dropdown">
          <?php if ($is_admin): ?>
          <a href="quanlyhocsinh.php">Quản lý học sinh</a>
          <a href="quanlylophoc.php">Quản lý lớp học</a>
          <a href="quanlybaihoc.php">Quản lý bài học</a>
          <?php endif; ?>
          <a href="doimatkhau.php">Đổi mật khẩu</a>
          <form method="post" action="home.php" style="margin:0;">
            <button type="submit" name="btn-logout" style="font-weight:bold;">Đăng xuất</button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>

<div class="class-wrap">
<div class="class-card">
    <?php if(isset($_SESSION['user'])): ?>
        <h2>Chào mừng, <?php echo $_SESSION['user']; ?>!</h2>

        <?php if ($is_admin): ?>
            <p>Chọn lớp để xem:</p>
            <?php foreach ($all_classes as $lop): ?>
                <a href="ngayhoc.php?lop_id=<?= $lop['id'] ?>" class="btn-class">
                    <?= htmlspecialchars($lop['ten_lop']) ?>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Đến với Lớp Học:</p>
            <a href="ngayhoc.php?lop_id=<?= $data['id'] ?>" class="btn-class">
                <?= htmlspecialchars($data['ten_lop']) ?>
            </a>
        <?php endif; ?>

        <a href="home.php" class="btn-back">← Quay lại Trang chủ</a>
    <?php endif; ?>
</div>
</div>

</body>
</html>
