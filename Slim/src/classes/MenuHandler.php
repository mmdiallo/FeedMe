<?php
    class MenuHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getId($restaurant_id) {
            $id = -1;
            $statement = 'SELECT id FROM Menus WHERE restaurant_id=:restaurant_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':restaurant_id', $restaurant_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }
    }
?>