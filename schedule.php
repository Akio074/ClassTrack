<?php
    session_start();
    $err_path="./err_page.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username'];?> Schedule</title>
    <link rel="stylesheet" href="./CSS/tabs.css">
</head>
<?php
$style="text-decoration: underline;"
?>
<body>
<nav>
        <a href="./index.php"><img src="./IMG/Logo.png" alt="ClassTrack Logo" id="Logo"></a>
        <ul>
        <li><a href="./home.php">Home</a></li>
            <li><a href="./classes.php">Classes</a></li>
            <li><a href="./records.php">Records</a></li>
            <li id="set"><a href="./schedule.php">Schedule</a></li>
            <li><a href="./profile.php"><img src="./IMG/ProfilePic.png" alt="Profile-icon" id="ProfilePic"></a></li>
        </ul>
    </nav>
    <div class="Content">
                
    </div>
</body>
</html>