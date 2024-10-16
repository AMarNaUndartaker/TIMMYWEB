<?php
session_start();
if ($_SESSION['UserID'] == "") {
    echo "please login";
    exit();
}

// ดึง ID ของเหตุการณ์ที่จะแก้ไขจาก URL
$eventId = $_GET['edit'] ?? null;
if ($eventId === null) {
    echo "No event to edit";
    exit();
}

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ดึงข้อมูลเหตุการณ์จากฐานข้อมูล
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $eventId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No event";
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
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
    <div class="headpf">Edit Event</div>
    <div class="container-Pro">
        <form action="SaveEvent.php" method="post">
            <input type="hidden" name="eventId" value="<?php echo $event['id']; ?>">

            <div class="form-group">
                <label for="eventName">Event Name:</label>
                <input type="text" name="eventName" class="form-control-Pro" required value="<?php echo htmlspecialchars($event['event']); ?>">
            </div>

            <div class="form-group">
                <label for="eventDate">Event Date:</label>
                <input type="date" name="eventDate" class="form-control-Pro" required value="<?php echo $event['eventDate']; ?>">
            </div>

            <div class="form-group">
                <label for="eventTime">Event Time:</label>
                <input type="time" name="eventTime" class="form-control-Pro" required value="<?php echo $event['eventTime']; ?>">
            </div>

            <div class="form-group">
                <label for="eventColor">Select Color:</label>
                <select class="form-control-Pro"  name="eventColor" required value="<?php echo $event['eventColor']; ?>">
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="yellow">Yellow</option>
                    <option value="orange">Orange</option>
                </select>
            </div>

            <div style="text-align: right">
                <button type="button" class="btn btn-danger" onclick="window.location.href='Calendar.php';">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById("stats-link").addEventListener("click", function(e) {
            e.preventDefault(); // ป้องกันการเปลี่ยนหน้า

            // เช็คสถานะจากเซสชัน (ใช้ AJAX หรือแนวทางอื่นเพื่อดึงข้อมูลสถานะ)
            const userStatus = "<?php echo $_SESSION['Status']; ?>"; // ดึงสถานะจาก PHP

            if (userStatus === "ADMIN") {
                alert("You have no access to Stats");
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
                alert("You have no access Timer");
                window.location.href = "Calendar.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Timer.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });
</script>
</body>
</html>
