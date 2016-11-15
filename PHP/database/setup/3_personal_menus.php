<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS PersonalMenus (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }

        echo '<br>';
        echo '<a href=""></a>';
        
    //}
?>