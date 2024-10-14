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
    $sql = "create table events
    (id int(6)unsigned auto_increment primary key,
    userid int(6)unsigned not null,
    eventDate date not null,
    eventTime time ,
    event varchar(255) not null,
    color varchar(10) not null,
    createdBy ENUM('USER', 'ADMIN') NOT NULL DEFAULT 'USER',
    foreign key (userid) references member(UserID) ON DELETE CASCADE)";

    if(mysqli_query($conn,$sql)){
        echo "สร้างตารางสำเร็จ";
    }else{
        echo "สร้างตารางไม่สำเร็จ".mysqli_error($conn);
    }
    mysqli_close($conn);
?>