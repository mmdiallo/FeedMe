<?php
	class MenuItems{
		public $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function select($field, $menu_item_id) {
            $stmt = "SELECT " . $field . " FROM MenuItems WHERE id = :id";
             
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $menu_item_id, SQLITE3_INTEGER);
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

         public function selectAllIds() {
            $stmt = "SELECT id FROM MenuItems";
            $result = $this->db->query($stmt);
            $results = array();

            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[] = array('menu_item_id' => $row['id']); 
            }
                
            } else {
                $results['error'] = 'Failed to get ids';
            }

            if (empty($results)) {
                $results['error'] = 'Failed to get ids';
            }

            $json = json_encode($results);
            return $json;

        }
	}

?>