<?php
session_start();
if (!isset($_SESSION['user'])) { header("location: login.php"); exit(); }

$conn = mysqli_connect("localhost","root","","login_db");
mysqli_set_charset($conn,"utf8mb4");

$day_id = isset($_GET['day']) ? (int)$_GET['day'] : null;
$lop_id = isset($_GET['lop']) ? (int)$_GET['lop'] : 0;

$current_quiz = null;
if ($day_id >= 1) {
    $res = mysqli_query($conn, "SELECT * FROM ontap WHERE day_id=$day_id ORDER BY id");
    $questions = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $questions[] = ['q'=>$r['cau_hoi'],'a'=>$r['dap_an_a'],'b'=>$r['dap_an_b'],'c'=>$r['dap_an_c'],'d'=>$r['dap_an_d'],'ans'=>$r['dap_an_dung']];
    }
    $day_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ten_day, day_number FROM ngayHoc WHERE id=$day_id"));
    $title = $day_info ? $day_info['ten_day'] : "Day $day_id";
    $current_quiz = ['title' => $title, 'questions' => $questions];
}
mysqli_close($conn);
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $current_quiz ? $current_quiz['title'] : 'Chọn Ngày Ôn Tập - Hán ngữ HW'; ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; background: #fffafb; color: #333; }
        a { text-decoration: none; color: inherit; }
        .container { width: min(1000px, calc(100% - 48px)); margin: 0 auto; padding: 50px 0; }

        /* CSS cho Trang Quiz */
        .quiz-container { max-width: 650px; margin: 0 auto; background: #fff; padding: 40px; border-radius: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); position: relative; }
        .question { margin-bottom: 20px; padding: 20px; border: 1px solid #f0f0f0; border-radius: 15px; text-align: left; }
        .options { margin-top: 10px; line-height: 2.5; }
        .btn-submit { background: #000; color: #fff; border: none; padding: 18px; border-radius: 12px; width: 100%; cursor: pointer; font-weight: bold; font-size: 18px; margin-top: 20px; }
        .back-link { color: #d64a2f; font-weight: bold; display: inline-block; margin-bottom: 20px; }
        #score-badge { position: absolute; top: 20px; right: 20px; background: #d64a2f; color: #fff; padding: 10px 20px; border-radius: 50px; font-weight: bold; display: none; }
        .correct-ans { border-color: #2ecc71; background: #fafffb; }
        .wrong-ans { border-color: #e74c3c; background: #fffaf9; }
    </style>
</head>
<body>

<div class="container">
        <div class="quiz-container">
            <a href="ngayhoc.php?lop_id=<?php echo $lop_id; ?>&day=<?php echo $day_id; ?>" class="back-link">← Quay lại</a>
            
            <div id="score-badge">Đúng: <span id="score-val">0</span>/<?php echo count($current_quiz['questions']); ?></div>

            <h1 style="color: #d64a2f; text-align: center;"><?php echo $current_quiz['title']; ?></h1>

            <form id="quiz-form">
                <?php foreach ($current_quiz['questions'] as $index => $item): ?>
                    <div class="question" id="qbox-<?php echo $index; ?>" data-answer="<?php echo $item['ans']; ?>">
                        <p><strong>Câu <?php echo $index + 1; ?>:</strong> <?php echo $item['q']; ?></p>
                        <div class="options">
                            <label><input type="radio" name="q<?php echo $index; ?>" value="a"> A. <?php echo $item['a']; ?></label><br>
                            <label><input type="radio" name="q<?php echo $index; ?>" value="b"> B. <?php echo $item['b']; ?></label><br>
                            <label><input type="radio" name="q<?php echo $index; ?>" value="c"> C. <?php echo $item['c']; ?></label><br>
                            <label><input type="radio" name="q<?php echo $index; ?>" value="d"> D. <?php echo $item['d']; ?></label>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="button" onclick="checkQuiz()" class="btn-submit">Nộp bài và kiểm tra</button>
            </form>
        </div>

        <script>
        function checkQuiz() {
            let score = 0;
            const questions = document.querySelectorAll('.question');

            questions.forEach((q, index) => {
                const correctAns = q.getAttribute('data-answer');
                const selected = document.querySelector(`input[name="q${index}"]:checked`);
                
                q.classList.remove('correct-ans', 'wrong-ans');

                if (selected && selected.value === correctAns) {
                    score++;
                    q.classList.add('correct-ans');
                } else {
                    q.classList.add('wrong-ans');
                }
            });

            const badge = document.getElementById('score-badge');
            document.getElementById('score-val').innerText = score;
            badge.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        </script>

</div>

</body>
</html>
