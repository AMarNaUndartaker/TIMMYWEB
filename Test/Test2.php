<?php
session_start(); // เริ่มต้น session

// เช็คว่ามี session หรือไม่
if (!isset($_SESSION['UserID'])) {
    header("Location: Test1.php"); // ถ้าไม่มี session ให้ redirect ไปยังหน้า login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>
<body>
    <h1>ยินดีต้อนรับ <?php echo htmlspecialchars($_SESSION['UserID']); ?></h1>
    <a href="logout.php">Logout</a>
    <a href="Homepage.php">Home</a>
</body>
</html>
