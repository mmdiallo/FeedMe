<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS Hours (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                monday_open TEXT,
                monday_close TEXT,
                tuesday_open TEXT,
                tuesday_close TEXT,
                wednesday_open TEXT,
                wednesday_close TEXT,
                thursday_open TEXT,
                thursday_close TEXT,
                friday_open TEXT,
                friday_close TEXT,
                saturday_open TEXT,
                saturday_close TEXT,
                sunday_open TEXT,
                sunday_close TEXT)';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }

        echo '<br>';
        echo '<a href=""></a>';
        
    //}
?>