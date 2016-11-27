<?php
    class RestaurantHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getId($account_id) {
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

        public function getEmail($id) {
            $email = '';
            $statement = 'SELECT email FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $email = $row['email'];
            }

            return $email;
        }

        public function getName($id) {
            $name = '';
            $statement = 'SELECT name FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $name = $row['name'];
            }

            return $name;
        }

        public function getStreetAddress($id) {
            $street_address = '';
            $statement = 'SELECT street_address FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $street_address = $row['street_address'];
            }

            return $street_address;
        }

        public function getCity($id) {
            $city = '';
            $statement = 'SELECT city FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $city = $row['city'];
            }

            return $city;
        }

        public function getState($id) {
            $state = '';
            $statement = 'SELECT state FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $state = $row['state'];
            }

            return $state;
        }

        public function getPhoneNumber($id) {
            $phone_number = -1;
            $statement = 'SELECT phone_number FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $phone_number = $row['phone_number'];
            }

            return $phone_number;
        }

        public function getCuisineTypeId($id) {
            $cuisine_type_id = -1;
            $statement = 'SELECT cuisine_type_id FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $cuisine_type_id = $row['cuisine_type_id'];
            }

            return $cuisine_type_id;
        }

        public function getPriceRatingId($id) {
            $price_rating_id = -1;
            $statement = 'SELECT price_rating_id FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $price_rating_id = $row['price_rating_id'];
            }

            return $price_rating_id;
        }

        public function getWebsiteURL($id) {
            $website_url = '';
            $statement = 'SELECT website_url FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $website_url = $row['website_url'];
            }

            return $website_url;
        }

        public function getBiography($id) {
            $biography = '';
            $statement = 'SELECT biography FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $biography = $row['biography'];
            }

            return $biography;
        }

        public function getProfileImagePath($id) {
            $image_path = '';
            $statement = 'SELECT profile_image_path FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $image_path = $row['profile_image_path'];

                if (!file_exists($image_path)) {
                    $this->updateProfileImagePath($id, '../images/restaurants/default-restaurant-image.jpg');
                    $image_path = '../images/restaurants/default-restaurant-image.jpg';
                }
            }

            return $image_path;
        }

        public function updateProfileImagePath($restaurant_id, $profile_image_path) {
            $success = false;
            $statement = 'UPDATE Restaurants SET profile_image_path=:profile_image_path WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':profile_image_path', $profile_image_path, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $restaurant_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

    }
?>