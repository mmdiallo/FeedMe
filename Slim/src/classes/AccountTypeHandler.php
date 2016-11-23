<?php
    class AccountTypeHandler {

        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getId($type) {
            $id = -1;
            $query = '';

            if ($type == 'user') {
                $query = 'SELECT id FROM AccountTypes WHERE type="user"';
            } else if ($type == 'restaurant') {
                $query = 'SELECT id FROM AccountTypes WHERE type="restaurant"';
            }

            if ($query_result = $this->db->query($query)) {
                $row = $query_result->fetchArray();
                $id = $row['id'];
            }

            return $id;
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

            return $type;
        }
    }
?>