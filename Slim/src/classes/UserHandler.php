<?php
    class UserHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getId($account_id) {
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

        public function getEmail($id) {
            $email = '';
            $statement = 'SELECT email FROM Users where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $email = $row['email'];
            }

            return $email;
        }

        public function getFirstName($id) {
            $first_name = '';
            $statement = 'SELECT first_name FROM Users where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $first_name = $row['first_name'];
            }

            return $first_name;
        }

        public function getLastName($id) {
            $last_name = '';
            $statement = 'SELECT last_name FROM Users where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $last_name = $row['last_name'];
            }

            return $last_name;
        }

        public function getProfileImagePath($id) {
            $image_path = '';
            $statement = 'SELECT profile_image_path FROM Users where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $image_path = $row['profile_image_path'];
            }

            return $image_path;
        }
    }
?>