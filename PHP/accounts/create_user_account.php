<?php
    require 'file_config.php';
    session_set_cookie_params(0, "/", "", true, true);
    session_name('PHPSESSID_FEEDME');
    session_start();
    session_regenerate_id(true);
?>
<?php
    require 'session_checks.php';

    if (empty($_SERVER['HTTPS'])) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit;
    } else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (authenticatedSession()) {
                header('Location: ' . $current_domain . 'index.php', 301);
            } else {
                header('Location: ' . $current_domain . 'index.php', 301);
            }

        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        }
    }
?>