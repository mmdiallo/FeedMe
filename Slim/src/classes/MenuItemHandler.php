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
    }
?>