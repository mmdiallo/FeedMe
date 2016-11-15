<?php
    session_name('PHPSESSID_FEEDME');
    session_set_cookie_params(0, "/", "", true, true);
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
                echo '<a href="accounts/login_user.php">Login</a>';
                echo '  ';
                echo '<a href="accounts/create_user_account.php">Create User Account</a>';
                echo '  ';
                echo '<a href="accounts/create_restaurant_account.php">Create Restaurant Account</a>';
            } else {
                echo 'You are logged in.';
            }
        ?>
    </body>
</html>