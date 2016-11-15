<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS MenuItems (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                name TEXT NOT NULL,
                menu_id INTEGER NOT NULL,
                cuisine_type_id INTEGER,
                meal_type_id INTEGER,
                price FLOAT NOT NULL,
                description TEXT,
                image_path TEXT,
                FOREIGN KEY(menu_id) REFERENCES Menus(id),
                FOREIGN KEY(cuisine_type_id) REFERENCES CuisineTypes(id),
                FOREIGN KEY(meal_type_id) REFERENCES MealTypes(id))';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }
        
        echo '<br>';
        echo '<a href=""></a>';

    //}
?>