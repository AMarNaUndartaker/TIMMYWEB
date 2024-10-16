<?php
session_start();
// if (!isset($_SESSION['UserID'])) {
//     header("Location: Formlogin.html");
//     exit();
    
// }
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMMY.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="TIMMYcss/Head.css">
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
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> 
            </li>
        </ul>
    </div>
</nav>

<h1>Welcome User</h1>
<h1>Let start Multiplication Task</h1>
<h1>Management Table.</h1>
<?php
      if($_SESSION['Status']=="USER")
        {
            $redirectPage = "Calendar.php";
        }
        else{
            $redirectPage = "Formlogin.html";
        }
        ?>
        <div>
            <a href="<?php echo $redirectPage; ?>" class="btn btn-start">Start</a>
        </div>
<script>
function confirmLogout() 
    {
        return confirm('Are you sure you want to logout?');
    }
</script>
</body>
</html>
