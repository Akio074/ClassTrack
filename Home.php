<?php
    session_start();
    $err_path="./err_page.php";
    $_SESSION['home_page']=$_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(isset($_SESSION['username'])){ echo $_SESSION['username'];} else {echo "No Login!!";}?> Home</title>
    <link rel="stylesheet" href="./CSS/tabs.css">
</head>
<body>
<?php
    if(!isset($_SESSION['username'])){
        $_SESSION['err_message']="You need to login first!!";
        $_SESSION['path']=$_SESSION['login_page'];
        $_SESSION['button_val']="Login";
        header("Location: '$err_path'");
        exit();
    }
    else{
        $connect = pg_connect("host=localhost dbname=ClassTrackDB user=ClassTrack password=ClassTrack@123");
        if (!isset($connect)) {
            $_SESSION['err_message']= "Connection to Database failed!!";
            $_SESSION['path']=$_SESSION['home_page'];
            $_SESSION['button_val']="Try Again!!";
            header("Location: $err_path");
            exit();
        }
        $username=$_SESSION['username'];
        $credentials = pg_query($connect, "select * from StaffMember where UserName='$username';");
        if (!isset($credentials)) {
            $_SESSION['err_message']= "Unable to fetch data from database!!";
            $_SESSION['path']=$_SESSION['home_page'];
            $_SESSION['button_val']="Try Again!!";
            header("Location: $err_page");
            exit();
        }
    }
?>
    <nav>
        <a href="./index.php"><img src="./IMG/Logo.png" alt="ClassTrack Logo" id="Logo"></a>
        <ul>
            <li id="set"><a href="./home.php">Home</a></li>
            <li><a href="./classes.php">Classes</a></li>
            <?php
            if($_SESSION['role']=="Admin")
                echo"<li><a href=\"./records.php\">Records</a></li>";
            ?>
            <li><a href="./schedule.php">Schedule</a></li>
            <li><a href="./profile.php"><img src="./IMG/ProfilePic.png" alt="Profile-icon" id="ProfilePic"></a></li>
        </ul>
    </nav>
    <div class="Content">
        <?php
            
        ?>
    </div>
</body>
</html>