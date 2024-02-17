<?php
// error page code=2
if (file_exists("config.php")) {
    include_once "config.php";
} else {
    session_start();
    $_SESSION['err_message'] = "Configuration file not found!!";
    $_SESSION['path'] = "/";
    $_SESSION['button_val'] = "Exit";
    $_SESSION['err_code'] = 205;
    header("Location: {$_SESSION['err_page']}");
    exit();
}
//Check if already Logged in
if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}
if(isset($_COOKIE['role'])){
    $_SESSION['role']=$_COOKIE['role'];
}
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    header("Location: {$_SESSION['home_page']}");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./CSS/login.css">
</head>

<body>
    <?php
    $s1 = "'Enter Username'";
    ?>
    <form action="./login.php" method="post">
        <h2>Welcome to ClassTrack!!</h2>
        <h2>Login</h2>
        <span><label for="username">Username</label>
            <input type="text" name="username" <?php
            if (isset($_POST['username']) && strlen($_POST['username']) > 0)
                echo "value=" . $_POST['username'];
            else
                echo "placeholder=$s1";
            ?>></span>
        <span><label class="labels" for="password" style="margin-right:3px"> Password</label>
            <input class="labesl" type="password" name="password" placeholder="Enter Password"></span>
        <input type="submit" name="Enter" value="Login" id="Login"><br>
        <?php
        $sytle = "color:red";
        if (isset($_POST['Enter'])) {
            $username = $_POST['username'];
            if (strlen($username) <= 0) {
                echo "<h5 style=" . $sytle . ">Enter Username!!";
                exit();
            }
            if (isset($_POST['password']) && strlen($_POST['password']) > 0) {
                $credentials = pg_query($connect, "select Auth('$username','{$_POST['password']}');");
                if (!isset($credentials)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 202;
                    header("Location: {$_SESSION['err_page']}");
                    exit();
                }
                $Upass = pg_fetch_assoc($credentials);
                if ($Upass['auth'] == -1) {
                    echo "<h5 style=" . $sytle . ">Wrong Username and Password combination!!";
                } else {
                    setcookie("username",$username,time()+86400,"/");
                    setcookie("role",$Upass['auth'],time()+86400,"/");
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $Upass['auth'];
                    header("Location: {$_SESSION['home_page']}");
                    exit;
                }
            } else {
                echo "<h5 style=" . $sytle . ">Enter Password!!";
            }
        }
        ?>
    </form>
</body>

</html>