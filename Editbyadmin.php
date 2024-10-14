<?php
session_start();
if($_SESSION['UserID']=="")
{
    echo "กรุณา login ด้วย";
    exit();
}
if($_SESSION['Status']!="ADMIN")
{
    echo "หน้านี้สำหรับ Admin กรุณา Login เข้ามาใหม่";
    exit();   
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMMY.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/Profile.css">
    <link rel="stylesheet" href="TIMMYcss/Head.css">
    <script src="js/bootstrap.bundle.min.js"></script> 
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <?php
        
        if($_SESSION['Status']=="ADMIN")
        {
            $redirectPage = "Home_page_admin.php";
        }
        elseif($_SESSION['Status']=="USER")
        {
            $redirectPage = "Homepage_User.php";
        }
        ?>
        <a class="navbar-brand" href="<?php echo $redirectPage; ?>">TIMMY.com</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto"> <!-- เปลี่ยน ml-auto เป็น ms-auto -->
                <li class="nav-item">
                <?php       
                    if($_SESSION['Status']=="ADMIN")
                    {
                        $redirectPage = "Calendar.php";
                    }
                    else{
                        $redirectPage = "Formlogin.html";
                    }
                    ?>
                    <a class="nav-link" href="<?php echo $redirectPage; ?>">Calendar</a>
                </li>
                <li class="nav-item">
                <?php       
                    if($_SESSION['Status']=="ADMIN")
                    {
                        $redirectPage = "showdatamember.php";
                    }
                    else{
                        $redirectPage = "Formlogin.html";
                    }
                    ?>
                    <a class="nav-link" href="<?php echo $redirectPage; ?>">Access User</a>
                </li>
                <li class="nav-item">
                <?php       
                    if($_SESSION['Status']=="ADMIN")
                    {
                        $redirectPage = "Profileadmin.php";
                    }
                    else{
                        $redirectPage = "Formlogin.html";
                    }
                    ?>
                    <a class="nav-link now" href="<?php echo $redirectPage; ?>">Profile</a>
                </li>
                
            </ul>
        </div>
    </nav>
    <div class="headpf">EditProfile</div>
    <div class="container-Pro">
        <form action="SaveEditByAdmin.php" method="post">
        
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "timmy";
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql="select * from member where UserID='".$_GET["UserID"]."'";
        $query=mysqli_query($conn,$sql);
        $result=mysqli_fetch_array($query);

        if(!$result){
            echo "ไม่พบข้อมูล UserID=".$_GET["UserID"];
        }
        else{
        ?>
            <div class="form-group">
                <label for="UserID" >UserID :</label>
                <input type="hidden" name="UserID" class="form-control-Pro" required value="<?php echo $result["UserID"];?>"><?php echo $result["UserID"];?>
            </div>

            <div class="form-group">
                <label for="firstname" >FirstName :</label>
                <input type="text" name="Firstname" class="form-control-Pro" required value="<?php echo $result['Firstname']; ?>">
            </div>

            <div class="form-group">
                <label for="lastname">LastName :</label>
                <input type="text" name="Lastname" class="form-control-Pro" required value="<?php echo $result['Lastname']; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" class="form-control-Pro" required value="<?php echo $result['email']; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" name="Password" class="form-control-Pro" required value="<?php echo $result['Password']; ?>">
            </div>

            <div class="form-group">
                <label for="Status">Status:</label>
                <input type="text" name="Status" class="form-control-Pro" value="<?php echo $result['Status']; ?>" readonly>
            </div>

            <div style="text-align: right">
            <button type="button" class="btn btn-danger" onclick="window.location.href='showdatamember.php';">cancel</button>
            <button type="submit" class="btn btn-primary"> save </button>
            </div>
        </form>
    </div>
</div>
<?php
        }
    mysqli_close($conn);
    ?>
</body>
</html>