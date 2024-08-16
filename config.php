<?php
// กำหนดค่าการเชื่อมต่อฐานข้อมูลของเว็บผักห่วย
$host = 'localhost'; // หรือที่อยู่ของเซิร์ฟเวอร์ฐานข้อมูลของผัก
$dbname = 'vegetable'; // ชื่อฐานข้อมูล
$username = 'root'; // ชื่อผู้ใช้ฐานข้อมูล
$password = ''; // รหัสผ่านฐานข้อมูล
// สร้างการเชื่อมต่อฐานข้อมูลผักห่วย
$con = mysqli_connect($host, $username, $password, $dbname);
// ตรวจสอบการเชื่อมต่อห่วย
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>