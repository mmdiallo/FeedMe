<?php
	class MenuItems{
		public $db;
		public $menu_items_id;



        public function select($field, $menu_items_id) {
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
           		echo $json;
            	return $json;
            }
            else{
            	$result = "O result";
            	echo $result;
            	return $result;
            }

        }

		public function insert(){
		
		}
	}

?>