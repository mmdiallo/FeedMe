<?php
    function form_create_user_account() {
       echo '<div>';
            echo '<form method="post" action="create_user_account.php">';
                echo 'username: <input type="text" name="username" required>';
                echo '<br>';
                echo 'password: <input type="password" name="password" required>';
                echo '<br>';
                echo '<input type="submit">';
            echo '</form>';
       echo '</div>'; 
    }
?>