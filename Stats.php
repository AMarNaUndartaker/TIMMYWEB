<?php
session_start();

// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$userId = $_SESSION['user_id'];
// ฟังก์ชันบันทึกการใช้งานของผู้ใช้


// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['user_id'])) {
    // ถ้ายังไม่ได้ล็อกอินให้ไปยังหน้า login
    header("Location: Formlogin.html");
    exit();
}


// ดึงข้อมูลการใช้งานของผู้ใช้ที่ล็อกอินอยู่
$userId = $_SESSION['user_id'];
$dailyUsage = [];
for ($day = 1; $day <= 31; $day++) {
    $sql = "SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) AS total_minutes
            FROM stats 
            WHERE user_id = ? AND DAY(start_time) = ? AND MONTH(start_time) = ? AND YEAR(start_time) = ?";
    $stmt = $conn->prepare($sql);
    $month = date('m');
    $year = date('Y');
    $stmt->bind_param("iiii", $userId, $day, $month, $year);
    $stmt->execute();
    $stmt->bind_result($totalMinutes);
    $stmt->fetch();
    $dailyUsage[$day] = $totalMinutes ? $totalMinutes : 0;
    $stmt->close();
}

// คำนวณเวลาการใช้งานรวม
$totalUsageMinutes = array_sum($dailyUsage);
$totalUsageHours = floor($totalUsageMinutes / 60);
$totalUsageRemainderMinutes = $totalUsageMinutes % 60;

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stats</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/Profile.css">
    <link rel="stylesheet" href="TIMMYcss/Head.css">
    <link rel="stylesheet" href="TIMMYcss/Stats.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a class="nav-link now" href="<?php echo $redirectPage; ?>">Stats</a>
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
<div class="containerS">
        <h3 class="Texthd">Time usage</h3>
        <canvas id="usageChart"></canvas>
        <p class="total-usage">All time usage : <?= $totalUsageHours; ?> Hour <?= $totalUsageRemainderMinutes; ?> Minute</p>
    </div>

    <script>
        const ctx = document.getElementById('usageChart').getContext('2d');
        const dailyUsage = <?= json_encode($dailyUsage) ?>;

        const usageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Array.from({length: 31}, (_, i) => i + 1),
                datasets: [{
                    label: 'Time used (minute)',
                    data: dailyUsage,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    hoverBackgroundColor: 'rgba(75, 192, 192, 0.8)',
                    hoverBorderColor: 'rgba(75, 192, 192, 1)',
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Time used(minute)'
                        }
                    }
                }
            }
        });

        function confirmLogout() 
                {
                    return confirm('Are you sure you want to logout?');
                }
    </script>
</body>
</html>
