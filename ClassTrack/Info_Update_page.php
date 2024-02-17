<?php
if (file_exists("config.php")) {
    include_once "config.php";
} else {
    session_start();
    $_SESSION['err_message'] = "Configuration file not found!!";
    $_SESSION['path'] = "/";
    $_SESSION['button_val'] = "Exit";
    $_SESSION['err_code'] = 605;
    header("Location: {$_SESSION['err_page']}");
    exit();
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
    $_SESSION['err_code'] = 604;
    header("Location: {$_SESSION['err_page']}");
    exit();
}
$username = $_SESSION['username'];
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
$info['uname'] = $in[1];
$info['role'] = $in[2];
$info['Fname'] = trim($in[3], "\"");
$info['DoB'] = $in[4];
$info['add'] = $in[5];
$info['Sal'] = trim($in[6], "\"?");
$info['DoJ'] = $in[7];
$info['edu'] = trim($in[8], "\"");
$info['gender'] = trim($in['9'], ")");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo ucfirst($_SESSION['username']), " Update_Info"; ?>
    </title>
    <link rel="stylesheet" href="./CSS/Info_update_page.css">
</head>

<body>
    <form action="<?php echo $_SESSION['Info_Update_page'] ?>" method="post">
        <h1>Update Your Profile:-</h1>
        <table>
            <tr>
                <td><label for="username">Username:-</label></td>
                <td><input type="text" name="username" value="<?php echo $info['uname']; ?>"></td>
            </tr>
            <tr>
                <td><label for="role">Role:-</label></td>
                <td><input type="text" name="role" value="<?php echo $info['role']; ?>"></td>
            </tr>
            <tr>
                <td><label for="Fname">Full Name:-</label></td>
                <td><input type="text" name="Fname" value="<?php echo $info['Fname']; ?>"></td>
            </tr>
            <tr>
                <td><label for="add">Gender:-</label></td>
                <td><input type="text" name="add" value="<?php echo $info['gender']; ?>" readonly></td>
            </tr>
            <tr>
                <td><label for="DoB">Date of Birth:-</label></td>
                <td><input type="text" name="DoB" value="<?php echo $info['DoB']; ?>"></td>
            </tr>
            <tr>
                <td><label for="add">Address:-</label></td>
                <td><input type="text" name="add" value="<?php echo $info['add']; ?>"></td>
            </tr>
            <tr>
                <td><label for="Sal">Salary:-</label></td>
                <td><input type="text" name="Sal" value="<?php echo $info['Sal']; ?>" <?php if ($_SESSION['role'] != "Admin") {
                       echo "class=\"Readonly\" readonly";
                   } ?>></td>
            </tr>
            <tr>
                <td><label for="DoJ">Date of Joining:-</label></td>
                <td><input type="text" name="DoJ" value="<?php echo $info['DoJ']; ?>" <?php if ($_SESSION['role'] != "Admin") {
                       echo "class=\"Readonly\" readonly";
                   } ?>></td>
            </tr>
            <tr>
                <td><label for="edu">Education:-</label></td>
                <td><input type="text" name="edu" value="<?php echo $info['edu']; ?>" <?php if ($_SESSION['role'] != "Admin") {
                       echo "class=\"Readonly\" readonly";
                   } ?>></td>
            </tr>
        </table>
        <span><input type="submit" name="Enter" class="Button" value="Confirm">
            <input type="submit" name="Back" class="Button" value="Go Back"></span>

        <?php
        if (isset($_POST['Enter'])) {
            $res = pg_query($connect, "select update('{$info['uid']}','{$_POST['username']}','{$_POST['role']}','{$_POST['Fname']}','{$_POST['DoB']}','{$_POST['add']}','{$_POST['Sal']}','{$_POST['DoJ']}','{$_POST['edu']}');");
            if (!isset($res)) {
                $_SESSION['err_message'] = "Unable to Update to Data!!";
                $_SESSION['path'] = "{$_SESSION['home_page']}";
                $_SESSION['button_val'] = "Go to Home";
                $_SESSION['err_code'] = 602;
                header("Location: {$_SESSION['err_page']}");
            }
            $res = pg_fetch_assoc($res);
            if ($res['update'] == "1") {
                echo "<h4 style=\"color:Green\">Updation Successful!!</h4>";
            } else {
                echo "<h4 style=\"color:Red\">Updation Not Successful!!</h4>";
            }
        }
        if (isset($_POST['Back'])) {
            header("Location: {$_SESSION['home_page']}");
        }
        ?>
    </form>
</body>

</html>