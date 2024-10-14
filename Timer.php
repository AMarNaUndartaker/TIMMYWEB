<?php
session_start();
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
    <meta name="viewport" content="width=1024">
    <title>TIMMY.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/Head for Timer.css">

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
                <a class="nav-link timer" href="<?php echo $redirectPage; ?>">Timer</a>
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

    <div class="timer-box" id="timerBox">
        <li>
        00:00:00
        </li>
    </div>
    <div class="container">
        <button class="btn btn-edit" onclick="window.location.href='Edit Timer.php'">Edit</button>
        <button class="btn btn-reset" onclick="resetTimer()">Reset</button>
        <button class="btn btn-start" onclick="startCountdown()">Start</button>
    </div>

    
    <div id="customAlert" class="custom-alert">
        <h2 id="customTitle"></h2> <!-- ดึง title ที่ผู้ใช้ตั้ง -->
        <p>Time's up!</p>
        <button onclick="closeAlert()">OK</button>
    </div>


    <audio id="audioPlayer">
        <source id="audioSource" src="" type="audio/mpeg">
        เบราว์เซอร์ของคุณไม่สนับสนุนเสียง
    </audio>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        let hours = parseInt(urlParams.get('hours')) || 0;
        let minutes = parseInt(urlParams.get('minutes')) || 0;
        let seconds = parseInt(urlParams.get('seconds')) || 0;
        const selectedSound = urlParams.get('sound') || '';

        let timerInterval;
        let title = "";

        

        // โหลดเสียงตามพารามิเตอร์ใน URL
        if (selectedSound) {
            document.getElementById("audioSource").src = selectedSound;
            document.getElementById("audioPlayer").load();
        }

        function startCountdown() {
            if (hours === 0 && minutes === 0 && seconds === 0) {
                alert("ไม่สามารถเริ่มตัวจับเวลาด้วยเวลาศูนย์!");
                return;
            }
            clearInterval(timerInterval);
            timerInterval = setInterval(updateTimer, 1000);
        }

        function playSound() {
            const audioPlayer = document.getElementById("audioPlayer");
            audioPlayer.play().catch(error => {
                console.error("ไม่สามารถเล่นเสียง:", error);
            });
        }

        // const title = urlParams.get('title') || "";
        function updateTimer() {
            if (seconds === 0) {
                if (minutes === 0) {
                    if (hours === 0) {
                        clearInterval(timerInterval);
                        // playSound();
                        // const title = document.getElementById("title").value;
                        // ใช้ชื่อใน alert
                        const title = urlParams.get('title') || "เวลาหมดแล้ว!";
                        showCustomAlert(title); // เรียก Custom Dialog เมื่อเวลาหมด
                        
                        return;
                    } else {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    }
                } else {
                    minutes--;
                    seconds = 59;
                }
            } else {
                seconds--;
            }
            document.getElementById('timerBox').textContent = formatTime(hours, minutes, seconds);
        }

        function formatTime(hours, minutes, seconds) {
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function resetTimer() {
            clearInterval(timerInterval);
            hours = 0;
            minutes = 0;
            seconds = 0;
            document.getElementById('timerBox').textContent = formatTime(hours, minutes, seconds);
        }

        document.getElementById('timerBox').textContent = formatTime(hours, minutes, seconds);

        function showCustomAlert(title) {
        // ตั้ง title ที่ user กรอกไว้ใน dialog
        document.getElementById("customTitle").textContent = title ? title : "เวลาหมดแล้ว!";
        document.getElementById("customAlert").style.display = "block"; // แสดง Custom Dialog
        
        // เล่นเสียงเมื่อเวลาหมด
        const audioPlayer = document.getElementById("audioPlayer");
        const repeat = urlParams.get('repeat'); // รับค่าพารามิเตอร์ repeat
    
        // ถ้า repeat ถูกเลือก จะตั้งค่า loop ให้เล่นซ้ำไปเรื่อยๆ
        if (repeat === '1') {
            audioPlayer.loop = true;
        } else {
            audioPlayer.loop = false;
        }
        //เล่นเสียงจากตรงนี้
        audioPlayer.play().catch(error => {
            console.error("ไม่สามารถเล่นเสียง:", error);
            });
        }

        function closeAlert() {
            document.getElementById("customAlert").style.display = "none"; // ปิด dialog
            const audioPlayer = document.getElementById("audioPlayer");
            audioPlayer.pause(); // หยุดเสียง
            audioPlayer.currentTime = 0;
            audioPlayer.loop = false;
            }
   
     
        
        
    </script>

    
</body>
</html>