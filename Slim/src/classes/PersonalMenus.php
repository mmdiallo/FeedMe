<?php
	class PersonalMenus{
		public $db;


		public function __construct($db) {
            $this->db = $db;
        }

        public function select($field, $id) {
            $stmt = "SELECT " . $field . " FROM PersonalMenus WHERE id = :id";

            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $id, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();
            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[$field] = $row[$field]; 
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


        public function selectAll($pm_id) {
        	$stmt = "SELECT id FROM PersonalMenuItems WHERE personal_menu_id = :id";
        
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $pm_id, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();

            if ($result !=  false) {     
                while($row = $result->fetchArray()){
                    $results[] = array('id' => $row['id']); 
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

        public function addItem($menu_item_id) {
            $stmt = "INSERT into PersonalMenuItems (menu_item_id) VALUES (:id)";
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $menu_item_id, SQLITE3_INTEGER);
            $result = $sql->execute();
            return $result;
        }       
	}

?>