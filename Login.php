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

if(!$result)
    {
        echo "email or password incorrect please retry again";
    }   
else
{  
        $_SESSION["UserID"] = $result["UserID"];
        $_SESSION["Status"] = $result["Status"];
        $_SESSION["userid"] = $result["UserID"];
        $_SESSION["user_id"] = $result["UserID"];
        $_SESSION["start_time"] = date('Y-m-d H:i:s');
        session_write_close();
        /*เช็คค่าเซสชั่นที่กรอกเข้ามา ให้ตรงกับค่าที่ query ออกมาได้ จากนั้นนำไปเช็คกับ status ว่าชื่อผู้ใช้กับรหัสผ่านเป็นสถานะอะไรก็จะส่งข้อมูล
        ไปหน้านั้น*/
if($result["Status"]=="ADMIN")
    {
        header("location:Profileadmin.php");
    }
else{
        header("location:Profileuser.php");   
    }
}
mysqli_close($conn);
}
?>
