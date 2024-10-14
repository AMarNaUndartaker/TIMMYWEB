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
    <a class="navbar-brand" href="#">TIMMY.com</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <?php
                if($_SESSION['Status']=="ADMIN")
                {
                    $redirectPage = "Calendar.php";
                }
                elseif($_SESSION['Status']=="USER")
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
                <a class="nav-link" id="timer-link" href="<?php echo $redirectPage; ?>">Timer</a>
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
                <a class="nav-link" id="stats-link" href="<?php echo $redirectPage; ?>">Stats</a>
            </li>
            <li class="nav-item">
            <?php
                if($_SESSION['Status']=="ADMIN")
                {
                    $redirectPage = "Profileadmin.php";
                }
                elseif($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Profileuser.php";
                }
                else{
                    $redirectPage = "Formlogin.html";
                }
                ?>
                <a class="nav-link" href="<?php echo $redirectPage; ?>">Profile</a>
            </li>
        </ul>
    </div>
</nav>

<h1>Welcome to...</h1>
<h1>the Multiplication Task</h1>
<h1>Management Table.</h1>
<?php
        
        if($_SESSION['Status']=="ADMIN")
        {
            $redirectPage = "Home_page_admin.php";
        }
        elseif($_SESSION['Status']=="USER")
        {
            $redirectPage = "Homepage_User.php";
        }
        else{
            $redirectPage = "Formlogin.html";
        }
        ?>
        <div>
            <a href="<?php echo $redirectPage; ?>" class="btn btn-start">Start</a>
        </div>
        <script>
    document.getElementById("stats-link").addEventListener("click", function(e) {
            e.preventDefault(); // ป้องกันการเปลี่ยนหน้า

            // เช็คสถานะจากเซสชัน (ใช้ AJAX หรือแนวทางอื่นเพื่อดึงข้อมูลสถานะ)
            const userStatus = "<?php echo $_SESSION['Status']; ?>"; // ดึงสถานะจาก PHP

            if (userStatus === "ADMIN") {
                alert("คุณไม่มีสิทธิในการเข้าถึง Stats");
                window.location.href = "Calendar.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Stats.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });

        document.getElementById("timer-link").addEventListener("click", function(e) {
            e.preventDefault(); // ป้องกันการเปลี่ยนหน้า

            // เช็คสถานะจากเซสชัน (ใช้ AJAX หรือแนวทางอื่นเพื่อดึงข้อมูลสถานะ)
            const userStatus = "<?php echo $_SESSION['Status']; ?>"; // ดึงสถานะจาก PHP

            if (userStatus === "ADMIN") {
                alert("คุณไม่มีสิทธิในการเข้าถึง Timer");
                window.location.href = "Calendar.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Timer.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });
</script>
</body>
</html>
