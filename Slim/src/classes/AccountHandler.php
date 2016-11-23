<?php
    class AccountHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function validateUsername($username) {
            $valid = false;
            $valid_username_pattern = '/^[a-zA-Z][\w]*$/';

            if (preg_match($valid_username_pattern, $username)) {

                $statement = 'SELECT * FROM Accounts WHERE username=:username';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':username', $username, SQLITE3_TEXT);

                if ($query_result = $prepared_statement->execute()) {

                    $result_count = 0;

                    while ($row = $query_result->fetchArray()) {
                        $result_count += 1;
                    }

                    if ($result_count == 0) {
                        $valid = true;
                    }

                }
            }

            return $valid;

        }

        public function createPasswordSalt() {
            $random_string = uniqid();
            $password_salt = hash('sha256', $random_string);
            return $password_salt;
        }

        public function hashPassword($password, $password_salt) {
            $initial_hash = hash('sha256', $password);
            $salt = $password_salt . $initial_hash . $password_salt;
            $salted_hash = password_hash($salt, PASSWORD_BCRYPT);
            return $salted_hash;
        }

        public function getAccountTypeId($type) {
            $id = -1;
            $query = '';

            if ($type == 'user') {
                $query = 'SELECT id FROM AccountTypes WHERE type="user"';
            } else if ($type == 'restaurant') {
                $query = 'SELECT id FROM AccountTypes WHERE type="restaurant"';
            }

            if ($query_results = $this->db->query($query)) {
                $row = $query_results->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        public function createAccount($username, $password_hash, $password_salt, $account_type_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO Accounts(username, password_hash, password_salt, account_type_id) VALUES(:username, :password_hash, :password_salt, :account_type_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':username', $username, SQLITE3_TEXT);
            $prepared_statement->bindValue(':password_hash', $password_hash, SQLITE3_TEXT);
            $prepared_statement->bindValue(':password_salt', $password_salt, SQLITE3_TEXT);
            $prepared_statement->bindValue(':account_type_id', $account_type_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $account_id = $this->getAccountId($username);

                if ($account_id != -1) {

                    if ($account_type_id == $this->getAccountTypeId('user')) {
                        $success = $this->createUser($account_id);
                    } else if ($account_type_id == $this->getAccountTypeId('restaurant')) {
                        $success = $this->createRestaurant($account_id);
                    }
                    
                }
                
            }

            return $success;
        }

        public function getAccountId($username) {
            $id = -1;
            $statement = 'SELECT id FROM Accounts WHERE username=:username';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':username', $username, SQLITE3_TEXT);

            if ($query_results = $prepared_statement->execute()) {
                $row = $query_results->fetchArray();
                $id = $row['id'];
            }

            return $id;
        } 

        private function createUser($account_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO Users(account_id, profile_image_path) VALUES(:account_id, "../images/users/default-user-image.jpg")';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $user_id = $this->getUserId($account_id);

                if ($user_id != -1) {
                    $success = $this->createPersonalMenu($user_id);
                }
            }

            return $success;
        }

        public function getUserId($account_id) {
            $id = -1;
            $statement = 'SELECT id FROM Users WHERE account_id=:account_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($query_results = $prepared_statement->execute()) {
                $row = $query_results->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        private function createPersonalMenu($user_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO PersonalMenus(user_id) VALUES(:user_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':user_id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        private function createRestaurant($account_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO Restaurants(account_id, profile_image_path) VALUES(:account_id, "../images/restaurants/default-restaurant-image.jpg")';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $restaurant_id = $this->getRestaurantId($account_id);

                if ($restaurant_id != -1) {
                    $success = $this->createMenu($restaurant_id) && $this->createHours($restaurant_id);
                }
            }

            return $success;
        }

        public function getRestaurantId($account_id) {
            $id = -1;
            $statement = 'SELECT id FROM Restaurants WHERE account_id=:account_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($query_results = $prepared_statement->execute()) {
                $row = $query_results->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        private function createMenu($restaurant_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO Menus(restaurant_id) VALUES(:restaurant_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':restaurant_id', $restaurant_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        private function createHours($restaurant_id) {
            $success = false;
            $statement = 'INSERT OR IGNORE INTO Hours(restaurant_id) VALUES(:restaurant_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':restaurant_id', $restaurant_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }
    }
?>