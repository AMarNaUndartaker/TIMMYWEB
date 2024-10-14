<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "timmy"; //ฐานข้อมูลที่สร้างไว้

//สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect($severname, $username, $password,$dbname);
 
//ตรวจสอบการเชื่อมต่อฐานข้อมูลว่าสามารถเชื่อมต่อและเข้าถึงฐานข้อมูลได้หรือไม่
if (!$conn) { //เป็นฟังก์ชันหมดเลย
    die("connection faild: ".mysqli_connect_error()); //mysqli_connect_error เอาไว้เช็คการ connect ถ้าไม่ได้จะ faild
}
$sql = "create table stats 
( id int(6)unsigned auto_increment primary key,
    user_id INT unsigned NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    foreign key (user_id) references member(UserID) ON DELETE CASCADE)";

if(mysqli_query($conn,$sql)) {
    echo "สร้างตารางสำเร็จ";
}else{
    echo "สร้างตารางไม่สำเร็จ".mysqli_error($conn);
}
mysqli_close($conn);

?>