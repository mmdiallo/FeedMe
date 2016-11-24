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

    //     public function registerForm($action_url) {
    //         $form = '';
    //         $form = $form . '<form method="post" action="' . $action_url . '">';
    //         $form = $form . 'first name: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'last name: <input type="text" name="last_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'username: <input type="text" name="username" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'email: <input type="text" name="email" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'password: <input type="password" name="password" required>';
    //         $form = $form . '<br>';
    //         $form = $form . '<input type="submit">';
    //         $form = $form . '</form>';
    //         return $form;
    //     }

    //     public function registerRestaurantForm($action_url) {
    //         $form = '';
    //         $form = $form . '<form method="post" action="' . $action_url . '">';
    //         $form = $form . 'Email: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'Restaurant Name: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'Street Address: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'City: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'State: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . 'Phone Number: <input type="text" name="first_name" required>';
    //         $form = $form . '<br>';
    //         $form = $form . '<input type="submit">';
    //         $form = $form . '</form>';
    //         return $form;
    //     }
     }

?>