<?php
	class Menus{
		public $db;
		public $menus_id;


		public function __construct($db, $mid) {
            $this->db = $db;
            $this->menus_id = $mid;
        }

		public function insert(){
			$sql = "INSERT INTO Menus DEFAULT VALUES";
			$result = $this->db->query($sql);
		}
	}

?>