<?php
    class AccountHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function createUserAccount($username, $password) {
            $success = false;

            $valid_username = $this->validateNewUsername($username);

            if ($valid_username) {
                $password_salt = $this->createPasswordSalt();
                $password_hash = $this->hashPassword($password, $password_salt);
                $account_type_id = $this->getAccountTypeId('user');

                if ($account_type_id != -1) {
                    $account_creation_success = $this->createAccount($username, $password_hash, $password_salt, $account_type_id);

                    if ($account_creation_success) {
                        $success = true;
                    }
                }
            }
            return $success;
        }

        public function createRestaurantAccount($username, $password) {
            $success = false;

            $valid_username = $this->validateNewUsername($username);

            if ($valid_username) {
                $password_salt = $this->createPasswordSalt();
                $password_hash = $this->hashPassword($password, $password_salt);
                $account_type_id = $this->getAccountTypeId('restaurant');

                if ($account_type_id != -1) {
                    $account_creation_success = $this->createAccount($username, $password_hash, $password_salt, $account_type_id);

                    if ($account_creation_success) {
                        $success = true;
                    }
                }
            }
            return $success;
        }

        public function login($username, $password) {
            $success = false;
            $account_id = $this->getAccountId($username);

            if ($account_id != -1) {
                $password_salt = $this->getPasswordSalt($account_id);
                $password_hash = $this->getPasswordHash($account_id);
                $salt = $this->getSaltedPassword($password, $password_salt);
                $valid_password = password_verify($salt, $password_hash);

                if ($valid_password) {
                    $success = true;
                }
            }
            
            return $success;
        }

        private function getNumberOfResults($query_result) {
            var_dump($query_result);
            echo '<br>';
            $count = 0;
            if ($query_result != NULL) {
                while ($row = $query_result->fetchArray()) {
                    var_dump($row);
                    echo '<br>';
                    $count += 1;
                }
            }
            $query_result->reset();
            return $count;
        }

        public function getAccountInformation($username) {
            $information = array();
            $account_id = $this->getAccountId($username);
            $information['account_id'] = $account_id;
            $account_type = $this->getAccountType($account_id);
            $information['account_type'] = $account_type;

            if ($account_type == 'user') {
                $user_id = $this->getUserId($account_id);
                $information['user_id'] = $user_id;
            } else if ($account_type == 'restaurant') {
                $restaurant_id = $this->getRestaurantId($account_id);
                $information['restaurant_id'] = $restaurant_id;
            } 

            return $information;
        }

        private function validateNewUsername($username) {
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

        private function createPasswordSalt() {
            $random_string = uniqid();
            $password_salt = hash('sha256', $random_string);
            return $password_salt;
        }

        private function getPasswordSalt($account_id) {
            $password_salt = '';
            $statement = 'SELECT password_salt FROM Accounts WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $password_salt = $password_salt . $row['password_salt'];
            }

            return $password_salt;
        }

        private function getSaltedPassword($password, $password_salt) {
            $initial_hash = hash('sha256', $password);
            $salt = $password_salt . $initial_hash . $password_salt;
            return $salt;
        }

        private function hashPassword($password, $password_salt) {
            $initial_hash = hash('sha256', $password);
            $salt = $password_salt . $initial_hash . $password_salt;
            $salted_hash = password_hash($salt, PASSWORD_DEFAULT);
            return $salted_hash;
        }

        private function getPasswordHash($account_id) {
            $password_hash = '';
            $statement = 'SELECT password_hash FROM Accounts WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $password_hash = $password_hash . $row['password_hash'];
            }

            return $password_hash;
        }

        // ACCOUNT TYPES HANDLER ==================================================================

        private function getAccountType($account_id) {
            $type = '';
            $account_statement = 'SELECT account_type_id FROM Accounts WHERE id=:id';
            $account_prepared_statement = $this->db->prepare($account_statement);
            $account_prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);

            if ($account_query_result = $account_prepared_statement->execute()) {
                $account_row = $account_query_result->fetchArray();
                $account_type_id = $account_row['account_type_id'];
                $account_types_statement = 'SELECT type FROM AccountTypes WHERE id=:id';
                $account_types_prepared_statement = $this->db->prepare($account_types_statement);
                $account_types_prepared_statement->bindValue(':id', $account_type_id, SQLITE3_INTEGER);

                if ($account_types_query_result = $account_types_prepared_statement->execute()) {
                    $account_types_row = $account_types_query_result->fetchArray();
                    $type = $type . $account_types_row['type'];
                }

            }

            return $type;
        }

        private function getAccountTypeId($type) {
            $id = -1;
            $query = '';

            if ($type == 'user') {
                $query = 'SELECT id FROM AccountTypes WHERE type="user"';
            } else if ($type == 'restaurant') {
                $query = 'SELECT id FROM AccountTypes WHERE type="restaurant"';
            }

            if ($query_result = $this->db->query($query)) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        // ========================================================================================

        private function createAccount($username, $password_hash, $password_salt, $account_type_id) {
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

        private function getAccountId($username) {
            $id = -1;
            $statement = 'SELECT id FROM Accounts WHERE username=:username';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':username', $username, SQLITE3_TEXT);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        } 

        // USERS HANDLER =========================================================================

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

        private function getUserId($account_id) {
            $id = -1;
            $statement = 'SELECT id FROM Users WHERE account_id=:account_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        // PERSONAL MENU HANDLER =================================================================

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

        //  RESTAURANTS HANDLER ===================================================================

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


        private function getRestaurantId($account_id) {
            $id = -1;
            $statement = 'SELECT id FROM Restaurants WHERE account_id=:account_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        // MENUS HANDLER ==========================================================================

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

        // HOURS HANDLER ==========================================================================

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