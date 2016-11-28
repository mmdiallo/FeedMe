<?php

	class Users{
		public $db;
		public $u_id;


        public function __construct($db, $uid) {
            $this->db = $db;
            $this->u_id = $uid;
        }
	 
        public function select($field) {
        	$stmt = "SELECT " . $field . " FROM Users WHERE id = ?";
        	$sql = $this->db->prepare($stmt);
        	$sql->bindParam("i", $u_id);
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
 
	    public function edit($email, $fname, $lname, $picpath) {
	        $stmt = "UPDATE Users SET email = ?, first_name = ?, last_name = ?, profile_image_path = ? WHERE id = ?";
	        $sql = $this->db->prepare($stmt);
	        $sql->bindParam("ssssi", $email, $fname, $lname, $picpath, $u_id);
	        $sql->execute();
	        if ($sql->errno)
  				return "FAILED to update " . $sql->error;
			else 
				return "Updated {$sql->affected_rows} rows";
	    }
	}
?>