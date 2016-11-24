<?php

	class Users{
		public $db;
		public $u_id;


        public function __construct($db, $uid) {
            $this->db = $db;
            $this->u_id = $uid;
        }
	 
        public function select($field) {
        	$stmt = "SELECT " . $field . " FROM Users WHERE id = ?;";
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
 
	    public function insert($e, $f, $l, $p) {
	        $stmt = "INSERT INTO Users (email, first_name, last_name) VALUES(?,?,?)";
	        $sql = $this->db->prepare($stmt);
	        $sql->bindParam("sss", $email, $fname, $lname, $picpath);
	        $email = $e;
	        $fname = $f;
	        $lname = $l;
	        $picpath = $p;
	        $result = $sql->execute();
	    }
	 
	    // public function update($field, $id) {
	    // 	$stmt = "UPDATE Users SET " . $field . " =  ? WHERE id = ?";
	    // 	$sql = $this->db->prepare($stmt);
	    // 	$sql->bindParam("si", $f, $uid);
	    // 	$f = $field;
	    // 	$uid = $id;
	    // 	$result = $sql->execute();
	    // }
	 
	    public function delete() {
	        // $sSQL = "DELETE FROM user WHERE username = $mID;";
	        // $oResult = $this->database->Query($sSQL);
	    }
	}

?>