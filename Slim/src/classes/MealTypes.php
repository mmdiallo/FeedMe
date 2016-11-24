<?php

	class MealTypes{
		public $db;
		public $mtype_id;

		public function __construct($db, $mid) {
            $this->db = $db;
            $this->mtype_id = $mid;
        }

		public function select($field) {
        	$stmt = "SELECT " . $field . " FROM MealTypes WHERE id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $mtype_id);
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


	}


?>