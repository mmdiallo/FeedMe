<?php
    class RestaurantHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllIds() {
            $ids = array();
            $statement = 'SELECT id FROM Restaurants';

            if ($query_result = $this->db->query($statement)) {

                while ($row = $query_result->fetchArray()) {
                    $ids[] = $row['id'];
                }
            }

            return $ids;
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

        public function getTimeOpen($id) {
            $time_open = -1;
            $statement = 'SELECT time_open FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $time_open = $row['time_open'];
            }

            return $time_open;
        }

        public function getTimeClose($id) {
            $time_close = -1;
            $statement = 'SELECT time_close FROM Restaurants where id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $time_close = $row['time_close'];
            }

            return $time_close;
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

        public function updateProfileImagePath($id, $profile_image_path) {
            $success = false;
            $statement = 'UPDATE Restaurants SET profile_image_path=:profile_image_path WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':profile_image_path', $profile_image_path, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateEmail($id, $email) {
            $success = false;
            $statement = 'UPDATE Restaurants SET email=:email WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':email', $email, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateName($id, $name) {
            $success = false;
            $name_match = '/^([A-Za-z]+ *)+$/';

            if (preg_match($name_match, $name)) {
                $statement  = 'UPDATE Restaurants SET name=:name WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':name', $name, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            } 

            return $success;
        }

        public function updateStreetAddress($id, $street_address) {
            $success = false;
            $statement = 'UPDATE Restaurants SET street_address=:street_address WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':street_address', $street_address, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateCity($id, $city) {
            $success = false;
            $city_match = '/^([A-Za-z]+ *)+$/';

            if (preg_match($city_match, $city)) {
                $statement  = 'UPDATE Restaurants SET city=:city WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':city', $city, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            } 

            return $success;
        }

        public function updateState($id, $state) {
            $success = false;
            $state_match = '/^([A-Za-z]+ *)+$/';

            if (preg_match($state_match, $state)) {
                $statement  = 'UPDATE Restaurants SET state=:state WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':state', $state, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            } 

            return $success;
        }

        public function updatePhoneNumber($id, $phone_number) {
            $success = false;
            $statement = 'UPDATE Restaurants SET phone_number=:phone_number WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':phone_number', $phone_number, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateWebsiteUrl($id, $website_url) {
            $success = false;
            $statement = 'UPDATE Restaurants SET website_url=:website_url WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':website_url', $website_url, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateBiography($id, $biography) {
            $success = false;
            $statement = 'UPDATE Restaurants SET biography=:biography WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':biography', $biography, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function updateTimeOpen($id, $time_open) {
            $success = false;
            $time_match = '/^\d{2}:\d{2} ?(AM|am|PM|pm)?$/';

            if (preg_match($time_match, $time_open)) {
                $statement  = 'UPDATE Restaurants SET time_open=:time_open WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':time_open', $time_open, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    echo 'yo';
                    $success = true;
                }
            } 

            return $success;
        }

        public function updateTimeClose($id, $time_close) {
            $success = false;
            $time_match = '/^\d{2}:\d{2} ?(AM|am|PM|pm)?$/';

            if (preg_match($time_match, $time_close)) {
                $statement  = 'UPDATE Restaurants SET time_close=:time_close WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':time_close', $time_close, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            } 

            return $success;
        }

        public function updatePriceRating($id, $price_rating) {
            $success = false;
            $price_rating_handler = new PriceRatingHandler($this->db);
            $price_rating_id = $price_rating_handler->getId($price_rating);

            if ($price_rating_id != -1 && $price_rating_id != NULL) {
                $statement = 'UPDATE Restaurants SET price_rating_id=:price_rating_id WHERE id=:id';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':price_rating_id', $price_rating_id, SQLITE3_TEXT);
                $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            }

            return $success;
        }

        public function updateCuisineType($id, $cuisine_type) {
            $success = false;
            $cuisine_type_match = '/^([A-Za-z]+ *)+$/';

            if (preg_match($cuisine_type_match, $cuisine_type)) {
                $cuisine_type = strtolower($cuisine_type);
                $cuisine_type_handler = new CuisineTypeHandler($this->db);
                $cuisine_type_id = $cuisine_type_handler->getId($cuisine_type);

                if ($cuisine_type_id == -1 || $cuisine_type_id == NULL) {
                    $cuisine_type_add = $cuisine_type_handler->addType($cuisine_type);

                    if ($cuisine_type_add) {
                        $cuisine_type_id = $cuisine_type_handler->getId($cuisine_type);
                    }
                }

                if ($cuisine_type_id != -1 && $cuisine_type_id != NULL) {
                    $statement = 'UPDATE Restaurants SET cuisine_type_id=:cuisine_type_id WHERE id=:id';
                    $prepared_statement = $this->db->prepare($statement);
                    $prepared_statement->bindValue(':cuisine_type_id', $cuisine_type_id, SQLITE3_TEXT);
                    $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

                    if ($prepared_statement->execute()) {
                        $success = true;
                    }
                }
            }

            return $success;
        }
    }
?>