<?php
session_start();
if($_SESSION['UserID']=="")
{
    echo "please login ";
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
    <meta name="viewport" content="width=1024">
    <title>TIMMY.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/Head for EditTime.css">
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
                    <a class="nav-link" id="timer-link" href="<?php echo $redirectPage; ?>">Timer</a>
                </li>
                <li class="nav-item">
                <?php
                if($_SESSION['Status']=="USER")
                {
                    $redirectPage = "Stats.php";
                }
                // else{
                //     $redirectPage = "Formlogin.html";
                // }
                ?>
                    <a class="nav-link" id="stats-link" href="<?php echo $redirectPage; ?>">Stats</a>
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

    <div class="edittime-container">
        <div class = "headbgedit">Edit Timer</div>
            <div class = "time">
                <div class = "hours">
                    <label for="hours">Hours</label><br>
                    <select id="hours"></select>
                </div>
                <div class="minutes">
                    <label for="minutes">Minutes</label><br>
                    <select id="minutes"></select>   
                </div>
                <div class="seconds">
                    <label for="seconds">Seconds</label><br>
                    <select id="seconds"></select>
                </div>
            </div><br>
        
    <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="send work" required>
    </div><br>
            <div class="songna">       
    <div class="sounds1">
        <label for="songs">Sounds :</label>
        <select id="songs" onchange="changeSong()">
            <option value="">-- Select a song --</option>
            <option value="audio/song1.mp3">Song 1 </option>
            <option value="audio/song2.mp3">Song 2 </option>
            <option value="audio/song3.mp3">Song 3 </option>
            <option value="audio/song4.mp3">Song 4 </option>
            <option value="audio/song5.mp3">Song 5 </option>
        </select>
    </div>

    <div class="audio">
        <audio id="audioPlayer" controls class="audio">
            <source id="audioSource" src="audio/song1.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div class="repeat1">
            <label for="repeat">Repeat Sound </label>
            <input type="checkbox" id="repeat">
    </div>
        
        <div class="btn-container">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="btn-cancle" onclick= "window.location.href = 'Timer.php'">Cancle</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button class="btn-start" onclick="startTimer()">Start Timer</a></button>
            
        </div>

       
    </div>
    <script>
        const hoursSelect = document.getElementById("hours");
        for (let i = 0; i <= 24; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            hoursSelect.appendChild(option);
        }

        const minutesSelect = document.getElementById("minutes");
        for (let i = 0; i <= 59; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            minutesSelect.appendChild(option);
        }

        const secondsSelect = document.getElementById("seconds");
        for (let i = 0; i <= 59; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            secondsSelect.appendChild(option);
        }


    function changeSong() {
        var selectedSong = document.getElementById("songs").value;
        var audioPlayer = document.getElementById("audioPlayer");
        var audioSource = document.getElementById("audioSource");

        if (selectedSong) {
            audioSource.src = selectedSong;
            audioPlayer.load();
            audioPlayer.play();
        } else {
            audioPlayer.pause();
        }
    }
    function startTimer() {
            if (!validateForm()) {
                return; 
            }

            let hours = document.getElementById("hours").value;
            let minutes = document.getElementById("minutes").value;
            let seconds = document.getElementById("seconds").value;
            let title = document.getElementById("title").value;
            let sound = document.getElementById("songs").value;
            let repeat = document.getElementById("repeat").checked ? 1 : 0;

        
        window.location.href = `Timer.php?hours=${hours}&minutes=${minutes}&seconds=${seconds}&title=${encodeURIComponent(title)}&sound=${encodeURIComponent(sound)}&repeat=${repeat}`;
    }

    function validateForm() {
        var hours = document.getElementById("hours").value;
        var minutes = document.getElementById("minutes").value;
        var seconds = document.getElementById("seconds").value;
        var title = document.getElementById("title").value;

        if (hours === "" || minutes === "" || seconds === "" || title.trim() === "") {
            alert("Please fill in all fields: Hours, Minutes, Seconds, and Title.");
            return false;
        }
        return true;
    }
    document.getElementById("stats-link").addEventListener("click", function(e) {
            e.preventDefault(); // ป้องกันการเปลี่ยนหน้า

            // เช็คสถานะจากเซสชัน (ใช้ AJAX หรือแนวทางอื่นเพื่อดึงข้อมูลสถานะ)
            const userStatus = "<?php echo $_SESSION['Status']; ?>"; // ดึงสถานะจาก PHP

            if (userStatus === "ADMIN") {
                alert("You have no access to Stats");
                window.location.href = "Home_page_admin.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Stats.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });

        document.getElementById("timer-link").addEventListener("click", function(e) {
            e.preventDefault(); // ป้องกันการเปลี่ยนหน้า

            // เช็คสถานะจากเซสชัน (ใช้ AJAX หรือแนวทางอื่นเพื่อดึงข้อมูลสถานะ)
            const userStatus = "<?php echo $_SESSION['Status']; ?>"; // ดึงสถานะจาก PHP

            if (userStatus === "ADMIN") {
                alert("You have no access to Timer");
                window.location.href = "Home_page_admin.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Timer.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });

        function confirmLogout() {
            return confirm('Are you sure you want to logout?');
        }

    </script>
 
</body>
</html>