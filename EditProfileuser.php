<?php
session_start();
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
        if($_SESSION['Status']=="USER")
            {
                $redirectPage = "Homepage_User.php";
            }
            else{
                $redirectPage = "Formlogin.html";
            }
    ?>
    <a class="navbar-brand" href="<?php echo $redirectPage; ?>">TIMMY.com</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <?php
                if($_SESSION['Status']=="USER")
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
                if($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Timer.php";
                }
                else{
                    $redirectPage = "Formlogin.html";
                }
                ?>
                <a class="nav-link" href="<?php echo $redirectPage; ?>">Timer</a>
            </li>
            <li class="nav-item">
            <?php
                if($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Stats.php";
                }
                else{
                    $redirectPage = "Formlogin.html";
                }
                ?>
                <a class="nav-link" href="<?php echo $redirectPage; ?>">Stats</a>
            </li>
            <li class="nav-item">
            <?php
                if($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Profileuser.php";
                }
                else{
                    $redirectPage = "Formlogin.html";
                }
                ?>
                <a class="nav-link" href="<?php echo $redirectPage; ?>">Profile</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a> 
            </li>
        </ul>
    </div>
</nav>
    <div class="headpf">EditProfile</div>
    <div class="container-Pro">
        <form action="Save_edit_user.php" method="post">
        
        <?php
        if($_SESSION['UserID']=="")
        {
            echo "กรุณา login ด้วย";
            exit();
        }
        if($_SESSION['Status']!="USER")
        {
            echo "หน้านี้สำหรับ User กรุณา Login เข้ามาใหม่";
            exit();   
        }
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "timmy";
        $conn = mysqli_connect($servername,$username,$password,$dbname);
        $sql="select * from member where UserID='".$_SESSION["UserID"]."'";
        $query=mysqli_query($conn,$sql);
        $result=mysqli_fetch_array($query,MYSQLI_ASSOC);

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
            <button type="button" class="btn btn-danger" onclick="window.location.href='Profileuser.php';">cancel</button>
            <button type="submit" class="btn btn-primary"> save </button>
            </div>
        </form>
    </div>
</div>
<?php
    mysqli_close($conn);
    ?>
</body>
</html>