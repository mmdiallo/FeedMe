<?php

	class Restaurants{
		public $db;
		public $rest_id;

		public function __construct($db, $rid) {
            $this->db = $db;
            $this->rest_id = $rid;
        }

		public function select($field) {
        	$stmt = "SELECT " . $field . " FROM Restaurants WHERE id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $rest_id);
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


	}


?>