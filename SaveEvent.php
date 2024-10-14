<?php
session_start();
if ($_SESSION['UserID'] == "") {
    echo "กรุณา login ด้วย";
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับข้อมูลจากฟอร์ม
    $eventId = $_POST['eventId'];
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $eventColor = $_POST['eventColor'];

    // เตรียมคำสั่ง SQL เพื่ออัปเดตข้อมูลเหตุการณ์
    $sql = "UPDATE events SET event = ?, eventDate = ?, eventTime = ?, color = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $eventName, $eventDate, $eventTime, $eventColor, $eventId);

    // ตรวจสอบการอัปเดตข้อมูล
    if ($stmt->execute()) {
        echo "อัปเดตเหตุการณ์เรียบร้อยแล้ว!";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดต: " . $stmt->error;
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    mysqli_close($conn);
} else {
    echo "ไม่มีข้อมูลที่ส่งมา!";
}
?>
<meta http-equiv="refresh" content="1;URL=Calendar.php"/>
