<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS AccountTypes (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                type TEXT UNIQUE NOT NULL)';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
                
                $create_type_user = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'user\')';
                $create_type_restaurant = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'restaurant\')';

                if ($conn->query($create_type_user) && $conn->query($create_type_restaurant)) {
                    echo 'Type creation successful!';
                } 
            }

            $conn->close();
        }
        
    //}
?>