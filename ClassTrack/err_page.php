<!-- Session Start and variables set up -->
<?php
//error page code=4
include_once "config.php";
if (!isset($_SESSION['code']))
    $_SESSION['code'] = 0;
if (!isset($_SESSION['err_count']))
    $_SESSION['err_count'] = 0;
?>

<!-- Page body -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error!!</title>
    <link rel="stylesheet" href="./CSS/err_page.css">
</head>

<body>
    <div class="Error_box">
        <?php
        // setting error msg (if not)
        if (!isset($_SESSION['err_message']))
            $_SESSION['err_message'] = "You need to login First!!<br>";

        // setting path to redirect to (if not)
        if (!isset($_SESSION['path']))
            $_SESSION['path'] = $_SESSION['index_page'];

        // setting button val (if not)
        if (!isset($_SESSION['button_val']))
            $_SESSION['button_val'] = "Go to Home Page";

        // checking if redirected for same error
        if ($_SESSION['code'] == $_SESSION['err_code']) {
            $_SESSION['err_count']++;
        } else {
            $_SESSION['code'] = $_SESSION['err_code'];
            $_SESSION['err_count'] = 0;
        }

        // error box content
        if ($_SESSION['err_count'] < 3) {
            echo "<h4>{$_SESSION['err_message']}</h4>
            <a href=\"{$_SESSION['path']}\">
                <input type='button' name='Enter' value=\"{$_SESSION['button_val']}\" id=\"Try_again\">
            </a>";
        } else {
            echo "<h4>Unsolvable Error!!<br>Error code:- {$_SESSION['err_code']} </h4><br>
                <a href=\"{$_SESSION['index_page']}\">
                <input type='button' name='Enter' value=\"Go Home\" id=\"Try_again\">
                </a>";
        }
        ?>
    </div>
</body>

</html>