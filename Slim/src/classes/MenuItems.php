<?php
	class MenuItems{
		public $db;
		public $menu_items_id;


        public function __construct($db, $mid) {
            $this->db = $db;
            $this->menu_items_id = $mid;
        }

        public function select($field) {
            $stmt = "SELECT " . $field . " FROM MenuItems WHERE id = ?;";
            $sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $menu_items_id);
	        $result = $sql->execute();

	        $results = array();
	        if ($result->num_rows > 0) {
            	while($row = $result->fetch_assoc()){
            		$results[] = array($field => $row[$field]); 
            	}
           		$json = json_encode($results);
            	return $json;
            }
            else{
            	$result = "O result";
            	return $result;
            }
        }

		public function insert(){
		
		}
	}

?>