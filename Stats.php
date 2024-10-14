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
    <title>สถิติการใช้งาน</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        canvas {
            max-width: 100%;
            height: 400px;
        }
        .total-usage {
            font-size: 24px;
            color: #333;
            margin-top: 20px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
        <h1>เวลาการใช้งานเว็บไซต์ของคุณ</h1>
        <canvas id="usageChart"></canvas>
        <p class="total-usage">เวลาการใช้งานรวม: <?= $totalUsageHours; ?> ชั่วโมง <?= $totalUsageRemainderMinutes; ?> นาที</p>
        <a href="?action=logout.php" class="logout-button">ออกจากระบบ</a>
    </div>

    <script>
        const ctx = document.getElementById('usageChart').getContext('2d');
        const dailyUsage = <?= json_encode($dailyUsage) ?>;

        const usageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Array.from({length: 31}, (_, i) => i + 1),
                datasets: [{
                    label: 'เวลาใช้งาน (นาที)',
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
                            text: 'วันที่ในเดือน'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'เวลาใช้งาน (นาที)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
