<?php
	class PersonalMenus{
		public $db;
		public $pmenu_id;


		public function __construct($db, $mid) {
            $this->db = $db;
            $this->pmenu_id = $mid;
        }


        public function selectAll() {
        	$stmt = "SELECT * FROM PersonalMenuItems WHERE personal_menu_id = ?";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $pmenu_id);
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

        public function addItem($menu_item_id) {
            $stmt = "INSERT into PersonalMenuItems (personal_menu_id, menu_item_id) VALUES (?,?)";
            $sql = $this->db->prepare($stmt);
            $sql->bindParam("ii", $pmenu_id, $menu_item_id);
            $result = $sql->execute();
            return $result;
        }
       
	}

?>