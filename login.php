<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>เข้าสู่ระบบผัก</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>เว็บผัก</p>
        <a href="index.html">หน้าหลัก</a>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php
            include "config.php";
            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $result = mysqli_query($con, "SELECT * FROM users WHERE email = '$email' AND password = '$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);
                if (is_array($row) && !empty($row)) {
                    $_SESSION['valid'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['weight'] = $row['weight'];
                    $_SESSION['gender'] = $row['gender'];
                    $_SESSION['likemenu'] = $row['likemenu'];
                    $_SESSION['unlikeingred'] = $row['unlikeingred'];
                    $_SESSION['calorie'] = $row['calorie'];
                    $_SESSION['id'] = $row['ID'];
                } else {
                    echo "<div class='message_error'>
                     <p>ชื่อหรือรหัสผ่านผิด ลองใส่ใหม่นะค่ะ</p>
                      </div> <br>";
                    echo "<a href='login.php'><button class='btn'>กลับไปเริ่มต้นใหม่</button>";
                }
                if (isset($_SESSION['valid'])) {
                    header("Location: home.php");
                }
            } else {
                ?>
                <header>เข้าสู่ระบบผัก</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">อีเมลของคุณ</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="password">รหัสผ่าน</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        ยังไม่ได้เป็นสมาชิกผักสีเขียวหรอ? <a href="register.php">สมัครทันที!</a>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>