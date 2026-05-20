<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
    header("location: login.php"); exit();
}

$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");

$tab    = $_GET['tab'] ?? 'video';
$lop_id = (int)($_GET['lop'] ?? 0);
$day_id = (int)($_GET['day'] ?? 0);

// ── XỬ LÝ POST ──────────────────────────────────────────────────

// VIDEO
if (isset($_POST['luu_video'])) {
    $d   = (int)$_POST['day_id'];
    $lid = (int)$_POST['lop_id'];
    $ten = mysqli_real_escape_string($conn, trim($_POST['ten_video']));

    if (!empty($_FILES['file_video']['name'])) {
        $orig = $_FILES['file_video']['name'];
        $ext  = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
        $allowed = ['mp4','webm','ogg','mov','avi'];
        if (!in_array($ext, $allowed)) {
            header("Location: quanlybaihoc.php?tab=video&lop=$lid&day=$d&err=ext"); exit();
        }
        $filename = 'vd' . $d . '.' . $ext;
        if (!move_uploaded_file($_FILES['file_video']['tmp_name'], __DIR__ . '/' . $filename)) {
            header("Location: quanlybaihoc.php?tab=video&lop=$lid&day=$d&err=upload"); exit();
        }
        $ten = mysqli_real_escape_string($conn, $filename);
    }

    $exists = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM video WHERE day_id=$d"));
    if ($exists) mysqli_query($conn, "UPDATE video SET ten_video='$ten' WHERE day_id=$d");
    else         mysqli_query($conn, "INSERT INTO video (day_id,ten_video) VALUES ($d,'$ten')");
    header("Location: quanlybaihoc.php?tab=video&lop=$lid&day=$d&ok=1"); exit();
}

// TỪ VỰNG
if (isset($_POST['them_tuvung'])) {
    $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    $h = mysqli_real_escape_string($conn, trim($_POST['hanzi']));
    $p = mysqli_real_escape_string($conn, trim($_POST['pinyin']));
    $n = mysqli_real_escape_string($conn, trim($_POST['nghia']));
    mysqli_query($conn, "INSERT INTO tuvung (day_id,hanzi,pinyin,nghia) VALUES ($d,'$h','$p','$n')");
    header("Location: quanlybaihoc.php?tab=tuvung&lop=$lid&day=$d&ok=1"); exit();
}
if (isset($_POST['sua_tuvung'])) {
    $id = (int)$_POST['id']; $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    $h  = mysqli_real_escape_string($conn, trim($_POST['hanzi']));
    $p  = mysqli_real_escape_string($conn, trim($_POST['pinyin']));
    $n  = mysqli_real_escape_string($conn, trim($_POST['nghia']));
    mysqli_query($conn, "UPDATE tuvung SET hanzi='$h',pinyin='$p',nghia='$n' WHERE id=$id");
    header("Location: quanlybaihoc.php?tab=tuvung&lop=$lid&day=$d&ok=1"); exit();
}
if (isset($_POST['xoa_tuvung'])) {
    $id = (int)$_POST['id']; $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    mysqli_query($conn, "DELETE FROM tuvung WHERE id=$id");
    header("Location: quanlybaihoc.php?tab=tuvung&lop=$lid&day=$d&ok=1"); exit();
}

