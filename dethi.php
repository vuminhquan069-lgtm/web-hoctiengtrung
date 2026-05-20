<?php
session_start();
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kho đề thi HSK - Hán ngữ HW</title>
    <link rel="stylesheet" href="style.css">
    <style>

        .topic-grid {
            margin-top: 40px;
            margin-bottom: 60px;
        }


        .topic-card-link {
            display: block;
            background: #fff;
            border: 1px solid #eee;
            padding: 50px 20px;
            border-radius: 15px;
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
        }


      

        .hanzi-display {
            font-size: 48px;
            color: #e35a43;
            font-weight: 900;
        }

        .hero-title-box {
            background: #ffe4ec;
            padding: 60px 0;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            text-align: center;
        }
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

<section class="hero">
    <div class="container">
        <div class="hero-title-box">
            <h1 style="font-size: 72px; font-weight: 900;">Kho đề thi HSK</h1>
        </div>
    </div>
</section>

<main class="content">
    <div class="container">
        <div class="section-title">
            <h2>Luyện đề theo cấp độ</h2>
            <p style="color: #666; font-size: 18px;">Chọn cấp độ phù hợp để bắt đầu thử sức.</p>
        </div>

        <div class="topic-grid">
            <?php 
for($i=1; $i<=10; $i++) {
    // Nếu là HSK 1 thì mở đề 1, HSK 2 thì mở đề 2
    if($i == 1) {
        $link = "H10901.pdf";
    } elseif($i == 2) {
        $link = "H20901.pdf";
        } elseif($i == 3) {
        $link = "H31001.pdf";
        } elseif($i == 4) {
        $link = "H41001.pdf";
        } elseif($i == 5) {
        $link = "H51001.pdf";
    } else {
        $link = "H61005.pdf"; // Các cấp độ khác chưa có đề
    }
?>
    <a href="<?php echo $link; ?>" target="_blank" class="topic-card-link">
        <div class="hanzi-display">HSK <?php echo $i; ?></div>
    </a>
<?php } ?>
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