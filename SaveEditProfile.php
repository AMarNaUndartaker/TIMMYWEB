<!DOCTYPE html>
<html lang="en">
     <head>
     <script>
        function showAlert(message) {
            alert(message); 
        }
    </script>
    </head>
    <body>
    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; 
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $sql="update member set email ='".trim($_POST["email"])."',
    Password = '".trim($_POST['Password'])."',
    Firstname = '".trim($_POST['Firstname'])."',
    Lastname = '".trim($_POST['Lastname'])."',
    Status = '".trim($_POST['Status'])."'
    where UserID = '".$_SESSION['UserID']."'";
    
    try {
        if (mysqli_query($conn, $sql)) {
            echo "<script>showAlert('แก้ไขข้อมูลเรียบร้อยแล้ว');</script>";
        } else {
            throw new Exception(mysqli_error($conn));
        }
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            // ถ้าเกิดข้อผิดพลาด Duplicate entry
            echo "<script>showAlert('เกิดข้อผิดพลาด: อีเมลนี้ถูกใช้ไปแล้ว');</script>";
        } else {
            echo "<script>showAlert('เกิดข้อผิดพลาด: ".$e->getMessage()."');</script>";
        }
    }
    mysqli_close($conn);
    ?>
    </body>
</html>
<meta http-equiv="refresh" content="0.5;URL=Profileadmin.php"/>
