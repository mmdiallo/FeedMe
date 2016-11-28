<?php
    class CuisineTypeHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getType($id) {
            $type = '';
            $statement = 'SELECT type FROM CuisineTypes WHERE id=:id';
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

        public function getId($type) {
            $id = -1;
            $statement = 'SELECT id FROM CuisineTypes WHERE type=:type';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':type', $type, SQLITE3_TEXT);

            if ($query_result = $prepared_statement->execute()) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
        }

        public function addType($type) {
            $success = false; 
            $type_match = '/^([A-Za-z]+ *)+$/';

            if (preg_match($type_match, $type)) {
                $type = strtolower($type);
                $statement = 'INSERT OR IGNORE INTO CuisineTypes(type) VALUES(:type)';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':type', $type);

                if ($prepared_statement->execute()) {
                    $succes = true;
                }
            }

            return $success;
        }
    }
?>