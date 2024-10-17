<?php
session_start(); // เริ่มเซสชัน

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy"; 
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
}

// สมมติว่ามีการล็อกอินแล้วและ userID ถูกเก็บไว้ในเซสชัน
$userid = $_SESSION['userid']; // ดึง userID จากเซสชัน
$Status = $_SESSION['Status']; // สมมติว่ามีการจัดเก็บบทบาทของผู้ใช้ (USER/ADMIN)

$sql = "SELECT * FROM events WHERE userid = ? OR createdBy = 'ADMIN'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[$row['eventDate']][] = [
            'id' => $row['id'],
            'event' => $row['event'],
            'eventDate' => $row['eventDate'],
            'time' => $row['eventTime'],
            'color' => $row['color'],
            'createdBy' => $row['createdBy'],
            'userid' => $row['userid'] // เพิ่ม userID ในข้อมูล
        ];
    }
}

$stmt->close();
mysqli_close($conn);
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Calendar</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="TIMMYcss/Head.css" />
    <link rel="stylesheet" href="TIMMYcss/Calendar.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg">
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
        <a class="navbar-brand" href="<?php echo $redirectPage; ?>">TIMMY.com</a>
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
                    <a class="nav-link calendar-link" href="<?php echo $redirectPage; ?>">Calendar</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> 
                </li>
            </ul>
        </div>
    </nav>
    <div class="calendar-container">
        <div class="headbg">
            <h2>Calendar</h2>
        </div>
        <div class="calendar-navigation">
            <a href="#" id="prev-month">&#9664; Previous</a>
            <span id="month-name">October 2024</span>
            <a href="#" id="next-month">Next &#9654;</a>
        </div>

        <table id="calendar-table">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>
            <!-- Calendar days will be dynamically inserted here -->
        </table>
    </div>
    <div class="add-event-btn">
        <button id="add-event-button" class="btn">Add Event</button> <!-- ปุ่ม Add Event -->
    </div>

    <script>
        const months = [
            { name: "January", days: 31 },
            { name: "February", days: 29 },
            { name: "March", days: 31 },
            { name: "April", days: 30 },
            { name: "May", days: 31 },
            { name: "June", days: 30 },
            { name: "July", days: 31 },
            { name: "August", days: 31 },
            { name: "September", days: 30 },
            { name: "October", days: 31 },
            { name: "November", days: 30 },
            { name: "December", days: 31 },
        ];

        let currentMonthIndex = 9; // เริ่มที่เดือนตุลาคม
        const monthNameElement = document.getElementById("month-name");
        const calendarTableElement = document.getElementById("calendar-table");
        const prevMonthButton = document.getElementById("prev-month");
        const nextMonthButton = document.getElementById("next-month");
        const addEventButton = document.getElementById("add-event-button"); // ปุ่ม Add Event

        const events = <?php echo json_encode($events); ?>; // ดึงข้อมูลเหตุการณ์จาก PHP

        function renderCalendar(monthIndex) {
            const month = months[monthIndex];
            monthNameElement.textContent = `${month.name} 2024`;

            const firstDay = new Date(2024, monthIndex, 1).getDay();
            const days = month.days;

            calendarTableElement.innerHTML = `
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            `;

            let row = document.createElement("tr");
            for (let i = 0; i < firstDay; i++) {
                row.appendChild(document.createElement("td"));
            }

            for (let day = 1; day <= days; day++) {
                const cell = document.createElement("td");
                const date = `2024-${String(monthIndex + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

                cell.textContent = day;

                 cell.addEventListener("click", () => {
                     window.location.href = `Showevent.php?date=${date}`;
                });

                if (events[date]) {
                    events[date].forEach((event) => {
                        const eventLabel = document.createElement("div");
                        eventLabel.classList.add("event-label");
                        eventLabel.textContent = `${event.event}`; // แสดงเฉพาะชื่อเหตุการณ์
                        eventLabel.style.backgroundColor = event.color;
                        eventLabel.style.marginTop = '5px';
                        
                        if (event.createdBy === 'ADMIN') {
                            eventLabel.style.border = '2px solid black'; // เพิ่มการสไตล์ event ของ ADMIN
                        }
                            
                        
                        // ตรวจสอบว่าเป็นเหตุการณ์ที่สร้างโดย ADMIN หรือ USER
                        if (event.createdBy === 'USER' || event.createdBy === 'ADMIN') {
                            // เพิ่ม listener คลิกที่เหตุการณ์
                            eventLabel.addEventListener("click", (e) => {
                                e.stopPropagation(); // หยุดการเกิดเหตุการณ์คลิกจาก cell

                                // ตรวจสอบว่ามีปุ่ม Edit และ Delete หรือยัง
                            const eventActions = eventLabel.querySelector('.event-actions');
                            if (eventActions) {
                                // ถ้ามีอยู่แล้ว ให้เอาปุ่มออก
                                eventActions.remove();
                            } else {
                                // ถ้ายังไม่มี ให้สร้างปุ่มขึ้นมา
                                const newEventActions = document.createElement("div");
                                newEventActions.classList.add('event-actions');
                                newEventActions.innerHTML = `
                                    <button onclick="editEvent(${event.id}, '${date}','${event.createdBy}')" class="btn btn-warning">Edit</button>
                                    <button onclick="deleteEvent(${event.id},'${event.createdBy}')" class="btn btn-danger">Delete</button>
                                `;
                                eventLabel.appendChild(newEventActions);
                            }
                        });
                        }

                        cell.appendChild(eventLabel);
                    });
                }
                row.appendChild(cell);
                if ((firstDay + day) % 7 === 0) {
                    calendarTableElement.appendChild(row);
                    row = document.createElement("tr");
                }
            }
            if (row.children.length > 0) {
                calendarTableElement.appendChild(row);
            }
        }

        function editEvent(id, date, createdBy) {
            if (createdBy === 'ADMIN' && '<?php echo $_SESSION["Status"]; ?>' === 'USER') {
                alert("You can't edit ADMIN event");
                return;
            }
            // ตรวจสอบว่าผู้ใช้เป็น USER หรือไม่
            if (createdBy === 'USER' && '<?php echo $_SESSION["Status"]; ?>' === 'ADMIN') {
                alert("You can't edit USER event");
                return;
            }
            window.location.href = `EditEvent.php?date=${date}&edit=${id}`; // นำไปยังหน้าแก้ไข
        }

        function deleteEvent(id,createdBy) {
            if (createdBy === 'ADMIN' && '<?php echo $_SESSION["Status"]; ?>' === 'USER') {
                alert("You can't edit ADMIN event");
                return;
            }else {
                (confirm("Are you sure you want to delete this event?")) 
                window.location.href = `DeleteEvent.php?id=${id}`; // นำไปยังหน้า Deleteevent.php
            }
        }

        prevMonthButton.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentMonthIndex > 0) {
                currentMonthIndex--;
                renderCalendar(currentMonthIndex);
            }
        });

        nextMonthButton.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentMonthIndex < 11) {
                currentMonthIndex++;
                renderCalendar(currentMonthIndex);
            }
        });

        addEventButton.addEventListener("click", (e) => {
            e.preventDefault();
            window.location.href = "Addevent.php"; // นำไปยังหน้า Addevent.php
        });

        renderCalendar(currentMonthIndex);

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
                alert("you have no access to Timer");
                window.location.href = "Calendar.php"; // เปลี่ยนไปที่หน้า Homepage
            } else {
                window.location.href = "Timer.php"; // เปิดหน้า Stats ถ้าไม่ใช่ ADMIN
            }
        });
        function confirmLogout() {
        return confirm('Are you sure you want to logout'); // แสดงข้อความยืนยัน
    }
    </script>
</body>
</html>
