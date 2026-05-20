<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "login_db");
mysqli_set_charset($conn, "utf8");
if (!$conn) {
    die("Lỗi kết nối");
}

$message = "";

/* them lop */
if (isset($_POST['btn-add-class'])) {
    $ten_lop = trim($_POST['ten_lop']);
    $insert = mysqli_query($conn, "
    INSERT INTO lopHoc(ten_lop)
    VALUES('$ten_lop')
    ");

    if (!$insert) {
        $message = "Lớp học đã tồn tại";
    } else {
        header("Location: quanlylophoc.php");
        exit();
    }
}

/* them Day */
if (isset($_POST['btn-add-day'])) {

    $lop_id = $_POST['lop_id'];

    $get_max = mysqli_query($conn, "
    SELECT MAX(day_number) as maxday
    FROM ngayHoc
    WHERE lop_id='$lop_id'
    ");

    $row = mysqli_fetch_assoc($get_max);

    $next_day = $row['maxday'] + 1;

    if ($next_day == 0) {
        $next_day = 1;
    }

    $ten_day = "Day " . $next_day;

    mysqli_query($conn, "
    INSERT INTO ngayHoc(day_number, ten_day, lop_id)
    VALUES('$next_day','$ten_day','$lop_id')
    ");

    header("Location: quanlylophoc.php");
    exit();
}

/*xoa lop*/
if (isset($_GET['delete_class'])) {
    $id = (int)$_GET['delete_class'];

    // Lấy danh sách day của lớp này
    $days_res = mysqli_query($conn, "SELECT id FROM ngayHoc WHERE lop_id='$id'");
    $day_ids = [];
    while ($d = mysqli_fetch_assoc($days_res)) {
        $day_ids[] = (int)$d['id'];
    }

    // Xóa nội dung bài học của từng day (tuvung, video, ontap)
    if (!empty($day_ids)) {
        $day_ids_str = implode(',', $day_ids);
        mysqli_query($conn, "DELETE FROM tuvung WHERE day_id IN ($day_ids_str)");
        mysqli_query($conn, "DELETE FROM video WHERE day_id IN ($day_ids_str)");
        mysqli_query($conn, "DELETE FROM ontap WHERE day_id IN ($day_ids_str)");
    }

    // Xóa các ngày học của lớp
    mysqli_query($conn, "DELETE FROM ngayHoc WHERE lop_id='$id'");

    // Bỏ lớp khỏi học sinh (tránh lỗi foreign key)
    mysqli_query($conn, "UPDATE users SET id_lop=NULL WHERE id_lop='$id'");

    // Xóa lớp
    mysqli_query($conn, "DELETE FROM lopHoc WHERE id='$id'");

    header("Location: quanlylophoc.php");
    exit();
}

/* xoa Day */

if (isset($_GET['delete_day'])) {
    $id = (int)$_GET['delete_day'];

    // Xóa nội dung liên quan trước
    mysqli_query($conn, "DELETE FROM tuvung WHERE day_id='$id'");
    mysqli_query($conn, "DELETE FROM video WHERE day_id='$id'");
    mysqli_query($conn, "DELETE FROM ontap WHERE day_id='$id'");

    mysqli_query($conn, "DELETE FROM ngayHoc WHERE id='$id'");
    header("Location: quanlylophoc.php");
    exit();
}

/* danh sach lop */

$lophoc = mysqli_query($conn, "
SELECT * FROM lopHoc
ORDER BY id ASC
");
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý lớp h</title>
    <link rel="stylesheet" href="style.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
        }

        .giaodien {
            width: 1000px;
            margin: auto;
            padding: 30px 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        button {
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-add {
            background: black;
            color: white;
        }

        .btn-day {
            background: #0d6efd;
            color: white;
        }

        .btn-delete {
            background: red;
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
        }

        .class-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .class-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .class-name {
            font-size: 20px;
            font-weight: bold;
        }

        .day-list {
            margin-top: 15px;
            padding-left: 20px;
        }

        .day-item {
            display: flex;
            justify-content: space-between;
            align-items: center;

            background: #fafafa;

            padding: 10px;
            border-radius: 6px;

            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            color: while;
            padding: 20px 35px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            animation: an 3s forwards;
        }

        @keyframes an {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }
    </style>

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
                                <button type="submit" name="btn-logout" style="font-weight:bold;"> Đăng xuất </button>

                            </form>

                        </div>
                    </div>

                <?php else: ?>

                    <a href="login.php" class="btn-login">Đăng nhập</a>

                <?php endif; ?>

            </nav>

        </div>
    </header>


    <div class="giaodien">
        <h1>Quản lý lớp học</h1>

        <?php if ($message != "") { ?>
            <div class="alert">
                <?= $message ?>
            </div>

        <?php } ?>

        <!-- form them lop -->
        <div class="class-box">
            <h2>Thêm lớp học</h2>

            <form method="POST">
                <input type="text" name="ten_lop" placeholder="Nhập tên lớp" required> <br><br>

                <button type="submit" name="btn-add-class" class="btn-add">Thêm lớp</button>
            </form>

        </div>

        <!--danh sach lop -->
        <?php while ($lop = mysqli_fetch_assoc($lophoc)) { ?>
            <div class="class-box">
                <div class="class-header">
                    <div class="class-name">
                        <?= $lop['ten_lop'] ?>
                    </div>

                    <div>

                        <form method="POST" style="display:inline">
                            <input type="hidden" name="lop_id" value="<?= $lop['id'] ?>">
                            <button class="btn-day" name="btn-add-day">+ Day</button>

                        </form method=>
                        <a class="btn-delete" href="?delete_class=<?= $lop['id'] ?>">Xóa lớp</a>
                    </div>
                </div>

                <!-- Danh sach Day -->
                <div class="day-list">

                    <?php
                    $days = mysqli_query($conn, "
                                        SELECT *
                                        FROM ngayHoc
                                        WHERE lop_id='" . $lop['id'] . "'
                                        ORDER BY day_number ASC
                                        ");

                    $max_day_res = mysqli_query($conn, "SELECT MAX(day_number) as maxday FROM ngayHoc WHERE lop_id='" . $lop['id'] . "'");
                    $max_day_row = mysqli_fetch_assoc($max_day_res);
                    $max_day = $max_day_row['maxday'];
                    ?>

                    <?php while ($day = mysqli_fetch_assoc($days)) { ?>
                        <div class="day-item">
                            <div>  Day <?= $day['day_number'] ?>
                            </div>

                            <div>
                                <?php if ($day['day_number'] == $max_day): ?>
                                    <a class="btn-delete" href="?delete_day=<?= $day['id'] ?>">Xóa</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
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

    <script>
        window.onload = function () {
            let scroll = localStorage.getItem("scrollpos");
            if (scroll) {
                window.scrollTo(0, scroll);
            }

        }

        window.onbeforeunload = function () {
            localStorage.setItem("scrollpos", window.scrollY);
        }

    </script>

</body>
</html>