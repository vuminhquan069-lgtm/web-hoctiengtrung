<?php
session_start();

if (!isset($_SESSION['user'])) {
   header("location: login.php");
   exit();
}

$conn = mysqli_connect("localhost", "root", "", "login_db");
mysqli_set_charset($conn, "utf8");

/* lay user log */
$user = $_SESSION['user'];

if ($user === 'admin' && isset($_GET['lop_id'])) {
    $lop_id = (int)$_GET['lop_id'];
} else {
    $get_user = mysqli_query($conn, "SELECT id_lop FROM users WHERE username='$user'");
    $user_data = mysqli_fetch_assoc($get_user);
    $lop_id = $user_data['id_lop'];
}

/* lay day hien tai (day_id = ngayHoc.id) */
$current_day_id = isset($_GET['day']) ? (int)$_GET['day'] : 0;

/* day theo lop */
$days_list = [];
$days_q = mysqli_query($conn, "SELECT * FROM ngayHoc WHERE lop_id='$lop_id' ORDER BY day_number ASC");
while ($r = mysqli_fetch_assoc($days_q)) $days_list[] = $r;

if (!$current_day_id && count($days_list) > 0) {
    $current_day_id = (int)$days_list[0]['id'];
}

$current_day_number = 0;
foreach ($days_list as $r) {
    if ((int)$r['id'] === $current_day_id) { $current_day_number = (int)$r['day_number']; break; }
}
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
                <a href="home.php" style="color:#fff">汉</a>
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

            <?php if(isset($_SESSION['user'])): ?>

                <a class="lophct" href="lophoc.php">Lớp học của tôi</a>

                <div class="user-menu">

                    <img src="avt.jpg" class="avatar">

                    <div class="dropdown">

                        <?php if ($user === 'admin'): ?>
                        <a href="quanlyhocsinh.php">Quản lý học sinh</a>
                        <a href="quanlylophoc.php">Quản lý lớp học</a>
                        <a href="quanlybaihoc.php">Quản lý bài học</a>
                        <?php endif; ?>

                        <a href="doimatkhau.php">Đổi mật khẩu</a>

                        <form method="post" action="home.php" style="margin:0;">
                            <button type="submit" name="btn-logout">
                                Đăng xuất
                            </button>
                        </form>

                    </div>

                </div>

            <?php else: ?>

                <a href="login.php" class="btn-login">
                    Đăng nhập
                </a>

            <?php endif; ?>

        </nav>

    </div>
</header>

<div class="container main-layout">

    <aside class="sidebar">

        <h3>Lộ trình</h3>

        <?php foreach ($days_list as $d): ?>

            <a href="?lop_id=<?= $lop_id ?>&day=<?= $d['id'] ?>"
               class="day-btn <?= ((int)$d['id'] === $current_day_id) ? 'active' : '' ?>">

                <?= $d['ten_day'] ?>

            </a>

        <?php endforeach; ?>

    </aside>

    <main class="content-area">

        <h2>Nội dung Day <?= $current_day_number; ?></h2>

        <div class="part-box">

            <div class="part"
                 onclick="window.location.href='video.php?day=<?= $current_day_id; ?>&lop=<?= $lop_id; ?>'">

                <h4>VIDEO</h4>

            </div>

            <div class="part"
                 onclick="window.location.href='tuvung.php?day=<?= $current_day_id; ?>&lop=<?= $lop_id; ?>'">

                <h4>TỪ VỰNG</h4>

            </div>

            <div class="part"
                 onclick="window.location.href='ontap.php?day=<?= $current_day_id; ?>&lop=<?= $lop_id; ?>'">

                <h4>ÔN TẬP</h4>

            </div>

        </div>

    </main>

</div>

</body>
</html>