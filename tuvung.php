    <?php
    session_start();
    if (!isset($_SESSION['user'])) { header("location: login.php"); exit(); }
    $current_day = isset($_GET['day']) ? (int)$_GET['day'] : 1;
    $lop_id = isset($_GET['lop']) ? (int)$_GET['lop'] : 0;

    $conn = mysqli_connect("localhost","root","","login_db");
    mysqli_set_charset($conn,"utf8mb4");
    $day_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT day_number FROM ngayHoc WHERE id=$current_day"));
    $day_number_display = $day_info ? $day_info['day_number'] : $current_day;
    $res = mysqli_query($conn, "SELECT * FROM tuvung WHERE day_id=$current_day ORDER BY id");
    $cards_db = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $cards_db[] = ['h' => $r['hanzi'], 'p' => $r['pinyin'], 'n' => $r['nghia']];
    }
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>Từ vựng HSK 2 - Day <?php echo $day_number_display; ?></title>
        <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    .main {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px 60px;
    }
    .page-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }
    .progress-bar-wrap {
        background: #eee;
        border-radius: 999px;
        height: 6px;
        margin-bottom: 8px;
    }
    .progress-bar {
        height: 100%;
        background: #d64a2f;
        border-radius: inherit;
        transition: 0.3s;
    }
    .progress-text {
        text-align: center;
        font-size: 13px;
        color: #888;
        margin-bottom: 24px;
    }
    .scene {
        max-width: 460px;
        height: 260px;
        margin: 0 auto 28px;
        perspective: 1200px;
        cursor: pointer;
    }
    .flashcard {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 0.55s cubic-bezier(.4,0,.2,1);
    }
    .flashcard.flipped {
        transform: rotateY(180deg);
    }
    .face {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.09);
        backface-visibility: hidden;
    }
    .front {
        background: #fff;
        border: 2px solid #f0e8e8;
    }
    .back {
        background: #fff7f5;
        border: 2px solid #f0c4b8;
        transform: rotateY(180deg);
    }
    .hanzi-big { font-size: 72px; color: #d64a2f; }
    .hanzi-sm { font-size: 38px; color: #d64a2f; }

    .pinyin { font-size: 22px; color: #555; }
    .nghia { font-size: 20px; font-weight: 600; color: #222; }

    .hint {
        font-size: 12px;
        color: #bbb;
    }
    .controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }
    .btn-nav {
        padding: 10px 28px;
        border-radius: 10px;
        border: 1.5px solid #ddd;
        background: #fff;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-nav:hover:not(:disabled) {
        background: #d64a2f;
        color: #fff;
        border-color: #d64a2f;
    }
    .btn-nav:disabled {
        opacity: 0.3;
        cursor: default;
    }
    .count-badge {
        min-width: 70px;
        text-align: center;
        font-size: 14px;
        color: #888;
    }
    .btn-back {
        display: inline-block;
        background: #e0cb0e;
        color: #fff;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 14px;
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

    <main class="main">
        <div class="page-title"> Từ vựng HSK  - Day <?php echo $day_number_display; ?></div>

        <div class="progress-bar-wrap">
            <div class="progress-bar" id="pbar"></div>
        </div>
        <div class="progress-text" id="ptext"></div>

        <div class="scene" onclick="flipCard()">
            <div class="flashcard" id="card">
                <div class="face front">
                    <div class="hanzi-big" id="hanzi"></div>
                    <div class="hint">Bấm để xem nghĩa ↓</div>
                </div>
                <div class="face back">
                    <div class="hanzi-sm" id="hanzi2"></div>
                    <div class="pinyin" id="pinyin"></div>
                    <div class="nghia" id="nghia"></div>
                </div>
            </div>
        </div>

        <div class="controls">
            <button class="btn-nav" id="btn-prev" onclick="prev()">← Trước</button>
            <span class="count-badge" id="count"></span>
            <button class="btn-nav" id="btn-next" onclick="next()">Tiếp →</button>
        </div>
        <div style="text-align:center; margin-top:10px;">
            <a href="ngayhoc.php?lop_id=<?php echo $lop_id; ?>&day=<?php echo $current_day; ?>" class="btn-back">← Quay lại Day <?php echo $day_number_display; ?></a>
        </div>

    </main>

    <script>
    const cards = <?php echo json_encode($cards_db, JSON_UNESCAPED_UNICODE); ?>;
    let idx = 0;

    function render() {
        const c = cards[idx];
        document.getElementById('hanzi').textContent = c.h;
        document.getElementById('hanzi2').textContent = c.h;
        document.getElementById('pinyin').textContent = c.p;
        document.getElementById('nghia').textContent = c.n;
        document.getElementById('count').textContent = (idx+1) + ' / ' + cards.length;
        document.getElementById('ptext').textContent = 'Day <?php echo $day_number_display; ?> · Thẻ ' + (idx+1) + ' / ' + cards.length;
        document.getElementById('pbar').style.width = ((idx+1)/cards.length*100) + '%';
        document.getElementById('btn-prev').disabled = idx === 0;
        document.getElementById('btn-next').disabled = idx === cards.length - 1;
        document.getElementById('card').classList.remove('flipped');
    }


    function flipCard() {
        document.getElementById('card').classList.toggle('flipped');
    }

    function next() { if(idx < cards.length-1) { idx++; render(); } }
    function prev() { if(idx > 0) { idx--; render();  } }

    render();
    </script>

    </body>
    </html>
