<?php
session_start();
    $message = "";
    global $conn;
    function connection_db(){
    global $conn;
    if(!$conn){
        $conn = mysqli_connect("localhost","root","","login_db") or die ("khong the ket noi toi co so du lieu");
    }
    mysqli_set_charset($conn,"utf8mb4");
    return $conn;
    }
    connection_db();

    if(isset($_POST['login'])){
        $tk = $_POST['taikhoan'];
        $mk = $_POST['matkhau'];

        $sql = "SELECT * FROM users WHERE username='$tk' AND password='$mk'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
        $message = "Đăng nhập thành công";
          $_SESSION['user'] = $tk; // LƯU SESSIONs
        header("location: home.php");
        } else {
        $message = "Sai tài khoản hoặc mật khẩu";
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
          <link rel="stylesheet" href="style.css">
        <style>
            .container1 {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px 20px;
                gap: 60px;
            }

            img {
                height: 600px;
                width: 650px;
                object-fit: cover;
                border-radius: 16px;
                display: block;
            }

            .loginbox {
                font-size: 18px;
                width: 480px;
                padding: 40px 50px;
                background: #ffffff;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                text-align: center;
            }

            h1 {
                text-align: center;
                font-size: 36px;
                margin-bottom: 30px;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 18px;
                margin-bottom: 6px;
                font-weight: 600;
            }

            input[type="text"],
            input[type="password"] {
                width: 100%;
                height: 44px;
                padding: 8px 12px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 18px;
                box-sizing: border-box;
            }

            input[type="submit"] {
                width: 100%;
                height: 48px;
                font-size: 20px;
                margin-top: 30px;
                border-radius: 8px;
                border: 1px solid #ccc;
                background: #f0f0f0;
                cursor: pointer;
                transition: background 0.2s;
            }

            input[type="submit"]:hover {
                background: #222;
                color: #fff;
            }

            .forgot-link {
                display: block;
                margin-top: 16px;
                font-size: 16px;
                color: #555;
                text-align: center;
            }

            a {
                text-decoration: none;
                color: inherit;
            }

            .logo-text span {
                font-size: 12px;
                color: #666;
            }
        </style>
    </head>
    <body>
              <header class="topbar">
      <div class="container navbar">
        <div class="logo">
          <div  class="logo-icon"><a href="home.php">汉</a></div>
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
          <a href="login.php" class="btn-login">Đăng nhập</a>
        </nav>
      </div>
    </header>
        <div class="container1">
            <img src="a.png">
            <div class="loginbox">
                <h1>Đăng nhập</h1>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label>Tài khoản:</label>
                        <input type="text" name="taikhoan">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu:</label>
                        <input type="password" name="matkhau">
                    </div>
                    <input type="submit" name="login" value="Đăng nhập">
                    <a class="forgot-link" href="quenmatkhau.php">Quên mật khẩu?</a>
                    <p style="color:red; text-align:center; margin-top:12px;"><?= $message ?></p>
                </form>
            </div>
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
