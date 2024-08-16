<?php
session_start();
include "config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}
?>
<?php
$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE ID = $id");
while ($result = mysqli_fetch_assoc($query)) {
    $res_username = $result['username'];
    $res_email = $result['email'];
    $res_weight = $result['weight'];
    $res_gender = $result['gender'];
    $res_likemenu = $result['likemenu'];
    $res_unlikeingred = $result['unlikeingred'];
    $res_calories = $result['calories'];
    $res_id = $result['ID'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>หน้าหลัก</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>เว็บผัก</p>
        <div class="right-links">
            <a href="edit.php"> <button class="btn">เปลี่ยนข้อมูลของคุณตรงนี้</button> </a>
            <a href="logout.php"> <button class="btn">ออกจากระบบผัก</button> </a>
        </div>
        <a href="home.php">หน้าหลัก</a>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>สวัสดี! <b><?php echo $res_username ?></b>, ยินดีต้อนรับสู่ดินแดนผักเหม็นเขียว</p>
                    <p>อีเมลของคุณคือ <b><?php echo $res_email ?></b></p>
                    <p>คุณหนัก <b><?php echo $res_weight ?></b> กิโลแคลอรี่</p>
                    <p>คุณคือเพศ<b><?php echo $res_gender ?></b></p>
                    <p>คุณชอบกิน<b><?php echo $res_likemenu ?></b></p>
                    <p>คุณเกลียด<b><?php echo $res_unlikeingred ?></b>ที่สุด</p>
                    <p>แคลอรี่ของคุณตอนนี้ <b><?php echo $res_calories ?></b> กิโลกรัม</p>
                </div>
            </div>
            <a href="match.php"> <button class="btn">สุ่มเมนูผักแสนอร่อย</button> </a>
    </main>
</body>
</html>