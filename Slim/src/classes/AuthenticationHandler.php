<?php 
    class AuthenticationHandler {

        public function checkAuthentication() {
            $auth = false;

            if (empty($_SESSION['auth']) || $_SESSION['auth'] == false) {
                $auth = false;
            } else if ($_SESSION['auth'] == true) {
                $auth = true;
            }
            return $auth;
        }
    }
?>