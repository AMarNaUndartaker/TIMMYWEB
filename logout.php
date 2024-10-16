<?php
session_start();

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ฟังก์ชันบันทึกการใช้งานของผู้ใช้
function logUsage($userId, $startTime, $endTime) {
    global $conn;
    
    $sql = "INSERT INTO stats (user_id, start_time, end_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $startTime, $endTime);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        die("Error: " . $stmt->error);
    }
}

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    header("Location: Formlogin.html");
    exit();
}

// บันทึกการใช้งานเมื่อผู้ใช้ออกจากระบบ
if (isset($_SESSION['start_time'])) {
    $endTime = date('Y-m-d H:i:s'); // เก็บเวลาสิ้นสุด
    logUsage($_SESSION['user_id'], $_SESSION['start_time'], $endTime); // บันทึกข้อมูลการใช้งาน
}

// ลบค่า session และออกจากระบบ
unset($_SESSION['start_time']); // ลบ start_time ออกจาก session
session_destroy(); // สิ้นสุด session
header("Location: Formlogin.html"); // ไปยังหน้า login
exit();
?>
