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

        public function addItem($personal_menu_id, $menu_item_id) {
            $success = false;
            $valid_id_pattern = '/^[\d]+$/';
            $valid_personal_menu_id = preg_match($valid_id_pattern, $personal_menu_id);
            $valid_menu_item_id = preg_match($valid_id_pattern, $menu_item_id);

            if ($valid_personal_menu_id && $valid_menu_item_id) {
                $personal_menu_id = intval($personal_menu_id);
                $menu_item_id = intval($menu_item_id);
                $statement = 'INSERT OR IGNORE INTO PersonalMenuItems(personal_menu_id, menu_item_id) VALUES(:personal_menu_id, :menu_item_id)';
                $prepared_statement = $this->db->prepare($statement);
                $prepared_statement->bindValue(':personal_menu_id', $personal_menu_id, SQLITE3_INTEGER);
                $prepared_statement->bindValue(':menu_item_id', $menu_item_id, SQLITE3_INTEGER);

                if ($prepared_statement->execute()) {
                    $success = true;
                }
            }

            return $success;
        }
    }
?>