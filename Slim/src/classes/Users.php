<?php
	class Users{
		public $db;

        public function __construct($db) {
            $this->db = $db;
        }
	 
        public function select($field, $uid) {
        	$stmt = "SELECT " . $field . " FROM Users WHERE id = :id";
        	
            $sql = $this->db->prepare($stmt);
            $sql->bindValue(':id', $uid, SQLITE3_INTEGER);
            $result = $sql->execute();

            $results = array();
            if ($result !=  false) {
                while($row = $result->fetchArray()){
                    $results[$field] = $row[$field]; 
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
 
	    public function edit($email, $fname, $lname, $picpath, $uid) {
            $stmt = "UPDATE Users SET email = :e, first_name = :f, last_name = :l, profile_image_path = :p WHERE id = :id";
	        $sql = $this->db->prepare($stmt);

            $sql->bindValue(':e', $email, SQLITE3_TEXT);
            $sql->bindValue(':f', $fname, SQLITE3_TEXT);
            $sql->bindValue(':l', $lname, SQLITE3_TEXT);
            $sql->bindValue(':p', $picpath, SQLITE3_TEXT);
            $sql->bindValue(':id', $uid, SQLITE3_INTEGER);


	        $result = $sql->execute();
	  //       if ($sql->errno)
  	// 			return "FAILED to update " . $sql->error;
			// else 
			// 	return "Updated {$sql->affected_rows} rows";

            return $result;
	    }
	}
?>