<?php
	class MenuItems{
		public $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function select($field, $menu_item_id) {
            $stmt = "SELECT " . $field . " FROM MenuItems WHERE id = :id";
             
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $$menu_item_id, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();
            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[] = array($field => $row[$field]); 
                }
                $json = json_encode($results);
                return $json;
            }
        }
	}

?>