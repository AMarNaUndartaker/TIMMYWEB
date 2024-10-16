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
    $sql="update member set email ='".trim($_POST["email"])."',
    Password = '".trim($_POST['Password'])."',
    Firstname = '".trim($_POST['Firstname'])."',
    Lastname = '".trim($_POST['Lastname'])."',
    Status = '".trim($_POST['Status'])."'
    where UserID = '".$_POST['UserID']."'";
    
    $query=mysqli_query($conn,$sql);
    echo "data edit successful";
    mysqli_close($conn);
    ?>
    </body>
</html>
<meta http-equiv="refresh" content="1;URL=showdatamember.php"/>
