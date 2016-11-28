<?php
	class PersonalMenuItems{
		public $db;


		public function __construct($db) {
            $this->db = $db;
        }

		public function select($field, $pid) {
        	$stmt = "SELECT " . $field . " FROM PersonalMenuItems WHERE id = :id";

        	$sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $pid, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();
            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[] = array($field => $row[$field]); 
                }
                
            } else {
                $results['error'] = 'Failed to get ' . $field;
            }

            if (empty($results)) {
                $results['error'] = 'Failed to get ' . $field;
            }

            $json = json_encode($results);
            return $json;
        }

        public function addItem($pmenu_id, $menu_item_id) {
            $stmt = "INSERT into PersonalMenuItems (personal_menu_id, menu_item_id) VALUES (:pm_id, :menu_item_id)";
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':pm_id', $pmenu_id, SQLITE3_INTEGER);
            $sql->bindValue(':menu_item_id', $menu_item_id, SQLITE3_INTEGER);
            $result = $sql->execute();
            return $result;
        }
	}

?>