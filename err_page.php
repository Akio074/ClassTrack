<!-- Session Start and variables set up -->
<?php
    session_start();
    $_SESSION['err_page']=$_SERVER['PHP_SELF'];
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
            if(!isset($_SESSION['err_message']))
                $_SESSION['err_message']="You started off here?!<br> This is the error page You Know!! <br>Go to the Home page First and Login:)";
        
        // setting path to redirect to (if not)
            if(!isset($_SESSION['path']))
                $_SESSION=$_SESSION['index_page'];

        // setting button val (if not)
            if(!isset($_SESSION['button_val']))
                $_SESSION['button_val']="Go to Home Page";

        // error box content
            echo "<h4>{$_SESSION['err_message']}</h4>
            <a href=\"{$_SESSION['path']}\">
                <input type='button' name='Enter' value=\"{$_SESSION['button_val']}\" id=\"Try_again\">
            </a>";
        ?>
    </div>
</body>
</html>