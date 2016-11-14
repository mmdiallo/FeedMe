<?php
    require 'database_config.php';

    if (empty($_SERVER['HTTPS'])) {
        exit;
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            echo 'GET';
            echo $db_filename;
        }
        echo 'HTTPS';
        
    }
?>