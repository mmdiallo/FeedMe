<?php
    class Form {
    	
        public function loginForm($action_url) {
            $form = '';
            $form = $form . '<form method="post" action="' . $action_url . '">';
            $form = $form . 'username: <input type="text" name="username" required>';
            $form = $form . '<br>';
            $form = $form . 'password: <input type="password" name="password" required>';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }

        public function editUser($user_id) {
            // $email;
            // $first_name;
            // $last_name;
            $form = '';
            $form = $form . '<form method="post" action="' . 'users/' . $user_id . '/edit' . '">';
            $form = $form . 'username: <input type="text" name="username" required>hi</input>';
            $form = $form . '<br>';
            $form = $form . 'password: <input type="password" name="password" required>';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }
    }
?>