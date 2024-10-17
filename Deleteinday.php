<!DOCTYPE html>
<head>

</head>
<body>
<?php
    session_start(); // เริ่มต้น session เพื่อใช้งาน $_SESSION
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; //ฐานข้อมูลที่สร้างไว้แล้ว
  
    // เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // รับ ID ของเหตุการณ์ที่จะลบและ UserID ของผู้ใช้ที่ล็อกอินอยู่
    $id = $_GET["id"];
    $userId = $_SESSION['UserID'];

    // ตรวจสอบว่าเหตุการณ์นี้ถูกสร้างโดยผู้ใช้เองหรือไม่
    $sql = "SELECT * FROM events WHERE id = ? AND userid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // ถ้าผู้ใช้เป็นผู้สร้างเหตุการณ์นี้เอง ให้ทำการลบ
    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM events WHERE id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $id);
        $stmtDelete->execute();

        if (mysqli_affected_rows($conn)) {
            echo "ลบข้อมูลแล้ว";
        } else {
            echo "ไม่สามารถลบข้อมูลได้";
        }
    } else {
        echo "คุณไม่มีสิทธิ์ลบเหตุการณ์นี้";
    }

    $stmt->close();
    mysqli_close($conn);
?>
</body>
</html>
<meta http-equiv="refresh" content="1;URL=Calendar.php"/>
