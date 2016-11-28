<?php
	class PriceRatings{
		public $db;

		public function __construct($db) {
            $this->db = $db;
        }

		public function select($field, $pid) {
        	$stmt = "SELECT " . $field . " FROM PriceRatings WHERE id = :id";
        	
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $pid, SQLITE3_INTEGER);
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