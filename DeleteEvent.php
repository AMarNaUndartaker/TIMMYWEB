<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";

//สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect($severname, $username, $password,$dbname);

//ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามี ID หรือไม่
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    // สร้าง SQL สำหรับลบเหตุการณ์
    $sql = "DELETE FROM events WHERE id='$eventId'";

    if (mysqli_query($conn, $sql)) {
        echo "Event deleted successfully.";
        // Redirect กลับไปที่ Calendar.php
        header("Location: Calendar.php");
        exit;
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
