<?php
//error page code=1
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassTrack-Home</title>
    <link rel="stylesheet" href="./CSS/index.css">
</head>

<body>
    <nav>
        <a href="<?php echo $_SESSION['index_page']; ?>"><img src="./IMG/Logo.png" alt="Logo of classtrack"
                id="Logo"></a>
        <ul>
            <li><a href="#about us"><button>About us</button></a></li>
            <li><a href="./login.php"><button>Log in</button></a></li>
            <li><a href="./manual.html"><button>Manual page</button></a></li>
        </ul>
    </nav>
    <h2>What is ClassTrack?</h2>
    <p>ClassTrack is a tool made for teaching faculties in order to improve teaching experience and efficiency.</p>
    <p>You can:-</p>
    <ul>
        <li>search for available classrooms and laboratories for your lecture.</li>
        <li>reserve the classroom for your lectures.</li>
        <li>see the activity on monthly basis</li>
        <li>generate a report for administration and analysis.</li>
    </ul>
    <h2 id="about us">About us...</h2>
    <p>Do you lose time when finding classroom for extra lectures and practicals... Having problem while tracking your
        progress... Worry not ClassTrack is here to help you.</p>
    <p>ClassTrack shows you the live status of classrooms and laboratories if they are occupied or not. You can check
        the available seats for students and availability of projectors, smartboards and other useful resources.</p>
    <p>You can reserved the classroom or laboratory based on your preferences and for required amount of time.</p>
    <p>With the use of ClassTrack you can generate a Monthly report and also keep a track of available resources and
        their conditions (eg. Smartboard, Blackboard, Number of Seats, etc.)</p>
    <p>For using Instructions read the manual page.</p>
    <br><a href="./manual.html">Manual page</a>
</body>

</html>