// ÔN TẬP
if (isset($_POST['them_ontap'])) {
    $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    $q = mysqli_real_escape_string($conn, trim($_POST['cau_hoi']));
    $a = mysqli_real_escape_string($conn, trim($_POST['dap_an_a']));
    $b = mysqli_real_escape_string($conn, trim($_POST['dap_an_b']));
    $c = mysqli_real_escape_string($conn, trim($_POST['dap_an_c']));
    $dd = mysqli_real_escape_string($conn, trim($_POST['dap_an_d']));
    $ans = in_array($_POST['dap_an_dung'], ['a','b','c','d']) ? $_POST['dap_an_dung'] : 'a';
    mysqli_query($conn, "INSERT INTO ontap (day_id,cau_hoi,dap_an_a,dap_an_b,dap_an_c,dap_an_d,dap_an_dung) VALUES ($d,'$q','$a','$b','$c','$dd','$ans')");
    header("Location: quanlybaihoc.php?tab=ontap&lop=$lid&day=$d&ok=1"); exit();
}
if (isset($_POST['sua_ontap'])) {
    $id = (int)$_POST['id']; $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    $q  = mysqli_real_escape_string($conn, trim($_POST['cau_hoi']));
    $a  = mysqli_real_escape_string($conn, trim($_POST['dap_an_a']));
    $b  = mysqli_real_escape_string($conn, trim($_POST['dap_an_b']));
    $c  = mysqli_real_escape_string($conn, trim($_POST['dap_an_c']));
    $dd = mysqli_real_escape_string($conn, trim($_POST['dap_an_d']));
    $ans = in_array($_POST['dap_an_dung'], ['a','b','c','d']) ? $_POST['dap_an_dung'] : 'a';
    mysqli_query($conn, "UPDATE ontap SET cau_hoi='$q',dap_an_a='$a',dap_an_b='$b',dap_an_c='$c',dap_an_d='$dd',dap_an_dung='$ans' WHERE id=$id");
    header("Location: quanlybaihoc.php?tab=ontap&lop=$lid&day=$d&ok=1"); exit();
}
if (isset($_POST['xoa_ontap'])) {
    $id = (int)$_POST['id']; $d = (int)$_POST['day_id']; $lid = (int)$_POST['lop_id'];
    mysqli_query($conn, "DELETE FROM ontap WHERE id=$id");
    header("Location: quanlybaihoc.php?tab=ontap&lop=$lid&day=$d&ok=1"); exit();
}

// ── LẤY DỮ LIỆU ─────────────────────────────────────────────────

// Danh sách lớp học
$lophoc_list = mysqli_query($conn, "SELECT * FROM lopHoc ORDER BY id ASC");
$lophoc_arr  = [];
while ($r = mysqli_fetch_assoc($lophoc_list)) $lophoc_arr[] = $r;

// Nếu chưa chọn lớp, tự chọn lớp đầu tiên
if (!$lop_id && count($lophoc_arr) > 0) {
    $lop_id = $lophoc_arr[0]['id'];
}

// Danh sách day của lớp đang chọn
$days_arr = [];
if ($lop_id) {
    $days_res = mysqli_query($conn, "SELECT * FROM ngayHoc WHERE lop_id=$lop_id ORDER BY day_number ASC");
    while ($r = mysqli_fetch_assoc($days_res)) $days_arr[] = $r;
}

// Nếu chưa chọn day, tự chọn day đầu tiên của lớp
if (!$day_id && count($days_arr) > 0) {
    $day_id = $days_arr[0]['id'];
}

// Tên lớp hiện tại
$lop_row = null;
foreach ($lophoc_arr as $l) { if ((int)$l['id'] === $lop_id) { $lop_row = $l; break; } }

// Tên day hiện tại
$day_row = null;
foreach ($days_arr as $d) { if ((int)$d['id'] === $day_id) { $day_row = $d; break; } }

// Nội dung tab
$video_row   = $day_id ? mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM video  WHERE day_id=$day_id")) : null;
$tuvung_list = $day_id ? mysqli_query($conn, "SELECT * FROM tuvung WHERE day_id=$day_id ORDER BY id") : null;
$ontap_list  = $day_id ? mysqli_query($conn, "SELECT * FROM ontap  WHERE day_id=$day_id ORDER BY id") : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quản lý bài học</title>
<link rel="stylesheet" href="style.css">
<style>
* { box-sizing: border-box; }
.ql-wrap { max-width: 1000px; margin: 30px auto; padding: 0 20px 60px; font-family: sans-serif; }
h2 { text-align: center; margin-bottom: 20px; }

