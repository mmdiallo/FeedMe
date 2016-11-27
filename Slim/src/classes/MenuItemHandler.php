<?php
    class MenuItemHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllIds($menu_id) {
            $ids = array();
            $statement = 'SELECT id FROM MenuItems WHERE menu_id=:menu_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':menu_id', $menu_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                
                while ($row = $query_result->fetchArray()) {
                    $ids[] = $row['id'];
                }
            }

            return $ids;
        }

        public function getName($id) {
            $name = '';
            $statement = 'SELECT name FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $name = $row['name'];
            }

            if ($name == '') {
                $name = NULL;
            }

            return $name;
        }

        public function getPrice($id) {
            $price = -1;
            $statement = 'SELECT price FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $price = $row['price'];
            }

            if ($price == -1) {
                $price = NULL;
            }

            return $price;
        }

        public function getDescription($id) {
            $description = '';
            $statement = 'SELECT description FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $description = $row['description'];
            }

            if ($description == '') {
                $description = NULL;
            }

            return $description;
        }

        public function getImagePath($id) {
            $image_path = '';
            $statement = 'SELECT image_path FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $image_path = $row['image_path'];

                if (!file_exists($image_path)) {
                    $this->updateImagePath($id, '../images/menu_items/default-menu-item-image.jpg');
                    $image_path = '../images/menu_items/default-menu-item-image.jpg';
                }
            }

            if ($image_path == '') {
                $image_path = NULL;
            }

            return $image_path;
        }

        private function updateImagePath($id, $image_path) {
            $success = false;
            $statement = 'UPDATE MenuItems SET image_path=:image_path WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':image_path', $image_path, SQLITE3_TEXT);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($prepared_statement->execute()) {
                $success = true;
            }

            return $success;
        }

        public function getCuisineTypeId($id) {
            $cuisine_type_id = -1;
            $statement = 'SELECT cuisine_type_id FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $cuisine_type_id = $row['cuisine_type_id'];
            }

            if ($cuisine_type_id == -1) {
                $cuisine_type_id = NULL;
            }

            return $cuisine_type_id;
        }

        public function getMealTypeId($id) {
            $meal_type_id = -1;
            $statement = 'SELECT meal_type_id FROM MenuItems WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $meal_type_id = $row['meal_type_id'];
            }

            if ($meal_type_id == -1) {
                $meal_type_id = NULL;
            }

            return $meal_type_id;
        }

        public function addMenuItem($menu_id, $name, $cuisine_type, $meal_type, $price, $description, $image_path) {
            $success = false;
            $valid_pattern = '/^([A-Za-z]+ *)+$/';
            $valid_name = preg_match($valid_pattern, $name);
            $valid_cuisine_type = preg_match($valid_pattern, $cuisine_type);
            $valid_meal_type = preg_match($valid_pattern, $meal_type);
            $valid_price_pattern = '/^\d+(.\d{2})?$/';
            $valid_price = preg_match($valid_price_pattern, $price);

            if ($valid_name && $valid_cuisine_type && $valid_meal_type && $valid_price) {
                $price = floatval($price);
                $cuisine_type = strtolower($cuisine_type);
                $cuisine_type_handler = new CuisineTypeHandler($this->db);
                $cuisine_type_id = $cuisine_type_handler->getId($cuisine_type);

                if ($cuisine_type_id == -1 || $cuisine_type_id == NULL) {
                    $cuisine_type_add = $cuisine_type_handler->addType($cuisine_type);

                    if ($cuisine_type_add) {
                        $cuisine_type_id = $cuisine_type_handler->getId($cuisine_type);
                    }
                }

                $meal_type = strtolower($meal_type);
                $meal_type_handler = new MealTypeHandler($this->db);
                $meal_type_id = $meal_type_handler->getId($meal_type);

                if ($cuisine_type_id != NULL && $cuisine_type_id != -1) {

                    if ($meal_type_id != NULL && $meal_type_id != -1) {

                        if ($menu_id != NULL && $menu_id != -1) {
                            $statement = 'INSERT OR IGNORE INTO MenuItems(name, menu_id, cuisine_type_id, meal_type_id, price, description, image_path) VALUES(:name, :menu_id, :cuisine_type_id, :meal_type_id, :price, :description, :image_path)';
                            $prepared_statement = $this->db->prepare($statement);
                            $prepared_statement->bindValue(':name', $name, SQLITE3_TEXT);
                            $prepared_statement->bindValue(':menu_id', $menu_id, SQLITE3_INTEGER);
                            $prepared_statement->bindValue(':cuisine_type_id', $cuisine_type_id, SQLITE3_INTEGER);
                            $prepared_statement->bindValue(':meal_type_id', $meal_type_id, SQLITE3_INTEGER);
                            $prepared_statement->bindValue(':price', $price, SQLITE3_FLOAT);
                            $prepared_statement->bindValue(':description', $description, SQLITE3_TEXT);
                            $prepared_statement->bindValue(':image_path', $image_path, SQLITE3_TEXT);

                            if ($prepared_statement->execute()) {
                                $success = true;
                            }
                        }
                    }
                }
            }

            return $success;
        }
    }
?>