<?php
    class MealTypeHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllMealTypes() {
            $meal_types = array();
            $statement = 'SELECT * FROM MealTypes';

            if ($query_result = $this->db->query($statement)) {

                while ($row = $query_result->fetchArray()) {
                    $meal_types[] = $row['type'];
                }
            }

            return $meal_types;
        }

        public function getId($type) {
            $id = -1;
            $statement = 'SELECT id FROM MealTypes WHERE type=:type';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':type', $type, SQLITE3_TEXT);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        public function getType($id) {
            $type = '';
            $statement = 'SELECT type FROM MealTypes WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $type = $type . $row['type'];
            }

            if ($type == '') {
                $type = NULL;
            }

            return $type;
        }
    }
?>