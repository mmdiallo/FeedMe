<?php
    require 'file_config.php';
    session_set_cookie_params(0, "/", "", true, true);
    session_name('PHPSESSID_FEEDME');
    session_start();
    session_regenerate_id(true);
?>
<?php
    require 'session_checks.php';
    require 'forms.php';

    if (empty($_SERVER['HTTPS'])) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit;
    } else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            if (authenticatedSession()) {
                header('Location: ' . $current_domain . 'index.php', 301);
            } else {
                form_create_user_account();
            }

        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require 'input.php';
            $response = array('error' => NULL);
            $input_valid = validateInput();


            if ($input_valid) {
                $username = getUsername();
                $password_salt = generatePasswordSalt();
                $password_hash = generatePasswordHash($password_salt);
                echo $password_hash;
            } else {
                $response['error'] = 'Invalid input.';
            }

            $json = json_encode($response);
            echo $json;

        }
    }
?>