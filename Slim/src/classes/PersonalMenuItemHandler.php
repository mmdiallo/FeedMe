<?php
    class PersonalMenuItemHandler {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllIds($personal_menu_id) {
            $ids = array();
            $statement = 'SELECT id FROM PersonalMenuItems WHERE personal_menu_id=:personal_menu_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':personal_menu_id', $personal_menu_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                
                while ($row = $query_result->fetchArray()) {
                    $ids[] = $row['id'];
                }
            }

            return $ids;
        }
    }
?>