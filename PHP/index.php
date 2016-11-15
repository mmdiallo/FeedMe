<?php
    session_set_cookie_params(0, "/", "", false, true);
    session_start();
    session_regenerate_id(true);
    $var = session_get_cookie_params();
    var_dump($var);
    echo '<br>';
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