<?php
    class DatabaseCreation {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function createTable($table_number) {
            $result = ''; 

            switch ($table_number) {

                case 0:
                    $result = $result . $this->createAccountTypesTable();
                    break;

                case 1:
                    $result = $result . $this->createAccountsTable();
                    break;

                case 2:
                    $result = $result . $this->createUsersTable();
                    break;

                case 3:
                    $result = $result . $this->createPersonalMenusTable();;
                    break;

                case 4:
                    $result = $result . $this->createCuisineTypesTable();
                    break;

                case 5:
                    $result = $result . $this->createPriceRatingsTable();
                    break;

                case 6:
                    $result = $result . $this->createRestaurantsTable();
                    break;

                case 7:
                    $result = $result . $this->createMenusTable();
                    break;

                case 8:
                    $result = $result . $this->createHoursTable();
                    break;

                case 9:
                    $result = $result . $this->createMealTypesTable();
                    break;

                case 10:
                    $result = $result . $this->createMenuItemsTable();
                    break;

                case 11:
                    $result = $result . $this->createPersonalMenuItemsTable();
                    break;

                default:
                    $result = $result . 'invalid request';  
            }

            return $result;
        }

        private function createAccountTypesTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS AccountTypes (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                type TEXT UNIQUE NOT NULL)';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
                $create_type_user = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'user\')';
                $create_type_restaurant = 'INSERT OR IGNORE INTO AccountTypes(type) VALUES(\'restaurant\')';
                
                if ($this->db->query($create_type_user) && $this->db->query($create_type_restaurant)) {
                    $result = $result .'Type creation successful!' . '<br>';
                }
            }

            return $result;
        }

        private function createAccountsTable() {
            $result = '';
            $enable_foreign_keys = 'PRAGMA foreign_keys = ON';

            if ($this->db->query($enable_foreign_keys)) {
                $result = $result .  'Foreign keys enabled.' . '<br>';
            }

            $create_table = 'CREATE TABLE IF NOT EXISTS Accounts (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
                username TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                password_salt TEXT NOT NULL,
                account_type_id INTEGER NOT NULL,
                FOREIGN KEY(account_type_id) REFERENCES AccountTypes(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createUsersTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS PersonalMenus (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                account_id INTEGER UNIQUE NOT NULL,
                email TEXT UNIQUE,
                first_name TEXT,
                last_name TEXT,
                profile_image_path TEXT,
                FOREIGN KEY(account_id) REFERENCES Accounts(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }   

        private function createPersonalMenusTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS PersonalMenus (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                user_id INTEGER UNIQUE NOT NULL,
                FOREIGN KEY(user_id) REFERENCES Users(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }   

        private function createCuisineTypesTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS CuisineTypes (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                type TEXT UNIQUE NOT NULL)';
            
            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createPriceRatingsTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS PriceRatings (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                rating INT UNIQUE NOT NULL,
                lowest_price FLOAT NOT NULL,
                highest_price FLOAT NOT NULL)';

            if ($this->db->query($create_table)) {
                $result = $result .  'Table creation sucessful!' . '<br>';
                $create_price_rating_1 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(1, 0.00, 10.00)';
                $create_price_rating_2 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(2, 10.00, 25.00)';
                $create_price_rating_3 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(3, 25.00, 50.00)';
                $create_price_rating_4 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(4, 50.00, 75.00)';
                $create_price_rating_5 = 'INSERT OR IGNORE INTO PriceRatings(rating, lowest_price, highest_price) VALUES(5, 75.00, 100.00)';
                
                if ($this->db->query($create_price_rating_1) && $this->db->query($create_price_rating_2) && $this->db->query($create_price_rating_3) && $this->db->query($create_price_rating_4) && $this->db->query($create_price_rating_5)) {
                    $result = $result . 'Rating creations successful!' . '<br>';
                } 
            }

            return $result;
        }

        private function createRestaurantsTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS Restaurants (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                account_id INTEGER UNIQUE NOT NULL,
                email TEXT UNIQUE,
                name TEXT,
                street_address TEXT UNIQUE,
                city TEXT,
                state TEXT,
                phone_number TEXT,
                cuisine_type_id INTEGER,
                price_rating_id INTEGER,
                website_url TEXT UNIQUE,
                biography TEXT,
                profile_image_path TEXT,
                FOREIGN KEY(account_id) REFERENCES Accounts(id),
                FOREIGN KEY(cuisine_type_id) REFERENCES CuisineTypes(id),
                FOREIGN KEY(price_rating_id) REFERENCES PriceRatings(id))';
           
            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createMenusTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS Menus (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                restaurant_id INTEGER UNIQUE NOT NULL,
                FOREIGN KEY(restaurant_id) REFERENCES Restaurants(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createHoursTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS Hours (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                restaurant_id INTEGER UNIQUE NOT NULL,
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
                sunday_close TEXT,
                FOREIGN KEY(restaurant_id) REFERENCES Restaurants(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createMealTypesTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS Menus (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                restaurant_id INTEGER UNIQUE NOT NULL,
                FOREIGN KEY(restaurant_id) REFERENCES Restaurants(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createMenuItemsTable() {
            $result = '';
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

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createPersonalMenuItemsTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS Hours (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                restaurant_id INTEGER UNIQUE NOT NULL,
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
                sunday_close TEXT,
                FOREIGN KEY(restaurant_id) REFERENCES Restaurants(id))';

            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
            }

            return $result;
        }

        private function createMealTypesTable() {
            $result = '';
            $create_table = 'CREATE TABLE IF NOT EXISTS MealTypes (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                type TEXT UNIQUE NOT NULL)';
            
            if ($this->db->query($create_table)) {
                $result = $result . 'Table creation sucessful!' . '<br>';
                $create_type_breakfast = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'breakfast\')';
                $create_type_lunch = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'lunch\')';
                $create_type_dinner = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'dinner\')';
                $create_type_beverage = 'INSERT OR IGNORE INTO MealTypes(type) VALUES(\'beverage\')';
                
                if ($this->db->query($create_type_breakfast) && $this->db->query($create_type_lunch) && $this->db->query($create_type_dinner) && $this->db->query($create_type_beverage)) {
                    $result = $result . 'Type creation successful!' . '<br>';
                }
            }

            return $result;
        }
    }
?>