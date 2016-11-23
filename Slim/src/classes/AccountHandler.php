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
            $statement = 'INSERT INTO Accounts(username, password_hash, password_salt, account_type_id) VALUES(:username, :password_hash, :password_salt, :account_type_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':username', $username, SQLITE3_TEXT);
            $prepared_statement->bindValue(':password_hash', $password_hash, SQLITE3_TEXT);
            $prepared_statement->bindValue(':password_salt', $password_salt, SQLITE3_TEXT);
            $prepared_statement->bindValue(':account_type_id', $account_type_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $account_id = getAccountId($username);

                if ($account_id != -1) {
                    $success = createUser($account_id);
                }
                
            }

            return $success;
        }

        private function getAccountId($username) {
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
            $statement = 'INSERT INTO Users(account_id) VALUES(:account_id)';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':account_id', $account_id, SQLITE3_INTEGER);
            if ($prepared_statement->execute()) {
                $user_id = getUserId($account_id);
                $success = createPersonalMenu($user_id);

            }
            return $success;
        }

        private function getUserId($account_id) {

        }

        private function createPersonalMenu($user_id) {

        }

    }
?>