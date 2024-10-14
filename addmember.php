<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; 

    //เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect($servername,$username,$password,$dbname);

    //ตรวจสอบการเชื่อมต่อฐานข้อมูลว่าสามารถเชื่อต่อและเข้าถึงฐานข้อมูลได้หรือไม่
    if(!$conn){
        die("connection failed: " .mysqli_connect_error());
    }
    $email = $_POST["email"];
    $firstname = $_POST["Firstname"];
    $lastname = $_POST["Lastname"];
    $status = $_POST["Status"];
    
    $checkEmail = "SELECT * FROM member WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        // echo 
    //         "<script>alert('อีเมลนี้มีอยู่ในระบบแล้ว');;
    //         window.history.back();
    //         </script>";
        $error_message = "อีเมลนี้มีอยู่ในระบบแล้ว";
        header("Location: register.php?error=" . urlencode($error_message) . "&Firstname=" . urlencode($firstname) . "&Lastname=" . urlencode($lastname) . "&email=" . urlencode($email) . "&Status=" . urlencode($Status));
        exit();
    } else {

    $sql="insert into member(Firstname,Lastname,email,Password,Status)values('".$_POST["Firstname"]."','".$_POST["Lastname"]."','".$_POST["email"]."',
    '".$_POST["Password"]."','".$_POST["Status"]."')";
    $query=mysqli_query($conn,$sql);
        echo "<script>alert('สร้างบัญชีเรียบร้อย ไปlogin กันเถอะ');</script>";
        echo '<meta http-equiv="refresh" content="0;URL=Formlogin.html"/>';
}
    mysqli_close($conn);
?>
<!-- <meta http-equiv="refresh" content="0;URL=Formlogin.html"/> -->