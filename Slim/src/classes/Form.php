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
    }

?>