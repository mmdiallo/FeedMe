<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS Users (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                account_id INTEGER UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                first_name TEXT NOT NULL,
                last_name TEXT NOT NULL,
                personal_menu_id INTEGER UNIQUE NOT NULL,
                profile_image_path TEXT,
                FOREIGN KEY(account_id) REFERENCES Accounts(id),
                FOREIGN KEY(personal_menu_id) REFERENCES PersonalMenus(id))';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }
        
        echo '<br>';
        echo '<a href=""></a>';

    //}
?>