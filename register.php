<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMMY.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="TIMMYcss/register.css">
    <link rel="stylesheet" href="TIMMYcss/Head.css">
    <script src="js/bootstrap.bundle.min.js"></script> 
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="Homepage.php">TIMMY.com</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto"> <!-- เปลี่ยน ml-auto เป็น ms-auto -->
               
            </ul>
        </div>
    </nav>
<div class="headpf">Register</div>
    <div class="container-Regis">
        <form name="addmember" action="addmember.php" method="POST">
            <div class="form-group">
                <label for="firstname" >FirstName :</label>
                <input type="text" name="Firstname" class="form-control-Regis" placeholder="FirstName" value="<?php echo isset($_GET['Firstname']) ? htmlspecialchars($_GET['Firstname']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname">LastName :</label>
                <input type="text" name="Lastname" class="form-control-Regis" placeholder="LastName" value="<?php echo isset($_GET['Lastname']) ? htmlspecialchars($_GET['Lastname']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" class="form-control-Regis" placeholder="Email" required value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" required>
                <span id="emailError" style="color: red;"></span>
            </div>

            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" name="Password" class="form-control-Regis" placeholder="password" required>
            </div>
            
            <div class="form-group">
                <label for="status">Status :</label>
                <select id="Status" name="Status" class="form-control-Regis">
                <option value="User">User</option>
                <option value="Admin">Admin</option>
            </select>
            </div>
            
            <div style="text-align: right">
            <button type="reset" class="btn btn-cancel" onclick= "window.location.href='Formlogin.html';" >Cancel</button>
            <button type="Submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
        const params = new URLSearchParams(window.location.search);
        if (params.has('error')) {
            alert(params.get('error'));
        }
    </script>
</body>
</html>