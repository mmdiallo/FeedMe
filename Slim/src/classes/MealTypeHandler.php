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
    }

?>