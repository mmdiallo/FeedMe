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

        public function createAccount($username, $password_hash, $password_salt, $account_type_id {
            
        }

    }
?>