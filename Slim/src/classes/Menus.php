<?php
	class Menus{
		public $db;
		public $menus_id;


		public function insert(){
			$sql = "INSERT INTO Menus DEFAULT VALUES";
			$result = $this->db->query($sql);
		}
	}

?>