<?php
session_start();
if($_SESSION['UserID']=="")
{
    echo "please login";
    exit();
}
if($_SESSION['Status']!="USER")
{
    echo "This page for User please Login again";
    exit();   
}
$servername="localhost";
$username="root";
$password="";
$dbname="timmy";
$conn=mysqli_connect("$servername","$username","$password","$dbname");
$sql = "select * from member where UserID = '".$_SESSION['UserID']."'";
$query = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($query,MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profileuser</title>
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
                <a class="nav-link now" href="<?php echo $redirectPage; ?>">Profile</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> 
            </li>
        </ul>
    </div>
</nav>
    <div class="headpf">Profile</div>
    <div class="container-Pro">
        <form action="#" method="POST">
            <div class="form-group">
                <label for="firstname" >FirstName :</label>
                    <table>
                        <td type="text" class="form-control-Pro"><?php echo $result["Firstname"];?></td>
                    </table>
            </div>

            <div class="form-group">
                <label for="lastname">LastName :</label>
                    <table>
                        <td type="text" class="form-control-Pro"><?php echo $result["Lastname"];?></td>
                    </table>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                    <table>
                        <td type="text" class="form-control-Pro"><?php echo $result["email"];?></td>
                    </table>
            </div>

            <div class="form-group">
                <label for="password">Password :</label>
                    <table>
                        <td type="text" class="form-control-Pro"><?php echo $result["Password"];?></td>
                    </table>
            </div>

            <div class="form-group">
                <label for="status">Status :</label>
                    <table>
                        <td type="text" class="form-control-Pro"><?php echo $result["Status"];?></td>
                    </table>
            </div>
            <div style="text-align: right">
            <button type="button" class="btn btn-primary" onclick= "window.location.href='EditProfileuser.php';">Edit</button>
            </div>
        </form>
    </div>
</div>
<?php
    
    mysqli_close($conn);
    ?>
<script>
    function confirmLogout() 
        {
            return confirm('Are you sure you want to logout?');
        }
    </script>    
</body>
</html>