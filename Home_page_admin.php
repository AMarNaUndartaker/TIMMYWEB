<?php
session_start();
if (!isset($_SESSION['UserID'])) {
    header("Location: Formlogin.html"); // ถ้าไม่มี session ให้ redirect ไปยังหน้า login
    exit();
    
}
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
    <a class="navbar-brand" href="#">TIMMY.com</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
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
                    <a class="nav-link" href="showdatamember.php">Access User</a>
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
                <a class="nav-link" href="<?php echo $redirectPage; ?>">Profile</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> 
            </li>
        </ul>
    </div>
</nav>

<h1>Welcome Admin</h1>
<h1>Now you have work to do</h1>
<h1>Management Table.</h1>
<div><a href="showdatamember.php" class="btn btn-start">Start</a></div>
<script>
function confirmLogout() 
        {
            return confirm('Are you sure you want to logout?');
        }
</script>
</body>
</html>
