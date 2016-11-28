<?php
	class CuisineTypes{
		public $db;
		public $ctype_id;

		public function __construct($db, $cid) {
            $this->db = $db;
            $this->ctype_id = $cid;
        }

		public function select($field) {
        	$stmt = "SELECT " . $field . " FROM CuisineTypes WHERE id = ?;";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $ctype_id);
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