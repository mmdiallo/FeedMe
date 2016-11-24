<?php

	class PriceRatings{
		public $db;
		public $p_id;

		public function __construct($db, $pid) {
            $this->db = $db;
            $this->p_id = $pid;
        }

		public function select($field) {
        	$stmt = "SELECT " . $field . " FROM PriceRatings WHERE id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $p_id);
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