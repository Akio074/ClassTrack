<?php
//error page code=3
if (file_exists("config.php")) {
    include_once "config.php";
} else {
    session_start();
    $_SESSION['err_message'] = "Configuration file not found!!";
    $_SESSION['path'] = "/";
    $_SESSION['button_val'] = "Exit";
    $_SESSION['err_code'] = 305;
    header("Location: {$_SESSION['err_page']}");
    exit();
}
if (isset($_POST['tab'])) {
    $current_tab = $_POST['tab'];
} else {
    $current_tab = "home";
}
if(isset($_COOKIE['username'])){
    $_SESSION['username']=$_COOKIE['username'];
}
if(isset($_COOKIE['role'])){
    $_SESSION['role']=$_COOKIE['role'];
}
if (!isset($_SESSION['username'])) {
    $_SESSION['err_message'] = "You need to login first!!";
    $_SESSION['path'] = $_SESSION['login_page'];
    $_SESSION['button_val'] = "Login";
    $_SESSION['err_code'] = 304;
    header("Location: {$_SESSION['err_page']}");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo ucfirst($_SESSION['username']), " ", ucfirst($current_tab); ?>
    </title>
    <link rel="stylesheet" href="./CSS/tabs.css">
</head>

<body>
    <?php
    $username = $_SESSION['username'];
    $credentials = pg_query($connect, "select * from StaffMember where UserName='$username';");
    if (!isset($credentials)) {
        $_SESSION['err_message'] = "Unable to fetch data from database!!";
        $_SESSION['path'] = $_SESSION['home_page'];
        $_SESSION['button_val'] = "Try Again!!";
        $_SESSION['err_code'] = 302;
        header("Location: $err_page");
        exit;
    }
    ?>
    <nav>
        <a href="./index.php"><img src="./IMG/Logo.png" alt="ClassTrack Logo" id="Logo"></a>
        <form action="<?php {
            echo $_SERVER['PHP_SELF'];
        } ?>" method="post">
            <ul>
                <li><button name="tab" value="home" <?php if ($current_tab == "home")
                    echo "id=\"set\""; ?>>Home</button><p id="h" style="display:none">Home</p>
                </li>
                <li><button name="tab" value="classes" <?php if ($current_tab == "classes")
                    echo "id=\"set\""; ?>>Classes</button></li>
                <?php
                if ($_SESSION['role'] == "Admin") {
                    echo "<li><button name=\"tab\" value=\"records\"";
                    if ($current_tab == "records")
                        echo "id=\"set\"";
                    echo ">Records</button></li>";
                }
                ?>
                <li><button name="tab" value="schedule" <?php if ($current_tab == "schedule")
                    echo "id=\"set\""; ?>>Schedule</button></li>
                <li><button name="tab" value="profile" <?php if ($current_tab == "profile")
                    echo "id=\"setP\""; ?>
                        id="ProfilePicButton"><img src="./IMG/ProfilePic.png" alt="Profile-icon"
                            id="ProfilePic"></button></li>
            </ul>
        </form>
    </nav>
    <div class="Content">
        <?php
        switch ($current_tab) {
            case "home":
                $content = pg_query($connect, "select * from StaffMember where UserName='$username';");
                if (!isset($content)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 303;
                    header("Location: $err_page");
                    exit();
                }
                break;

            case "classes":
                $content = pg_query($connect, "select display_class();");
                if (!isset($content)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 303;
                    header("Location: $err_page");
                    exit();
                }
                ?>
                <form action="<?php echo $_SESSION['home_page'];?>" method="post" class="classes">
                <?php
                while($classroom = pg_fetch_assoc($content)){
                    $c=explode(" ",$classroom['display_class']);
                    $class['class_id']=$c[0];$class['status']=$c[1];unset($c);
                ?>
                    <input type="button" name="class" value="<?php echo $class['class_id']?>" class="class_button" class="<?php if($class['status']==1)echo"Fclass"; else echo "Oclass";?>">
                
                <?php
                }
                ?>
                </form>
                <?php
                break;
            case "records":
                $content = pg_query($connect, "select * from log where UserName='$username';");
                if (!isset($content)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 303;
                    header("Location: $err_page");
                    exit();
                }
                break;

            case "schedule":
                $content = pg_query($connect, "select * from StaffSchedule where UserName='$username';");
                if (!isset($content)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 303;
                    header("Location: $err_page");
                    exit();
                }
                break;

            case "profile":
                $content = pg_query($connect, "select Self('$username');");
                if (!isset($content)) {
                    $_SESSION['err_message'] = "Unable to fetch data from database!!";
                    $_SESSION['path'] = $_SESSION['login_page'];
                    $_SESSION['button_val'] = "Try Again!!";
                    $_SESSION['err_code'] = 303;
                    header("Location: $err_page");
                    exit();
                }
                $values = pg_fetch_assoc($content);
                $in = explode(",", $values['self']);
                $info['uid'] = trim($in[0], "(");
                $info['uname'] = trim($in[1], "");
                $info['role'] = trim($in[2], "");
                $info['Fname'] = trim($in[3], "\"");
                $info['DoB'] = $in[4];
                $info['add'] = trim($in[5], "");
                $info['Sal'] = trim($in[6], "\"?");
                $info['DoJ'] = trim($in[7], "");
                $info['edu'] = trim($in[8], "\"");
                $info['gender'] = trim($in['9'], ")");
                unset($in);
                ?>
                <table id="Personal_Info">
                    <tr>
                        <td>User Id:-</td>
                        <td>
                            <?php echo $info['uid']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Username:-</td>
                        <td>
                            <?php echo $info['uname']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Password:-</td>
                        <td>***</td>
                    </tr>
                    <tr>
                        <td>Full Name:-</td>
                        <td>
                            <?php echo $info['Fname']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Gender:-</td>
                        <td>
                            <?php echo $info['gender']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Role:-</td>
                        <td>
                            <?php echo $info['role']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Birth:-</td>
                        <td>
                            <?php echo $info['DoB']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Address:-</td>
                        <td>
                            <?php echo $info['add']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Salary:-</td>
                        <td>₹
                            <?php echo $info['Sal']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Date of Joining:-</td>
                        <td>
                            <?php echo $info['DoJ']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Education:-</td>
                        <td>
                            <?php echo $info['edu']; ?>
                        </td>
                    </tr>
                </table>
                <form action="<?php echo $_SESSION['home_page']; ?>" method="post" id="Personal_Info_Buttons">
                    <span><input type="submit" name="update" value="Update Info" class='Button'>
                        <input type="submit" name="logout" value="Logout" class='Button'>
                </form>
                <?php
                break;
        }
        ?>
    </div>
</body>

</html>
<?php
if (isset($_POST['update'])) {
    header("Location: {$_SESSION['Info_Update_page']}");
    exit();
}
if (isset($_POST['logout'])) {
    $lgout = pg_query($connect, "select logout('$username');");
    if (!isset($content)) {
        $_SESSION['err_message'] = "Unable to fetch data from database!!";
        $_SESSION['path'] = $_SESSION['home_page'];
        $_SESSION['button_val'] = "Try Again!!";
        $_SESSION['err_code'] = 303;
        header("Location: $err_page");
        exit();
    }
    $res=pg_fetch_assoc($lgout);
    if($res['logout']==1){
    unset($_SESSION['username']);
    setcookie("username",$username,time()-1,"/");
    setcookie("role",$Upass['auth'],time()-1,"/");
    header("Location:{$_SESSION['index_page']}");
    exit();
    }
}
?>