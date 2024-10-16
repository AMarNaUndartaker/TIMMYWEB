<!DOCTYPE html>
<head>

</head>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; //ฐานข้อมูลที่สร้างไว้แล้ว
  
    //เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $UserID = $_GET["UserID"];
    $sql = "delete from member where UserID = '".$UserID."'";
    $query = mysqli_query($conn,$sql);

    if(mysqli_affected_rows($conn)){
        echo "member deleted";
        //ฟังก์ชัน mysqli_affected_rows(การเชื่อม) เป็นฟังก์ชันเอาไว้ตรวจสอบแถวของข้อมูลที่มีการเปลี่ยนแปลง เช่น การแก้
        //เพื่อตรวจสอบว่าข้อมูลได้มีการเปลี่ยนแปลงจริงหรือไม่
    }
    mysqli_close($conn);
?>
</body>
</html>
<meta http-equiv="refresh" content="1;URL=showdatamember.php"/>
