<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS MealTypes (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                type TEXT UNIQUE NOT NULL)';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';

                $create_type_breakfast = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'breakfast\')';
                $create_type_lunch = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'lunch\')';
                $create_type_dinner = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'dinner\')';
                $create_type_beverage = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'beverage\')';

                if ($conn->query($create_type_breakfast) && $conn->query($create_type_lunch) && $conn->query($create_type_dinner) && $conn->query($create_type_beverage)) {
                    echo 'Type creation successful!' . '<br>';
                }

            }

            $conn->close();
        }
        
        echo '<br>';
        echo '<a href="11_menu_items.php">Menu Items</a>';

    //}
?>