.tabs { display: flex; gap: 8px; margin-bottom: 20px; }
/* Tab: đen */
.tab-btn { padding: 10px 24px; border: 2px solid #333; border-radius: 8px; background: #fff; cursor: pointer; font-size: 15px; font-weight: bold; text-decoration: none; color: #333; }
.tab-btn.active { background: #222; color: #fff; border-color: #222; }

/* Lớp: xanh dương */
.section-label { font-size: 12px; font-weight: bold; color: #888; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 1px; }
.lop-bar { display: flex; gap: 8px; margin-bottom: 10px; flex-wrap: wrap; }
.lop-btn { padding: 8px 18px; border: 1.5px solid #aaa; border-radius: 6px; text-decoration: none; color: #333; font-weight: bold; }
.lop-btn.active { background: #1565c0; color: #fff; border-color: #1565c0; }

/* Day: xanh lá */
.day-bar { display: flex; gap: 8px; margin-bottom: 6px; flex-wrap: wrap; }
.day-btn { padding: 8px 18px; border: 1.5px solid #aaa; border-radius: 6px; text-decoration: none; color: #333; font-weight: bold; position: relative; }
.day-btn.active { background: #00897b; color: #fff; border-color: #00897b; }
.day-btn.active::after { content: ''; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: #00897b; }


.empty-state { text-align:center; color:#aaa; padding: 40px; font-size:15px; }

.card { background: #fff; border: 1px solid #ddd; border-radius: 10px; padding: 20px; margin-bottom: 16px; }
.card-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
input[type=text], textarea, select { padding: 8px 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
.inp-sm { width: 120px; }
.inp-md { width: 200px; }
.inp-lg { flex: 1; min-width: 200px; }

.btn { padding: 8px 18px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: bold; }
.btn-save { background: #2ecc71; color: #fff; }
.btn-del  { background: #e74c3c; color: #fff; }
.btn-add  { background: #000; color: #fff; padding: 10px 22px; font-size: 15px; }

.msg-ok  { background: #e6f9ee; border: 1px solid #2ecc71; color: #1a7a45; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; }
.msg-err { background: #fdecea; border: 1px solid #e74c3c; color: #c0392b; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; }

details summary { cursor: pointer; font-weight: bold; color: #d64a2f; margin-bottom: 10px; }
table { width: 100%; border-collapse: collapse; }
th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
th { background: #f4f4f4; }
.col-act { width: 150px; text-align: center; vertical-align: middle; white-space: nowrap; }
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

<div class="ql-wrap">
    <h2>Quản lý bài học</h2>

    <?php if (isset($_GET['ok'])): ?>
    <div class="msg-ok">Đã lưu thành công.</div>
    <?php elseif (isset($_GET['err'])): ?>
    <div class="msg-err">
        <?= $_GET['err']==='ext' ? 'Định dạng file không hợp lệ. Chỉ chấp nhận: mp4, webm, ogg, mov, avi.' : 'Upload thất bại, kiểm tra quyền ghi thư mục.' ?>
    </div>
    <?php endif; ?>

    <?php if (count($lophoc_arr) === 0): ?>
    <div class="empty-state">
        Chưa có lớp học nào. <a href="quanlylophoc.php">Thêm lớp học tại đây.</a>
    </div>
    <?php else: ?>

    <!-- TABS -->
    <div class="tabs">
        <a href="?tab=video&lop=<?= $lop_id ?>&day=<?= $day_id ?>"  class="tab-btn <?= $tab==='video' ?'active':'' ?>">Video</a>
        <a href="?tab=tuvung&lop=<?= $lop_id ?>&day=<?= $day_id ?>" class="tab-btn <?= $tab==='tuvung'?'active':'' ?>">Từ vựng</a>
        <a href="?tab=ontap&lop=<?= $lop_id ?>&day=<?= $day_id ?>"  class="tab-btn <?= $tab==='ontap' ?'active':'' ?>">Ôn tập</a>
    </div>

    <!-- CHỌN LỚP -->
    <div class="section-label">Lớp học</div>
    <div class="lop-bar">
        <?php foreach ($lophoc_arr as $lop): ?>
        <a href="?tab=<?= $tab ?>&lop=<?= $lop['id'] ?>&day=0"
           class="lop-btn <?= (int)$lop['id']===$lop_id?'active':'' ?>">
            <?= htmlspecialchars($lop['ten_lop']) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- CHỌN DAY -->
    <?php if (count($days_arr) === 0): ?>
    <div class="empty-state" style="padding:16px;">
        Lớp này chưa có day nào. <a href="quanlylophoc.php">Thêm day tại đây.</a>
    </div>
    <?php else: ?>
    <div class="section-label">Day</div>
    <div class="day-bar">
        <?php foreach ($days_arr as $d): ?>
        <a href="?tab=<?= $tab ?>&lop=<?= $lop_id ?>&day=<?= $d['id'] ?>"
           class="day-btn <?= (int)$d['id']===$day_id?'active':'' ?>">
            <?= htmlspecialchars($d['ten_day']) ?>
        </a>
        <?php endforeach; ?>
    </div>


    <!-- ══ TAB VIDEO ══════════════════════════════════════════════ -->
    <?php if ($tab === 'video'): ?>
    <div class="card">
        <h3>Video - <?= htmlspecialchars($lop_row['ten_lop'] ?? '') ?> / <?= htmlspecialchars($day_row['ten_day'] ?? '') ?></h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="day_id" value="<?= $day_id ?>">
            <input type="hidden" name="lop_id" value="<?= $lop_id ?>">
            <div class="card-row" style="margin-bottom:12px;">
                <label>Tên file video:</label>
                <input type="text" name="ten_video" class="inp-lg"
                       value="<?= htmlspecialchars($video_row['ten_video'] ?? 'vd'.$day_id.'.mp4') ?>"
                       placeholder="vd1.mp4">
            </div>
            <div class="card-row" style="margin-bottom:12px;">
                <label>Hoặc upload file:</label>
                <input type="file" name="file_video" accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-msvideo">
            </div>
            <p style="color:#888;font-size:13px;margin-bottom:12px;">Nếu chọn file upload, tên file sẽ tự động đặt thành <code>vd<?= $day_id ?>.mp4</code> (hoặc đuôi tương ứng).</p>
            <button type="submit" name="luu_video" class="btn btn-save">Lưu</button>
        </form>
    </div>

    <!-- ══ TAB TỪ VỰNG ══════════════════════════════════════════ -->
    <?php elseif ($tab === 'tuvung'): ?>
    <details>
        <summary>+ Thêm từ vựng mới cho <?= htmlspecialchars($day_row['ten_day'] ?? '') ?></summary>
        <form method="post" class="card" style="margin-top:10px;">
            <input type="hidden" name="day_id" value="<?= $day_id ?>">
            <input type="hidden" name="lop_id" value="<?= $lop_id ?>">
            <div class="card-row">
                <input type="text" name="hanzi"  class="inp-sm" placeholder="Hán tự" required>
                <input type="text" name="pinyin" class="inp-md" placeholder="Pinyin" required>
                <input type="text" name="nghia"  class="inp-lg" placeholder="Nghĩa tiếng Việt" required>
                <button type="submit" name="them_tuvung" class="btn btn-add">Thêm</button>
            </div>
        </form>
    </details>

    <table style="margin-top:16px;">
        <thead><tr><th>Hán tự</th><th>Pinyin</th><th>Nghĩa</th><th class="col-act">Hành động</th></tr></thead>
        <tbody>
        <?php while ($r = mysqli_fetch_assoc($tuvung_list)): ?>
        <tr>
            <form method="post">
            <input type="hidden" name="id"     value="<?= $r['id'] ?>">
            <input type="hidden" name="day_id" value="<?= $day_id ?>">
            <input type="hidden" name="lop_id" value="<?= $lop_id ?>">
            <td><input type="text" name="hanzi"  value="<?= htmlspecialchars($r['hanzi'])  ?>" class="inp-sm" required></td>
            <td><input type="text" name="pinyin" value="<?= htmlspecialchars($r['pinyin']) ?>" class="inp-md" required></td>
            <td><input type="text" name="nghia"  value="<?= htmlspecialchars($r['nghia'])  ?>" style="width:100%" required></td>
            <td class="col-act">
                <div style="display:flex;gap:6px;justify-content:center;">
                    <button type="submit" name="sua_tuvung" class="btn btn-save">Lưu</button>
                    <button type="submit" name="xoa_tuvung" class="btn btn-del" onclick="return confirm('Xóa từ này?')">Xóa</button>
                </div>
            </td>
            </form>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- ══ TAB ÔN TẬP ═══════════════════════════════════════════ -->
    <?php elseif ($tab === 'ontap'): ?>
    <details>
        <summary>+ Thêm câu hỏi mới cho <?= htmlspecialchars($day_row['ten_day'] ?? '') ?></summary>
        <form method="post" class="card" style="margin-top:10px;">
            <input type="hidden" name="day_id" value="<?= $day_id ?>">
            <input type="hidden" name="lop_id" value="<?= $lop_id ?>">
            <div style="display:flex;flex-direction:column;gap:10px;">
                <input type="text" name="cau_hoi" placeholder="Câu hỏi" style="width:100%" required>
                <div class="card-row">
                    <span style="font-weight:bold;">A.</span>
                    <input type="text" name="dap_an_a" class="inp-lg" placeholder="Đáp án A" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">B.</span>
                    <input type="text" name="dap_an_b" class="inp-lg" placeholder="Đáp án B" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">C.</span>
                    <input type="text" name="dap_an_c" class="inp-lg" placeholder="Đáp án C" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">D.</span>
                    <input type="text" name="dap_an_d" class="inp-lg" placeholder="Đáp án D" required>
                </div>
                <div class="card-row">
                    <label>Đáp án đúng:</label>
                    <select name="dap_an_dung">
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                    <button type="submit" name="them_ontap" class="btn btn-add">Thêm</button>
                </div>
            </div>
        </form>
    </details>

    <?php $stt = 1; while ($r = mysqli_fetch_assoc($ontap_list)): ?>
    <div class="card" style="margin-top:12px;">
        <form method="post">
            <input type="hidden" name="id"     value="<?= $r['id'] ?>">
            <input type="hidden" name="day_id" value="<?= $day_id ?>">
            <input type="hidden" name="lop_id" value="<?= $lop_id ?>">
            <div style="display:flex;flex-direction:column;gap:8px;">
                <div class="card-row">
                    <strong>Câu <?= $stt++ ?>:</strong>
                    <input type="text" name="cau_hoi" value="<?= htmlspecialchars($r['cau_hoi']) ?>" class="inp-lg" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">A.</span>
                    <input type="text" name="dap_an_a" value="<?= htmlspecialchars($r['dap_an_a']) ?>" class="inp-lg" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">B.</span>
                    <input type="text" name="dap_an_b" value="<?= htmlspecialchars($r['dap_an_b']) ?>" class="inp-lg" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">C.</span>
                    <input type="text" name="dap_an_c" value="<?= htmlspecialchars($r['dap_an_c'] ?? '') ?>" class="inp-lg" required>
                </div>
                <div class="card-row">
                    <span style="font-weight:bold;">D.</span>
                    <input type="text" name="dap_an_d" value="<?= htmlspecialchars($r['dap_an_d'] ?? '') ?>" class="inp-lg" required>
                </div>
                <div class="card-row">
                    <label>Đáp án đúng:</label>
                    <select name="dap_an_dung">
                        <option value="a" <?= $r['dap_an_dung']==='a'?'selected':'' ?>>A</option>
                        <option value="b" <?= $r['dap_an_dung']==='b'?'selected':'' ?>>B</option>
                        <option value="c" <?= $r['dap_an_dung']==='c'?'selected':'' ?>>C</option>
                        <option value="d" <?= $r['dap_an_dung']==='d'?'selected':'' ?>>D</option>
                    </select>
                    <button type="submit" name="sua_ontap" class="btn btn-save">Lưu</button>
                    <button type="submit" name="xoa_ontap" class="btn btn-del" onclick="return confirm('Xóa câu hỏi này?')">Xóa</button>
                </div>
            </div>
        </form>
    </div>
    <?php endwhile; ?>

    <?php endif; ?>
    <?php endif; // days_arr ?>
    <?php endif; // lophoc_arr ?>
</div>

</body>
</html>
