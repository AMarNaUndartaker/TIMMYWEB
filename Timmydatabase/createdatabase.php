<?php
    $servername = "localhost";
    $username = "root";
    $password = "";

    //สร้างการเชื่อมต่อกับฐานข้อมูล
    $conn = new mysqli($servername,$username,$password);

    //ตรวจสอบการเชื่อมต่อฐานข้อมูลว่าสามารถเชื่อต่อและเข้าถึงฐานข้อมูลได้หรือไม่
    if($conn->connect_error){
        die("connection failed: " .$conn->connection_error);
    }
    echo "เชื่อมต่อฐานข้อมูลสำเร็จ<br>";

    //สร้างฐานข้อมูล
    $sql = "CREATE DATABASE timmy";
    if(mysqli_query($conn,$sql)){
        echo "สร้างข้อมูลสำเร็จ";
    } else {
        echo "ไม่สามารถสร้างฐานข้อมูลได้: " . mysqli_error($conn);
    }
    mysqli_close($conn);
?>