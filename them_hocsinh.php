<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("location: login.php"); exit();
}

$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");

$lophoc = mysqli_query($conn, "SELECT * FROM lopHoc ORDER BY id ASC");
$danh_sach_lop = [];
while ($l = mysqli_fetch_assoc($lophoc)) $danh_sach_lop[] = $l;

$err = '';

if (isset($_POST['btn_them'])) {
    $tk   = trim($_POST['username']);
    $pw   = trim($_POST['password']);
    $ht   = trim($_POST['ho_ten']);
    $ns   = $_POST['ngay_sinh'];
    $sdt  = trim($_POST['so_dien_thoai']);
    $em   = trim($_POST['email']);
    $lop  = $_POST['id_lop'] !== '' ? (int)$_POST['id_lop'] : 'NULL';

    if (!$tk || !$pw || !$ht || !$em) {
        $err = 'Vui lòng điền đầy đủ các trường bắt buộc.';
    } else {
        $tk_  = mysqli_real_escape_string($conn, $tk);
        $pw_  = mysqli_real_escape_string($conn, $pw);
        $ht_  = mysqli_real_escape_string($conn, $ht);
        $sdt_ = mysqli_real_escape_string($conn, $sdt);
        $em_  = mysqli_real_escape_string($conn, $em);
        $ns_  = $ns ? "'$ns'" : 'NULL';
        $lop_ = $lop !== 'NULL' ? $lop : 'NULL';

        $ok = mysqli_query($conn, "INSERT INTO users (username,password,ho_ten,ngay_sinh,so_dien_thoai,email,id_lop)
                                   VALUES ('$tk_','$pw_','$ht_',$ns_,'$sdt_','$em_',$lop_)");
        if ($ok) {
            header("Location: quanlyhocsinh.php"); exit();
        } else {
            $err = mysqli_errno($conn) == 1062
                ? 'Tài khoản hoặc email đã tồn tại.'
                : 'Lỗi: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thêm học viên</title>
<link rel="stylesheet" href="style.css">
<style>
* { box-sizing: border-box; }
.wrap { max-width: 560px; margin: 40px auto; padding: 0 20px 60px; font-family: sans-serif; }
h2 { text-align: center; margin-bottom: 24px; }
.form-group { margin-bottom: 16px; }
label { display: block; font-weight: bold; margin-bottom: 6px; font-size: 14px; }
label span { color: #e74c3c; }
input[type=text], input[type=email], input[type=password], input[type=date], select {
    width: 100%; padding: 10px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px;
}
.btn-submit { width: 100%; padding: 12px; background: #000; color: #fff; border: none; border-radius: 6px; font-size: 15px; font-weight: bold; cursor: pointer; }
.btn-submit:hover { background: #333; }
.btn-back { display: inline-block; margin-bottom: 16px; color: #555; font-size: 14px; text-decoration: none; }
.btn-back:hover { text-decoration: underline; }
.msg-err { background: #fdecea; border: 1px solid #e74c3c; color: #c0392b; padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
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
          <a href="quanlyhocsinh.php">Quản lý học sinh</a>
          <a href="quanlylophoc.php">Quản lý lớp học</a>
          <a href="quanlybaihoc.php">Quản lý bài học</a>
          <a href="doimatkhau.php">Đổi mật khẩu</a>
          <form method="post" action="home.php" style="margin:0;">
            <button type="submit" name="btn-logout" style="font-weight:bold;">Đăng xuất</button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>

<div class="wrap">
    <a href="quanlyhocsinh.php" class="btn-back">← Quay lại danh sách</a>
    <h2>Thêm học viên mới</h2>

    <?php if ($err): ?>
    <div class="msg-err"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Tài khoản <span>*</span></label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu <span>*</span></label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Họ tên <span>*</span></label>
            <input type="text" name="ho_ten" value="<?= htmlspecialchars($_POST['ho_ten'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Email <span>*</span></label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="ngay_sinh" value="<?= htmlspecialchars($_POST['ngay_sinh'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($_POST['so_dien_thoai'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Lớp học</label>
            <select name="id_lop">
                <option value="">-- Chưa phân lớp --</option>
                <?php foreach ($danh_sach_lop as $lop): ?>
                <option value="<?= $lop['id'] ?>" <?= (($_POST['id_lop'] ?? '') == $lop['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($lop['ten_lop']) ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="btn_them" class="btn-submit">Thêm học viên</button>
    </form>
</div>

</body>
</html>
