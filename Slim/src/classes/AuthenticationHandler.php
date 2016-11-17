<?php 
	class AuthenticationHandler {

		public function checkAuthentication() {
			$auth = false;

			if (empty($_SESSION['auth']) || $_SESSION['auth'] == false) {
				$auth = false;
			} else if ($_SESSION['auth'] == true) {
				$auth = true;
				// if (!empty($_SESSION['account'])) {
				// 	if (!empty($_SESSION['account']['id'])) {
				// 		if (!empty($_SESSION['account']['account_type'])) {
				// 			$account_type = $_SESSION['account']['acco']
				// 		}
				// 	}
				// }
			}
			return $auth;
		}
	}
?>