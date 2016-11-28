<?php
    class AuthenticationHandler {

        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function checkAuthentication() {
            $auth = false;

            if (empty($_SESSION['auth']) || $_SESSION['auth'] == false) {
                $auth = false;
            } else if ($_SESSION['auth'] == true) {
                $valid_account_id = $this->verifyAccountId($_SESSION['account_id']);

                if ($valid_account_id) {
                    $valid_account_type = $this->verifyAccountType($_SESSION['account_id'], $_SESSION['account_type']);

                    if ($valid_account_type) {
                        $valid_account = false;

                        if ($_SESSION['account_type'] == 'user') {
                            $valid_account = $this->verifyUserId($_SESSION['user']['user_id']);
                        } else if ($_SESSION['account_type'] == 'restaurant') {
                            $valid_account = $this->verifyRestaurantId($_SESSION['restaurant']['restaurant_id']);
                        }

                        if ($valid_account) {
                            $auth = true;
                        } 
                    } 
                }
            }

            return $auth;
        }

        public function authenticateSession($account_id, $account_type, $account_type_id) {
            session_regenerate_id(true);
            $valid_account_id = $this->verifyAccountId($account_id);
            
            if ($valid_account_id) {
                $valid_account_type = $this->verifyAccountType($account_id, $account_type);

                if ($valid_account_type) {
                    $valid_account_type_id = false;

                    if ($account_type == 'user') {
                        $valid_account_type_id = $this->verifyUserId($account_type_id);
                    } else if ($account_type == 'restaurant') {
                        $valid_account_type_id = $this->verifyRestaurantId($account_type_id);
                    }

                    if ($valid_account_type_id) {
                        $_SESSION['auth'] = true;
                        $_SESSION['account_id'] = $account_id;

                        if ($account_type == 'user') {
                            $_SESSION['account_type'] = 'user';
                            $_SESSION['user'] = array('user_id' => $account_type_id);
                        } else if ($account_type == 'restaurant') {
                            $_SESSION['account_type'] = 'restaurant';
                            $_SESSION['restaurant'] = array('restaurant_id' => $account_type_id);
                        }
                    } else {
                        $_SESSION['auth'] = false;
                    }
                } else {
                    $_SESSION['auth'] = false;
                }
            } else {
                $_SESSION['auth'] = false;
            }
        }

        public function endSession() {
            session_destroy();
            unset($_SESSION);
            session_set_cookie_params(0, '/', '', true, true);
            session_start();
            session_regenerate_id(true);
        }

        public function getCurrentSession() {
            $session_info = array();
            $session_info['account_id'] = $_SESSION['account_id'];
            $session_info['account_type'] = $_SESSION['account_type'];

            if ($_SESSION['account_type'] == 'user') {
                $session_info['user_id'] = $_SESSION['user']['user_id'];
            } else if ($_SESSION['account_type'] == 'restaurant') {
                $session_info['restaurant_id'] = $_SESSION['restaurant']['restaurant_id'];
            }

            return $session_info;
        }

        private function verifyAccountId($account_id) {
            $valid = false;
            $statement = 'SELECT * FROM Accounts WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $result_count = 0;

                while ($row = $query_result->fetchArray()) {
                    $result_count += 1;
                }

                if ($result_count == 1) {
                    $valid = true;
                }
            }

            return $valid;
        }

        private function verifyAccountType($account_id, $account_type) {
            $valid = false;
            $account_type_handler = new AccountTypeHandler($this->db);
            $account_type_id = $account_type_handler->getId($account_type);
            $statement = 'SELECT * FROM Accounts WHERE id=:id AND account_type_id=:account_type_id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);
            $prepared_statement->bindValue(':account_type_id', $account_type_id, SQLITE3_INTEGER);
            
            if ($query_result = $prepared_statement->execute()) {
                $result_count = 0;

                while ($row = $query_result->fetchArray()) {
                    $result_count += 1;
                }

                if ($result_count == 1) {
                    $valid = true;
                }
            }

            return $valid; 
        }

        private function verifyUserId($user_id) {
            $valid = false;
            $statement = 'SELECT * FROM Users WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $user_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $result_count = 0;

                while ($row = $query_result->fetchArray()) {
                    $result_count += 1;
                }

                if ($result_count == 1) {
                    $valid = true;
                }
            }

            return $valid;
        }

        private function verifyRestaurantId($restaurant_id) {
            $valid = false;
            $statement = 'SELECT * FROM Restaurants WHERE id=:id';
            $prepared_statement = $this->db->prepare($statement);
            $prepared_statement->bindValue(':id', $restaurant_id, SQLITE3_INTEGER);

            if ($query_result = $prepared_statement->execute()) {
                $result_count = 0;

                while ($row = $query_result->fetchArray()) {
                    $result_count += 1;
                }

                if ($result_count == 1) {
                    $valid = true;
                }
            }
            
            return $valid;
        }
    }
?>