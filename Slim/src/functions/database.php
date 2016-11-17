<?php
    function createTable($db, $table_number) {
        $result = ''; 
        switch ($table_number) {

            case 0:
                $result = $result . createAccountTypesTable($db);
                break;

            case 1:
                $result = $result . createAccountsTable($db);
                break;

            case 2:
                $result = $result . createPersonalMenusTable($db);
                break;

            case 3:
                $result = $result . createUsersTable($db);
                break;

            case 4:
                $result = $result . createMenusTable($db);
                break;

            case 5:
                $result = $result . createCuisineTypesTable($db);
                break;

            case 6:
                $result = $result . createPriceRatingsTable($db);
                break;

            case 7:
                //$result = $result .
                break;

            case 8:
                //$result = $result .
                break;

            case 9:
                //$result = $result .
                break;

            case 10:
                //$result = $result .
                break;

            case 11:
                //$result = $result .
                break;

            default:
                $result = $result . 'invalid request';  
        }
        return $result;
    }

    function createAccountTypesTable($db) {
        $result = '';
        $create_table = 'CREATE TABLE IF NOT EXISTS AccountTypes (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            type TEXT UNIQUE NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
            $create_type_user = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'user\')';
            $create_type_restaurant = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'restaurant\')';
            
            if ($db->query($create_type_user) && $db->query($create_type_restaurant)) {
                $result = $result .'Type creation successful!' . '<br>';
            }
        }

        return $result;
    }

    function createAccountsTable($db) {
        $result = '';
        $enable_foreign_keys = 'PRAGMA foreign_keys = ON';

        if ($db->query($enable_foreign_keys)) {
            $result = $result .  'Foreign keys enabled.' . '<br>';
        }

        $create_table = 'CREATE TABLE IF NOT EXISTS Accounts (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
            username TEXT UNIQUE NOT NULL,
            password_hash TEXT NOT NULL,
            password_salt TEXT NOT NULL,
            account_type_id INTEGER NOT NULL,
            FOREIGN KEY(account_type_id) REFERENCES AccountTypes(id))';
        
        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
        }
        return $result;
    }

    function createPersonalMenusTable($db) {
        $result = '';
        $create_table = 'CREATE TABLE IF NOT EXISTS PersonalMenus (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
        }
        return $result;
    }

    function createUsersTable($db) {
        $result = '';
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

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
        }
        return $result;
    }

    function createMenusTable($db) {
        $result = '';
        $create_table = 'CREATE TABLE IF NOT EXISTS Menus (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
        }
        return $result;
    }

    function createCuisineTypesTable($db) {
        $result = '';
        $create_table = 'CREATE TABLE IF NOT EXISTS CuisineTypes (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            type TEXT UNIQUE NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result . 'Table creation sucessful!' . '<br>';
        }
        return $result;
    }

    function createPriceRatingsTable($db) {
        $result = '';

        $create_table = 'CREATE TABLE IF NOT EXISTS PriceRatings (
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            rating INT UNIQUE NOT NULL,
            lowest_price FLOAT NOT NULL,
            highest_price FLOAT NOT NULL)';

        if ($db->query($create_table)) {
            $result = $result .  'Table creation sucessful!' . '<br>';
            
            $create_price_rating_1 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(1, 0.00, 10.00)';
            $create_price_rating_2 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(2, 10.00, 25.00)';
            $create_price_rating_3 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(3, 25.00, 50.00)';
            $create_price_rating_4 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(4, 50.00, 75.00)';
            $create_price_rating_5 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(5, 75.00, 100.00)';
            
            if ($db->query($create_price_rating_1) && $db->query($create_price_rating_2) && $db->query($create_price_rating_3) && $db->query($create_price_rating_4) && $db->query($create_price_rating_5)) {
                $result = $result . 'Rating creations successful!' . '<br>';
            } 
        }
        return $result;
    }

    function createHoursTable($db) {
        $result = '';
        return $result;
    }

    function createRestaurantsTable($db) {
        $result = '';
        return $result;
    }

    function createMealTypesTable($db) {
        $result = '';
        return $result;
    }

    function createMenuItemsTable($db) {
        $result = '';
        return $result;
    }

    function createPersonalMenuItemsTable($db) {
        $result = '';
        return $result;
    }
?>