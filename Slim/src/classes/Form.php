<?php
    require_once 'UserHandler.php';

    class Form {
    	
        public function loginForm($action_url) {
            $form = '';
            $form = $form . '<form method="post" action="' . htmlentities($action_url) . '">';
            $form = $form . 'username: <input type="text" name="username" required>';
            $form = $form . '<br>';
            $form = $form . 'password: <input type="password" name="password" required>';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }

        public function editUser($user_id, $db) {
            //Source: http://www.w3schools.com/php/php_file_upload.asp
            $user_handler = new UserHandler($db);
            $email = $user_handler->getEmail($user_id);
            $first_name = $user_handler->getFirstName($user_id);
            $last_name = $user_handler->getLastName($user_id);
            $form = '';
            $form = $form . '<form enctype="multipart/form-data" method="post" action="' . '/users/' . htmlentities($user_id) . '/edit' . '">';
            $form = $form . 'Email: <input type="email" name="email" value="'. htmlentities($email) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'First Name: <input type="text" name="first_name" value="'. htmlentities($first_name) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Last Name: <input type="text" name="last_name" value="'. htmlentities($last_name) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Profile Image: <input type="file" accept="image/*" name="profile_image_path">';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }
    }
?>