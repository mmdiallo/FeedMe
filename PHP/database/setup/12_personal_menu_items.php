<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS PersonalMenuItems (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                personal_menu_id INTEGER NOT NULL,
                menu_item_id INTEGER NOT NULL,
                FOREIGN KEY(personal_menu_id) REFERENCES PersonalMenus(id),
                FOREIGN KEY(menu_item_id) REFERENCES MenuItems(id))';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }
        
        echo '<br>';
        echo '<a href=""></a>';

    //}
?>