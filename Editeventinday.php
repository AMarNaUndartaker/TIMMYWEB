<?php
session_start();
if ($_SESSION['UserID'] == "") {
    echo "please login";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
     <head>
         <title>ฟอร์มสมาชิก</title>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, intitial-scale=1">
         <link href="css/bootstrap.min.css" rel="stylesheet">
         <script src="js/bootstrap.bundle.min.js"></script> 
         <link rel="stylesheet" href="TIMMYcss/Profile.css">
        <link rel="stylesheet" href="TIMMYcss/Head.css">
     
        <style>
            h2{
                font-family:"JasmineUPC";
                text-align:center
            }
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg">
    <?php
        if($_SESSION['Status']=="USER")
            {
                $redirectPage = "Homepage_User.php";
            }
            elseif($_SESSION['Status']=="ADMIN")
            {
                $redirectPage = "Home_page_admin.php";
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
                elseif($_SESSION['Status']=="ADMIN")
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
                if($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Profileuser.php";
                }
                elseif($_SESSION['Status']=="ADMIN")
                {
                    $redirectPage = "Profileadmin.php";
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
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy";
    $conn = mysqli_connect($servername,$username,$password,$dbname);
    $sql="select * from events where id='".$_GET["id"]."'";
    $query=mysqli_query($conn,$sql);
    $result=mysqli_fetch_array($query);

    if(!$result){
        echo "ไม่พบข้อมูล id=".$_GET["id"];
    }
    else{
    
    ?>
    <div class="headpf">Edit Event</div>
    <div class="container-Pro">
        <form action="Saveinday.php" method="post">
            <input type="hidden" name="id" value="<?php echo $result['id']; ?>">

            <div class="form-group">
                <label for="event">Event Name:</label>
                <input type="text" name="event" class="form-control-Pro" required value="<?php echo ($result["event"]); ?>">
            </div>

            <div class="form-group">
                <label for="eventDate">Event Date:</label>
                <input type="date" name="eventDate" class="form-control-Pro" required value="<?php echo $result["eventDate"]; ?>">
            </div>

            <div class="form-group">
                <label for="eventTime">Event Time:</label>
                <input type="time" name="eventTime" class="form-control-Pro" required value="<?php echo $result["eventTime"]; ?>">
            </div>

            <div class="form-group">
                <label for="eventColor">Select Color:</label>
                <select class="form-control-Pro"  name="color" required value="<?php echo $result["color"]; ?>">
                    <option value="red" <?php if($result["color"] == "red") echo "selected"; ?>>Red</option>
                    <option value="green" <?php if($result["color"] == "green") echo "selected"; ?>>Green</option>
                    <option value="blue" <?php if($result["color"] == "blue") echo "selected"; ?>>Blue</option>
                    <option value="yellow" <?php if($result["color"] == "yellow") echo "selected"; ?>>Yellow</option>
                    <option value="orange" <?php if($result["color"] == "orange") echo "selected"; ?>>Orange</option>
                </select>
            </div>

            <div style="text-align: right">
                <button type="button" class="btn btn-danger" onclick="window.location.href='Calendar.php';">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
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