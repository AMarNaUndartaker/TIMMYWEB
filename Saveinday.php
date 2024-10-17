<!DOCTYPE html>
<html lang="en">
     <head>

    </head>
    <body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy"; 
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $sql="update events set event ='".trim($_POST["event"])."',
    color = '".trim($_POST['color'])."',
    eventDate = '".trim($_POST['eventDate'])."',
    eventTime = '".trim($_POST['eventTime'])."'
    where id = '".$_POST['id']."'";
    
    $query=mysqli_query($conn,$sql);
    echo "แก้ไขข้อมูลเรียบร้อยแล้ว";
    mysqli_close($conn);
    ?>
    </body>
</html>
<meta http-equiv="refresh" content="1;URL=Calendar.php"/>
