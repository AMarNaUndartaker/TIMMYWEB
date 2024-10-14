<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่า UserID ถูกส่งมาหรือไม่
if (isset($_GET["UserID"])) {
    $userID = $_GET["UserID"];
    $sql = "SELECT * FROM member WHERE UserID='$userID'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    if (!$result) {
        echo "ไม่พบข้อมูล UserID=" . $userID;
    } else {
        // แสดงข้อมูลผู้ใช้
        // (ที่เหลือของโค้ด)
    }
} else {
    echo "UserID ไม่ได้ถูกส่งมาใน URL";
}

mysqli_close($conn);
?>
