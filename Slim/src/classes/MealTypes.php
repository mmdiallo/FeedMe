<?php
	class MealTypes{
		public $db;

		public function __construct($db) {
            $this->db = $db;
        }

		public function select($field, $mtype_id) {
        	$stmt = "SELECT " . $field . " FROM MealTypes WHERE id = :id";

            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $mtype_id, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();
            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[] = array($field => $row[$field]); 
                }
                
            } else {
                $results['error'] = 'Failed to get ' . $field;
            }

            if (empty($results)) {
                $results['error'] = 'Failed to get ' . $field;
            }

            $json = json_encode($results);
            return $json;
        }
	}


?>