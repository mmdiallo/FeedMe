<?php
	class PersonalMenuItems{
		public $db;
		public $personal_menu_item_id;


		public function __construct($db, $pid) {
            $this->db = $db;
            $this->personal_menu_item_id = $pid;
        }

		public function select($field) {
        	$stmt = "SELECT " . $field . " FROM PersonalMenuItems WHERE id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $personal_menu_item_id);
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

        public function addItem($pmenu_id, $menu_item_id) {
            $stmt = "INSERT into PersonalMenuItems (personal_menu_id, menu_item_id) VALUES (?,?);";
            $sql = $this->db->prepare($stmt);
            $sql->bindParam("ii", $pmenu_id, $menu_item_id);
            $result = $sql->execute();
        }
	}

?>