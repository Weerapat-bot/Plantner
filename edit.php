<?php
session_start();
include "config.php";
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>เปลี่ยนข้อมูลผัก</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>เว็บผัก</p>
        <div class="right-links">
            <a href="edit.php"> <button class="btn">เปลี่ยนทันที</button> </a>
            <a href="logout.php"> <button class="btn">ออกจากระบบผัก</button> </a>
        </div>
        <a href="home.php">กลับ</a>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $weight = $_POST['weight'];
        $gender = $_POST['gender'];
        $likemenu = $_POST['likemenu'];
        $unlikeingred = $_POST['unlikeingred'];
        $calories = $_POST["calories"];
        $carbohydrate_MIN = $_POST['carbohydrate_MIN'];
        $carbohydrate_MAX = $_POST['carbohydrate_MAX'];
        $protien_MIN = $_POST['protien_MIN'];
        $protien_MAX = $_POST['protien_MAX'];
        $fat_MIN = $_POST['fat_MIN'];
        $fat_MAX = $_POST['fat_MAX'];
        $id = $_SESSION['id'];
        $edit_query = mysqli_query($con, "UPDATE users SET username = '$username', email = '$email', weight = '$weight', gender = '$gender', likemenu = '$likemenu', unlikeingred = '$unlikeingred', calories = '$calories', carbohydrate_MIN = '$carbohydrate_MIN', carbohydrate_MAX = '$carbohydrate_MAX', protein_MIN = '$protien_MIN', protein_MAX = '$protien_MAX', fat_MIN = '$fat_MIN', fat_MAX = '$fat_MAX' WHERE ID = $id") or die("Error!");
        if ($edit_query) {
            echo "<div class='message'><p>ข้อมูลถูกเปลี่ยน!</p></div><br>
            <div class='main-box'>
                    <div class='top'>
                        <div class='box'>
                            <p>สวัสดีค่ะ! <b> $username </b>, ยินดีต้อนรับ</p>
                            <p>นี่คือ <b> $email </b></p>
                            <p>คุณหนัก <b> $weight </b> กิโลกรัม</p>
                            <p>คุณเป็น<b> $gender</b></p>
                            <p>คุณชอบ<b> $likemenu </b></p>
                            <p>คุณเกลียด<b> $unlikeingred </b></p>
                            <p>แคลอรี่ของคุณก็คือ <b>$calories </b> กิโลแคลอรี่</p>
                        </div>
                    </div>
                    <a href='match.php'> <button class='btn'>Match</button> </a>
            </div>";
        }
    } else {
        $id = $_SESSION['id'];
        $query = mysqli_query($con, "SELECT * FROM users WHERE ID = $id");
        while ($result = mysqli_fetch_assoc($query)) {
            $res_username = $result['username'];
            $res_email = $result['email'];
            $res_weight = $result['weight'];
            $res_gender = $result['gender'];
            $res_likemunu = $result['likemenu'];
            $res_unlikeingred = $result['unlikeingred'];
        }
        ?>
        <div class="container">
            <div class="box form-box">
                <header>เปลี่ยนข้อมูลผัก</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">ชื่อ ชั้น เลขที่</label>
                        <input type="text" name="username" id="username" value="<?php echo $res_username; ?>"
                            autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="email">อีเมล</label>
                        <input type="text" name="email" id="email" value="<?php echo $res_email; ?>" autocomplete="off"
                            required>
                    </div>
                    <div class="weight input">
                        <label for="weight">น้ำหนักแบบกิโลกรัม</label>
                        <input type="number" name="weight" id="weight" value="<?php echo $res_weight; ?>" autocomplete="off"
                            required>
                    </div>
                    <div class="gender">
                        <div class="head">
                            <label for="gender">เพศ</label>
                        </div>
                        <select class="field input " name="gender" id="genderSelect" value="<?php echo $res_gender; ?>"
                            autocomplete="off" required>
                            <option value="male">ชาย</option>
                            <option value="female">หนิง</option>
                        </select>
                    </div>
                    <div class="field input">
                        <label for="likemenu">เมนูที่ชอบกินทุกวัน</label>
                        <input type="text" name="likemenu" id="likemenu" value="<?php echo $res_likemunu; ?>"
                            autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="unlikeingredient">วัตถุดิบที่แพ้</label>
                        <input type="text" name="unlikeingred" id="unlikeingred" value="<?php echo $res_unlikeingred; ?>"
                            autocomplete="off" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Update" required>
                    </div>
                </form>
            </div>
        <?php } ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var form = document.querySelector("form");
            form.addEventListener("submit", function (event) {
                var weight = document.getElementById("weight");
                var gender = document.querySelector('#genderSelect');
                if (!gender) {
                    event.preventDefault();
                    return;
                }
                var calories = 0;
                if (gender.value === "male") {
                    calories = weight.value * 31;
                } else if (gender.value === "female") {
                    calories = weight.value * 27;
                } else {
                    event.preventDefault();
                    return;
                }
                var carbohydrate_MIN = 0.45 * calories;
                var carbohydrate_MAX = 0.65 * calories;
                var protien_MIN = 0.2 * calories;
                var protien_MAX = 0.35 * calories;
                var fat_MIN = 0.1 * calories;
                var fat_MAX = 0.15 * calories;
                var caloriesInput = document.createElement("input");
                caloriesInput.type = "hidden";
                caloriesInput.name = "calories";
                caloriesInput.value = calories;
                form.appendChild(caloriesInput);
                var carbohydrate_MINInput = document.createElement("input");
                carbohydrate_MINInput.type = "hidden";
                carbohydrate_MINInput.name = "carbohydrate_MIN";
                carbohydrate_MINInput.value = carbohydrate_MIN;
                form.appendChild(carbohydrate_MINInput);
                var carbohydrate_MAXInput = document.createElement("input");
                carbohydrate_MAXInput.type = "hidden";
                carbohydrate_MAXInput.name = "carbohydrate_MAX";
                carbohydrate_MAXInput.value = carbohydrate_MAX;
                form.appendChild(carbohydrate_MAXInput);
                var protien_MINInput = document.createElement("input");
                protien_MINInput.type = "hidden";
                protien_MINInput.name = "protien_MIN";
                protien_MINInput.value = protien_MIN;
                form.appendChild(protien_MINInput);
                var protien_MAXInput = document.createElement("input");
                protien_MAXInput.type = "hidden";
                protien_MAXInput.name = "protien_MAX";
                protien_MAXInput.value = protien_MAX;
                form.appendChild(protien_MAXInput);
                var fat_MINInput = document.createElement("input");
                fat_MINInput.type = "hidden";
                fat_MINInput.name = "fat_MIN";
                fat_MINInput.value = fat_MIN;
                form.appendChild(fat_MINInput);
                var fat_MAXInput = document.createElement("input");
                fat_MAXInput.type = "hidden";
                fat_MAXInput.name = "fat_MAX";
                fat_MAXInput.value = fat_MAX;
                form.appendChild(fat_MAXInput);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "register.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    }
                };
                xhr.send("calories=" + calories);
                xhr.send("carbohydrate_MIN=" + carbohydrate_MIN);
                xhr.send("carbohydrate_MAX=" + carbohydrate_MAX);
                xhr.send("protien_MIN=" + protien_MIN);
                xhr.send("protien_MAX=" + protien_MAX);
                xhr.send("fat_MIN=" + fat_MIN);
                xhr.send("fat_MAX=" + fat_MAX);
            });
        });
    </script>
</body>
</html>