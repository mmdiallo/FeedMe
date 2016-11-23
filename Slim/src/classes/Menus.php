<?php
	class Menus{
		public $db;
		public $menu_id;


		public function __construct($db, $mid) {
            $this->db = $db;
            $this->menu_id = $mid;
        }


        public function selectAll() {
        	$stmt = "SELECT * FROM MenuItems WHERE menu_id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $menu_id);
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
            	return $result;
            }
        }

		// public function insert(){
		// 	$sql = "INSERT INTO Menus DEFAULT VALUES";
		// 	$result = $this->db->query($sql);
		// }
	}

?>