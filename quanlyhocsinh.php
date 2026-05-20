<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "login_db");
mysqli_set_charset($conn,"utf8mb4");

// --- XỬ LÝ LỆNH SỬA (LƯU) TRỰC TIẾP TỪ BẢNG ---
if (isset($_POST['btn_sua_inline'])) {
    $id = $_POST['id'];
    $tk = $_POST['username'];
    $hoten = $_POST['ho_ten'];
    $ngaysinh = $_POST['ngay_sinh'];
    $sdt = $_POST['so_dien_thoai'];
    $email = $_POST['email'];
    $id_lop = $_POST['id_lop'];

    $sql_update = "UPDATE users SET username='$tk', ho_ten='$hoten', ngay_sinh='$ngaysinh', 
                   so_dien_thoai='$sdt', email='$email', id_lop='$id_lop' WHERE id='$id'";
    mysqli_query($conn, $sql_update);
    
    // Load lại trang sau khi sửa
    header("Location: quanlyhocsinh.php");
    exit();
}if (isset($_POST['btnxoa'])) {

    $id = (int)$_POST['id'];

    $sql_delete = "DELETE FROM users WHERE id='$id'";
    mysqli_query($conn, $sql_delete);
    

    header("Location: quanlyhocsinh.php");
    exit();
}
// --- LẤY DANH SÁCH LỚP (Để đưa vào ô chọn lớp) ---
$kq_lop = mysqli_query($conn, "SELECT * FROM lopHoc");
$danh_sach_lop = [];
while($l = mysqli_fetch_assoc($kq_lop)){
    $danh_sach_lop[] = $l;
}

// --- LẤY DANH SÁCH HỌC SINH ---
$sql = "SELECT users.*, lopHoc.ten_lop 
        FROM users 
        LEFT JOIN lopHoc ON users.id_lop = lopHoc.id 
        ORDER BY users.id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Tiếng Trung</title>

   <link rel="stylesheet" href="style.css">
<style>
        .giaodien {
            max-width: 1100px;
            margin: 40px auto;
            font-family: sans-serif;
            padding: 20px;
        }
        .giaodien h2 {
            margin-bottom: 20px;
        }
        /* Style cho nút Thêm */
      .btn-add{
    display: inline-block;
    padding: 10px 15px;
    background-color: #000;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-bottom: 15px;
    float: right;
}
        .btn-add:hover { background-color: #333; }
        
        /* Style cho bảng */
       table {
    width: 100%;
    border-collapse: collapse;
}
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        
/* Style cho nút Sửa / Xóa */
        .action-links {
            /* Dùng Flexbox để ép các nút nằm ngang một cách gọn gàng */
            display: flex;
            justify-content: center;
            gap: 8px; /* Khoảng cách giữa 2 nút */
 
        }
        .action-links a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            display: inline-block;
        }
        .btn-edit { background-color: #e0cb0e; color: #000; }
        .btn-delete { background-color: red; color: #fff; }
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
<div class="giaodien">
        <h2 style="text-align:center;">Quản lý danh sách học viên</h2>
        
        <a href="them_hocsinh.php" class="btn-add">+ Thêm học viên mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tài khoản</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Lớp học</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $stt = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <form id="form_<?= $row['id'] ?>" method="POST" action=""></form>

                            <input type="hidden" name="id" value="<?= $row['id'] ?>" form="form_<?= $row['id'] ?>">

                            <td><?= $stt++ ?></td>
                            
                            <td><input type="text" name="username" value="<?= htmlspecialchars($row['username']) ?>" form="form_<?= $row['id'] ?>" class="input-inline"></td>
                            
                            <td><input type="text" name="ho_ten" value="<?= htmlspecialchars($row['ho_ten']) ?>" form="form_<?= $row['id'] ?>" class="input-inline"></td>
                            
                            <td><input type="date" name="ngay_sinh" value="<?= $row['ngay_sinh'] ?>" form="form_<?= $row['id'] ?>" class="input-inline"></td>
                            
                            <td><input type="text" name="so_dien_thoai" value="<?= htmlspecialchars($row['so_dien_thoai']) ?>" form="form_<?= $row['id'] ?>" class="input-inline"></td>
                            
                            <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" form="form_<?= $row['id'] ?>" class="input-inline"></td>
                            
                            <td>
                                <select name="id_lop" form="form_<?= $row['id'] ?>" class="input-inline">
                                    <option value="">-- Chưa chọn --</option>
                                    <?php foreach ($danh_sach_lop as $lop): ?>
                                        <option value="<?= $lop['id'] ?>" <?= ($row['id_lop'] == $lop['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($lop['ten_lop']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            
                            <td class="action-links">
                                <button type="submit" name="btn_sua_inline" form="form_<?= $row['id'] ?>" class="btn-edit">Lưu</button>
                                <button type="submit" name="btnxoa" form="form_<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Xóa học viên này?');">Xóa</button>
                                
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Hiện chưa có học viên nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
