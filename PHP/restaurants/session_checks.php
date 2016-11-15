<?php
    function authenticatedSession() {
        $authenticated = false;
        if (empty($_SESSION['authenticated']) || $_SESSION['authenticated'] == false) {
            $authenticated = false;
        } else if ($_SESSION['authenticated'] == true) {
            $authenticated = true;
        }
        return $authenticated;
    }
?>