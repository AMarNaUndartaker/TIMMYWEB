<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/Profile.css">
    <link rel="stylesheet" href="TIMMYcss/Head.css">
    <link rel="stylesheet" href="TIMMYcss/Edit.css" />
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
                <a class="nav-link now" href="<?php echo $redirectPage; ?>">Calendar</a>
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
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a> 
            </li>
        </ul>
    </div>
</nav>
<?php
        $strKeyword = null;
        if(isset($_POST["txtKeywords"]))
        {
            $strKeyword = $_POST["txtKeywords"];
        }
    $severname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "timmy";

    $conn = mysqli_connect($severname, $username, $password,$dbname);

    if (!$conn) {
        die("connection failed: ".mysqli_connect_error());
    }
    $userid = $_SESSION['userid']; // ดึง userID จากเซสชัน
    $Status = $_SESSION['Status'];

    $selectedDate = isset($_GET['date']) ? $_GET['date'] : null;

    $sql="SELECT * FROM events WHERE eventDate = ? AND (userid = ? OR createdBy = 'ADMIN')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $selectedDate, $_SESSION['userid']);
    $stmt->execute();
    $query = $stmt->get_result();

    ?>
    <div class="container">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th width="90">Event</th>
                    <th width="90">Color</th>
                    <th width="90">Event Date</th>
                    <th width="90">Event Time</th>
                    <th width="90">Edit</th>
                    <th width="90">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($result=mysqli_fetch_array($query,MYSQLI_ASSOC)) {
                    $isCreatedByAdmin = $result["createdBy"] === "ADMIN";
                ?>
                <tr>
                    <td><?php echo $result["event"];?></td>
                    <td><?php echo $result["color"];?></td>
                    <td><?php echo $result["eventDate"];?></td>
                    <td><?php echo $result["eventTime"];?></td>
                    <td><a href="Editeventinday.php?id=<?php echo $result["id"];?>" <?php echo $isCreatedByAdmin ? 'onclick="return false;"' : ''; ?>>
                    <button type="button" class="btn btn-primary" <?php echo $isCreatedByAdmin ? 'disabled="disabled"' : ''; ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                        </svg>Edit
                    </button>
                </a></td>

                    <td>
                        <button onclick="confirmDelete(<?php echo $result['id']; ?>)" type="button" class="btn btn-danger" <?php echo $isCreatedByAdmin ? 'disabled' : ''; ?>>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708"/>
                            </svg>Delete</button></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
        mysqli_close($conn);
    ?>
    <script>
    function confirmLogout() 
        {
            return confirm('Are you sure you want to logout?');
        }
        
        function confirmDelete(eventId) {
            const userConfirmed = confirm("คุณต้องการลบข้อมูลนี้หรือไม่?");
            if (userConfirmed) {
                window.location.href = "Deleteinday.php?id=" + eventId;
            }
        }
    </script>
</body>
</html>
