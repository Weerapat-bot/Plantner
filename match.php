<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="match.css">
    <title>ผักขม</title>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png">
        <p>เว็บผัก</p>
        <a href="edit.php" id="profile">ข้อมูลของคุณ</a>
        <a href="logout.php" id="log-out">ออกจากผัก</a>
        <a href="home.php" id='home'>หน้าหลัก</a>
    </div>
    <?php
    include "config.php";
    $id = $_SESSION['id'];
    $user_sql = "SELECT ID, username, likemenu, unlikeingred FROM users WHERE ID = '$id'";
    $user_result = $con->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $menu_sql = "SELECT * FROM menu";
    $menu_result = $con->query($menu_sql);
    $menu_row = $menu_result->fetch_assoc();
    $userCaloriesSql = "SELECT calories FROM users WHERE ID = '$id'";
    $userCaloriesResult = $con->query($userCaloriesSql);
    $userCaloriesRow = $userCaloriesResult->fetch_assoc();
    $userCalories = $userCaloriesRow['calories'];
    $userCarboMINSql = "SELECT carbohydrate_MIN FROM users WHERE ID = '$id'";
    $userCarboMINResult = $con->query($userCarboMINSql);
    $userCarboMINRow = $userCarboMINResult->fetch_assoc();
    $userCarboMIN = $userCarboMINRow['carbohydrate_MIN'];
    $userCarboMAXSql = "SELECT carbohydrate_MAX FROM users WHERE ID = '$id'";
    $userCarboMAXResult = $con->query($userCarboMAXSql);
    $userCarboMAXRow = $userCarboMAXResult->fetch_assoc();
    $userCarboMAX = $userCarboMAXRow['carbohydrate_MAX'];
    $userProteinMINSql = "SELECT protein_MIN FROM users WHERE ID = '$id'";
    $userProteinMINResult = $con->query($userProteinMINSql);
    $userProteinMINRow = $userProteinMINResult->fetch_assoc();
    $userProteinMIN = $userProteinMINRow['protein_MIN'];
    $userProteinMAXSql = "SELECT protein_MAX FROM users WHERE ID = '$id'";
    $userProteinMAXResult = $con->query($userProteinMAXSql);
    $userProteinMAXRow = $userProteinMAXResult->fetch_assoc();
    $userProteinMAX = $userProteinMAXRow['protein_MAX'];
    $userFatMINSql = "SELECT fat_MIN FROM users WHERE ID = '$id'";
    $userFatMINResult = $con->query($userFatMINSql);
    $userFatMINRow = $userFatMINResult->fetch_assoc();
    $userFatMIN = $userFatMINRow['fat_MIN'];
    $userFatMAXSql = "SELECT fat_MAX FROM users WHERE ID = '$id'";
    $userFatMAXResult = $con->query($userFatMAXSql);
    $userFatMAXRow = $userFatMAXResult->fetch_assoc();
    $userFatMAX = $userFatMAXRow['fat_MAX'];
    $likemenu = $user_row['likemenu'];
    $likemenu_sql = "SELECT * FROM menu WHERE name = '$likemenu'";
    $likemenu_result = $con->query($likemenu_sql);
    $likemenu_row = $likemenu_result->fetch_assoc();
    $likemenuProbability = 70;
    if ($likemenu_row && mt_rand(1, 100) <= $likemenuProbability) {
        $menu[] = $likemenu_row;
    }
    $unlikeingred = $user_row['unlikeingred'];
    $unlikeingred_sql = "SELECT * FROM ingredient WHERE name LIKE '%$unlikeingred%'";
    $unlikeingred_result = $con->query($unlikeingred_sql);
    if ($unlikeingred_result) {
        $menuIdsToRemove = array();
        while ($unlikeingred_row = $unlikeingred_result->fetch_assoc()) {
            $selectingred = $unlikeingred_row['name'];
            $selectingred_sql = "SELECT * FROM menu_ingredient WHERE name LIKE '%$selectingred%'";
            $selectingred_result = $con->query($selectingred_sql);
            if ($selectingred_result) {
                while ($selectingred_row = $selectingred_result->fetch_assoc()) {
                    $menuIdsToRemove[] = $selectingred_row['ID'];
                }
            }
        }
        if ($menuIdsToRemove) {
            $randmenu_sql = 'SELECT * FROM menu WHERE ID NOT IN (" . implode(", ", $menuIdsToRemove) . ") ORDER BY RAND() LIMIT 3';
        } else {
            $randmenu_sql = "SELECT * FROM menu ORDER BY RAND() LIMIT 3";
        }
        $randmenu_result = $con->query($randmenu_sql);
        while ($randmenu_row = $randmenu_result->fetch_assoc()) {
            $menu[] = $randmenu_row;
        }
        shuffle($menu);
        $totalCarbohydrate = 0;
        $totalCalories = 0;
        $totalCarbo = 0;
        $totalProtein = 0;
        $totalFat = 0;
        foreach ($menu as $myArray) {
            $totalCalories += $myArray["calories"];
            $totalCarbohydrate += $myArray["carbohydrate"];
            $totalProtein += $myArray["protein"];
            $totalFat += $myArray["fat"];
        }
        $threshold = 600;
        if (abs($totalCalories - $userCalories) <= $threshold) {
            // if (!
            //     ($userCarboMIN <= $totalCarbo || $totalCarbo <= $userCarboMAX) ||
            //     ($userProteinMIN <= $totalProtein || $totalProtein <= $userProteinMax) ||
            //     ($userFatMIN <= $totalFat || $totalFat <= $userFatMAX)
            // ) {
            //     header("Location: match.php");
            // }
        } else {
            header("Location: match.php");
        }
    } else {
        $menu = array();
        $randmenu_sql = "SELECT * FROM menu m LEFT JOIN menu_scores ms ON m.Id = ms.menu_id AND ms.user_id = '$userId' WHERE m.Id NOT IN (' . implode(',', $menuIdsToRemove) . ') AND RAND() <= IFNULL((ms.score / 10), 1) ORDER BY RAND() LIMIT 3";
        $randmenu_result = $con->query($randmenu_sql);
        while ($randmenu_row = $randmenu_result->fetch_assoc()) {
            $menu[] = $randmenu_row;
        }
        shuffle($menu);
        $totalCarbohydrate = 0;
        $totalCalories = 0;
        $totalCarbo = 0;
        $totalProtein = 0;
        $totalFat = 0;
        foreach ($menu as $myArray) {
            $totalCalories += $myArray["calories"];
            $totalCarbohydrate += $myArray["carbohydrate"];
            $totalProtein += $myArray["protein"];
            $totalFat += $myArray["fat"];
        }
        $threshold = 600;
        if (abs($totalCalories - $userCalories) <= $threshold) {
            // ผลรวมของ Calories ทั้ง 3 เมนูใกล้เคียงกับ Calories ของผู้ใช้ผักมากที่สุด
            // if (!
            //     ($userCarboMIN <= $totalCarbo || $totalCarbo <= $userCarboMAX) ||
            //     ($userProteinMIN <= $totalProtein || $totalProtein <= $userProteinMax) ||
            //     ($userFatMIN <= $totalFat || $totalFat <= $userFatMAX)
            // ) {
            //     header("Location: match.php");
            // }
        } else {
            header("Location: match.php");
        }
    }
    if (isset($_POST['match']) && ($_POST['match']) !== false) {
        $menuId = $_POST['match'];
        $userId = $_SESSION['id'];
        $score = 6;
        $checkExistingScoreSQL = "SELECT * FROM menu_scores WHERE userID = '$userId' AND menuID = '$menuId'";
        $existingScoreResult = $con->query($checkExistingScoreSQL);
        if ($existingScoreResult->num_rows > 0) {
            $updateScoreSQL = "UPDATE menu_scores SET score = IF(score = 1, '$score', GREATEST(score - 1, 0)) WHERE userID = '$userId' AND menuID = '$menuId'";
            $con->query($updateScoreSQL);
        } elseif ($existingScoreResult->num_rows == 0) {
            $insertScoreSQL = "INSERT INTO menu_scores (userID, menuID, score) VALUES ('$userId', '$menuId', '$score')";
            $con->query($insertScoreSQL);
        }
    }
    if (count($menu) > 0) {
        $breakfast = array_shift($menu);
        echo "<h1>ผักสำหรับมื้อเช้า</h1>";
        $breakfast_menu = " <div class='menubox' id='breakfast-menu-container'>
            <h2>เมนู: {$breakfast['name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$breakfast['ingredients']}<br>
            แคลอรี่: {$breakfast['calories']} กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$breakfast['carbohydrate']}กรัม<br>โปรตีน: {$breakfast['protein']}กรัม<br>ไขมัน: {$breakfast['fat']}กรัม<br>วิตามิน: {$breakfast['vitamin']}กรัม<br>โซเดียม: {$breakfast['sodium']}กรัม
            </div></div>
            <form method='post' id='breakfast-form'>
            <button type='button' name='match' value='{$breakfast['ID']}' class='breakfast-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='breakfast' class='no-button' id='no-breakfast'>ไม่กิน</button>
            </form><br>";
        echo $breakfast_menu;
        $lunch = array_shift($menu);
        echo "<h1>มื้อกลางวัน</h1>";
        $lunch_menu = "<div class='menubox' id='lunch-menu-container'>
            <h2>เมนู: {$lunch['name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$lunch['ingredients']}<br>
            แคลอรี่: {$lunch['calories']}กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$lunch['carbohydrate']}กรัม<br>โปรตีน: {$lunch['protein']}กรัม<br>ไขมัน: {$lunch['fat']}กรัม<br>วิตามิน: {$lunch['vitamin']}กรัม<br>โซเดียม: {$lunch['sodium']}กรัม
            </div></div>
            <form method='post' id='lunch-form'>
            <button type='button' name='match' value='{$lunch['ID']}' class='lunch-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='noMatch' class='no-button' id='no-lunch'>ไม่กิน</button>
            </form><br>";
        echo $lunch_menu;
        $dinner = array_shift($menu);
        echo "<h1>มื้อเย็น</h1>";
        $dinner_menu = "<div class='menubox' id='dinner-menu-container'>
            <h2>เมนู: {$dinner['name']}</h2>
            <div class='menuinfo'>วัตถุดิบ: {$dinner['ingredients']}<br>
            แคลอรี่: {$dinner['calories']}กิโลแคลอรี่<br>
            คาร์โบไฮเดรต: {$dinner['carbohydrate']}กรัม<br>โปรตีน: {$dinner['protein']}กรัม<br>ไขมัน: {$dinner['fat']}กรัม<br>วิตามิน: {$dinner['vitamin']}กรัม<br> โซเดียม: {$dinner['sodium']}กรัม
            </div></div>
            <form  method='post' id='dinner-form'>
            <button type='button' name='match' value='{$dinner['ID']}' class='dinner-button' id='yes-button'>กิน</button>
            <button type='button' name='noMatch' value='dinner' class='no-button' id='no-dinner'>ไม่กิน</button>
            </form>";
        echo $dinner_menu;
    } else {
        echo "ไม่เจอเมนูที่เหมาะกับคุณ ไปกินขี้ซะ ไอ้โง่";
    }
    if (isset($_POST['noMatch']) && $_POST['noMatch'] === 'breakfast') {
        $newRandmenu_sql = "SELECT * FROM menu ORDER BY RAND() LIMIT 1";
        $newRandmenu_result = $con->query($newRandmenu_sql);
        $newRandmenuRow = $newRandmenu_result->fetch_assoc();
        $menu = json_encode($newRandmenuRow);
        exit();
    }
    ?>
    <script src="match.js"></script>
</body>
</html>