<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy"; // ชื่อฐานข้อมูล

function logUsage($userId, $startTime, $endTime) {
    global $servername, $username, $password, $dbname;

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO stats (user_id, start_time, end_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $startTime, $endTime);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
}

// ตัวอย่างการเรียกใช้งานฟังก์ชัน
$userId = 1; // ID ของผู้ใช้
$startTime = date('Y-m-d H:i:s'); // เวลาที่เริ่มต้น
// สมมติว่าเมื่อผู้ใช้เลิกใช้งาน จะมีฟังก์ชันเรียกปิด session ที่นี่
$endTime = date('Y-m-d H:i:s'); // เวลาที่สิ้นสุด
logUsage($userId, $startTime, $endTime);
?>
