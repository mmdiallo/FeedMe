<?php
	class Menus{
		public $db;

		public function __construct($db) {
            $this->db = $db;
        }


        public function selectAll($menu_id) {
        	$stmt = "SELECT * FROM MenuItems WHERE menu_id = :id";

            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $menu_id, SQLITE3_INTEGER);
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