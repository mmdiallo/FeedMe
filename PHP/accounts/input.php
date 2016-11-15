<?php
    function validateInput() {
        $input_valid = false;

        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);
            $valid_username_pattern = '/^[a-zA-z][\w]*$/';

            if (preg_match($valid_username_pattern, $username) && strlen($password) > 5) {
                $input_valid = true;
            }
        }
        return $input_valid;
    }

    function getUsername() {
        $username = htmlentities($_POST['username']);
        return $username;
    }

    function generatePasswordSalt() {
        $random_string = uniqid();
        $password_salt = hash('sha256', $random_string);
        return $password_salt;
    }
?>