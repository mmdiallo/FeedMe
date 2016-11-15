<?php
    require 'database_config.php';

    //if (empty($_SERVER['HTTPS'])) {
        //exit;
    //} else {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $conn = new SQLite3($db_filename);

            $create_table = 'CREATE TABLE IF NOT EXISTS PriceRatings (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                rating INT UNIQUE NOT NULL,
                lowest_price FLOAT NOT NULL,
                highest_price FLOAT NOT NULL)';

            if ($conn->query($create_table)) {
                echo 'Table creation sucessful!' . '<br>';

                $create_price_rating_1 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(1, 0.00, 10.00)';
                $create_price_rating_2 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(2, 10.00, 25.00)';
                $create_price_rating_3 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(3, 25.00, 50.00)';
                $create_price_rating_4 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(4, 50.00, 75.00)';
                $create_price_rating_5 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(5, 75.00, 100.00)';

                if ($conn->query($create_price_rating_1) && $conn->query($create_price_rating_2) && $conn->query($create_price_rating_3) && $conn->query($create_price_rating_4) && $conn->query($create_price_rating_5)) {
                    echo 'Rating creations successful!' . '<br>';
                } 
            }

            $conn->close();
        }

        echo '<br>';
        echo '<a href="8_hours.php">Hours</a>';
        
    //}
?>