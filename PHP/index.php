<?php
    require 'file_config.php';
    session_set_cookie_params(0, $root, "", true, true); 
    session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Feed Me</title>
    </head>
    <body>
        <?php
            if (empty($_SESSION['authenticated']) || $_SESSION['authenticated'] == false) {
                echo '<a href="account/login_user.php">Login</a>';
            } else {
                echo 'You are logged in.';
            }
        ?>
    </body>
</html>