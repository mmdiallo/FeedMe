<?php
    //require 'file_config.php';
    session_set_cookie_params(0, "/", NULL, true, true);
    session_start();
    //session_regenerate_id(true); 
?>
<?php
    require 'session_checks.php';

    if (empty($_SERVER['HTTPS'])) {
        exit;

    } else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (authenticatedSession()) {
                
            } else {
                
            }

        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        }
    }
?>