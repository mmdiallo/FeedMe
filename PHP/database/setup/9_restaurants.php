<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS Restaurants (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                account_id INTEGER UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                name TEXT NOT NULL,
                street_address TEXT UNIQUE,
                city TEXT,
                state TEXT,
                phone_number TEXT,
                hours_id INTEGER UNIQUE NOT NULL,
                menu_id INTEGER UNIQUE NOT NULL,
                cuisine_type_id INTEGER,
                price_rating_id INTEGER,
                website_url TEXT UNIQUE,
                biography TEXT,
                profile_image_path TEXT,
                FOREIGN KEY(account_id) REFERENCES Accounts(id),
                FOREIGN KEY(menu_id) REFERENCES Menus(id)
                FOREIGN KEY(hours_id) REFERENCES Hours(id),
                FOREIGN KEY(cuisine_type_id) REFERENCES CuisineTypes(id),
                FOREIGN KEY(price_rating_id) REFERENCES PriceRatings(id))';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';
            }

            $conn->close();
        }
        
        echo '<br>';
        echo '<a href="10_meal_types.php">Meal Types</a>';

    //}
?>