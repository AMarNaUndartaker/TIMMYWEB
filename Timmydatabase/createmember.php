<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; //ฐานข้อมูลที่สร้างไว้แล้ว

    //เชื่อมต่อกับฐานข้อมูล
    $conn = mysqli_connect($servername,$username,$password,$dbname);

    //ตรวจสอบการเชื่อมต่อฐานข้อมูลว่าสามารถเชื่อต่อและเข้าถึงฐานข้อมูลได้หรือไม่
    if(!$conn){
        die("connection failed: " .mysqli_connect_error());
    }
    $sql = "create table member
    (UserID int(6)unsigned auto_increment primary key,
    Firstname varchar(30) not null,
    Lastname varchar(30) not null,
    email varchar(30) not null UNIQUE,
    Password varchar(10) not null,
    Status enum('ADMIN','USER') NOT NULL default 'USER')";

    if(mysqli_query($conn,$sql)){
        echo "สร้างตารางสำเร็จ";
    }else{
        echo "สร้างตารางไม่สำเร็จ".mysqli_error($conn);
    }
    mysqli_close($conn);
?>