<?php
session_start();
$userid = $_SESSION['userid'];
$Status = $_SESSION['Status'];
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please login first!'); window.location.href='Login.php';</script>";
    exit;
}
$UserID = $_SESSION['userid'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "timmy"; // ฐานข้อมูลที่สร้างไว้

// สร้างการเชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีข้อมูล POST หรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event = $_POST['event'];
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $color = $_POST['color'];
    $userid = $_SESSION['userid'];

    $createdBy = ($Status === 'ADMIN') ? 'ADMIN' : 'USER'; 

    $sql = "INSERT INTO events (event, eventDate, eventTime, color, createdBy, userid) VALUES ('$event', '$eventDate', '$eventTime', '$color', '$createdBy','$userid')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Event added successfully!'); window.location.href='Calendar.php';</script>";
    } else {
        echo "<script>alert('Failed to add event.'); window.location.href='Calendar.php';</script>";
    }
}

$conn->close();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Event</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="TIMMYcss/Head.css" />
    <link rel="stylesheet" href="TIMMYcss/Profile.css" />
    <link rel="stylesheet" href="TIMMYcss/Calendar.css" />
</head>
<body>
    <div class="headpf">
    <h2><b>Add Event</b></h2>
</div>
    <div class="container-Pro">
        <form method="POST" action="Addevent.php">
            <div class="form-group">
                <label for="event">Event Name:</label>
                <input type="text" class="form-control-Pro"  name="event" required />
            </div>
            <div class="form-group">  
                <label for="eventDate" >Date:</label><br>
                <input type="date" class="form-control-Pro"  name="eventDate" required />
            </div>
            <div class="form-group">      
                <label for="eventTime" >Time:</label>
                <input type="time" class="form-control-Pro"  name="eventTime" />
            </div>
            <div class="form-group">
                <label for="eventColor">Select Color:</label>
                <select class="form-control-Pro"  name="color" required>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="blue">Blue</option>
                    <option value="yellow">Yellow</option>
                    <option value="orange">Orange</option>
                </select>
            </div>
            <div class="btn-add-cancle">
                <div class = "cancle-event-btn">
                <button type="button" class="btn btn-danger" onclick="window.location.href='Calendar.php';">cancel</button>
                </div>
                <div class="add-event-btn">
                    <button type="submit" class="btn btn-warning">Add Event</button> <!-- ปุ่ม Add Event -->
                </div>
            </div>
        </form>
    </div>
</body>
</html>
