<?php
    class CuisineTypeHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getType($id) {
            $type = '';
            $statement = 'SELECT type FROM AccountTypes WHERE id=:id';
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