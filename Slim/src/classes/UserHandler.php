<?php
    class UserHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllIds() {
            $ids = array();
            $statement = 'SELECT id FROM Users';

            if ($query_result = $this->db->query($statement)) {

                while ($row = $query_result->fetchArray()) {
                    $ids[] = $row['id'];
                }
            }

            return $ids;
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

                if (!file_exists($image_path)) {
                    $this->updateProfileImagePath($id, '../images/users/default-user-image.jpg');
                    $image_path = '../images/users/default-user-image.jpg';
                }
            }

            return $image_path;
        }

        public function updateEmail($user_id, $email) {
            $success = false;
            $statement = 'UPDATE Users SET email=:email WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':email', $email, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateFirstName($user_id, $first_name) {
            $success = false;
            $statement = 'UPDATE Users SET first_name=:first_name WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':first_name', $first_name, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateLastName($user_id, $last_name) {
            $success = false;
            $statement = 'UPDATE Users SET last_name=:last_name WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':last_name', $last_name, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateProfileImagePath($user_id, $profile_image_path) {
            $success = false;
            $statement = 'UPDATE Users SET profile_image_path=:profile_image_path WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':profile_image_path', $profile_image_path, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

    }
?>