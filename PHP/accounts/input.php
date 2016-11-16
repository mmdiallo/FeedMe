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

    function generatePasswordHash($password_salt) {
        $password = htmlentities($_POST['password']);
        $initial_password_hash = hash('sha256', $password);
        $password_hash_with_salt = $password_salt . $initial_password_hash . $password_salt;
        //$final_password_hash = password_hash($password_hash_with_salt, PASSWORD_BCRYPT);
        //return $final_password_hash;
        return 'hi';
    }
?>