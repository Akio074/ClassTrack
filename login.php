<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("Location: ./Home.php");
    }
    $_SESSION['login_page']=$_SERVER['PHP_SELF'];
    $err_page=$_SESSION['err_page'];
    $connect = pg_connect("host=localhost dbname=ClassTrackDB user=ClassTrack password=ClassTrack@123");
    if (!$connect) {
        $_SESSION['err_message']= "Connection to Database failed!!";
        $_SESSION['path']=$_SESSION['login_page'];
        $_SESSION['button_val']="Try Again!!";
        header("Location: $err_page");
        exit();
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
        <h2>Welcome to ClassTrack!!</h2><h2>Login</h2>
        <span><label for="username">Username</label>
        <input type="text" name="username" 
        <?php
            if (isset($_POST['username']) && strlen($_POST['username'])>0)
                echo "value=" . $_POST['username'];
            else
                echo "placeholder=$s1"; 
        ?>></span>
        <span><label class="labels" for="password" style="margin-right:3px">  Password</label>
        <input class="labesl" type="password" name="password" placeholder="Enter Password"></span>
        <input type="submit" name="Enter" value="Login" id="Login"><br>
        <?php
            $sytle = "color:red";
            if (isset($_POST['Enter'])) {
                $username = $_POST['username'];
                if(strlen($username)<=0){
                    echo "<h5 style=" . $sytle . ">Enter Username!!";
                }
                $credentials = pg_query($connect, "select Username,Password from StaffMember where UserName='$username';");
                if (!$credentials) {
                    $_SESSION['err_message']= "Unable to fetch data from database!!";
                    $_SESSION['path']=$_SESSION['login_page'];
                    $_SESSION['button_val']="Try Again!!";
                    header("Location: $err_page");
                    exit();
                }
                $Upass= pg_fetch_assoc($credentials);
                if(strlen($_POST['username'])>0){
                    if(!isset($Upass['username'])){
                        echo "<h5 style=" . $sytle . ">Invalid Username!!";
                        exit();
                    }
                    if (isset($_POST['password']) && strlen($_POST['password']) > 0) 
                    {
                        if ($Upass['password'] != $_POST['password']) 
                        {
                            echo "<h5 style=" . $sytle . ">Wrong Username and Password combination!!";
                        } 
                        else 
                        {
                            $credentials = pg_query($connect, "select * from StaffMember where UserName='$username';");
                            $Upass=pg_fetch_assoc($credentials);
                            $_SESSION['username']=$username;
                            $_SESSION['role']=$Upass['role'];
                            header("Location: {$_SESSION['home_page']}");
                            die();
                        }
                    }
                    else{
                        echo "<h5 style=" . $sytle . ">Enter Password!!";
                    }
                }
            }
        ?>
    </form>
</body>

</html>