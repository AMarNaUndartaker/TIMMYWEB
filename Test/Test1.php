<?php
session_start(); // เริ่มต้น session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['txtemail']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword']);

    $sql = "SELECT * FROM member WHERE email='$email' AND Password='$password'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query, MYSQLI_ASSOC);

    if ($result) {
        $_SESSION["UserID"] = $result["UserID"];
        $_SESSION["Status"] = $result["Status"];
        header("Location: Test2.php"); // เปลี่ยนเส้นทางไปยังหน้า homepage
        exit();
    } else {
        echo "email หรือ password ไม่ถูกต้องกรุณากรอกข้อมูลใหม่";
    }

    mysqli_close($conn);
}
?>

<!-- HTML Form สำหรับ Login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <input type="email" name="txtemail" required placeholder="Email">
        <input type="password" name="txtPassword" required placeholder="Password">
        <button type="submit">Login</button>
    </form>
</body>
</html>
