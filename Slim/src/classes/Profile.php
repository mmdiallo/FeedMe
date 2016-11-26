<?php
    require_once 'AccountHandler.php';
    require_once 'AccountTypeHandler.php';
    class Profile {
        protected $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function createProfile($account_id) {
            $profile = '';
            $account_handler = new AccountHandler($this->db);
            $username = $account_handler->getUsername($account_id);
            $account_type_id = $account_handler->getAccountTypeId($account_id);

            if ($account_type_id != -1) {
                $account_type_handler = new AccountTypeHandler($this->db);
                $account_type = $account_type_handler->getType($account_type_id);

                if ($account_type != NULL) {
                    $profile = $profile . '<h1>' . $username . '</h1>';
                    $profile = $profile . '<h2>' . $account_type . '</h2>';

                    if ($account_type == 'user') {
                        $user_handler = new UserHandler($this->db);
                        $user_id = $user_handler->getId($account_id);

                        if ($user_id != -1) {
                            $email = $user_handler->getEmail($user_id);
                            $first_name = $user_handler->getFirstName($user_id);
                            $last_name = $user_handler->getLastName($user_id);
                            $profile_image_path = $user_handler->getProfileImagePath($user_id);
                            
                            $profile = $profile . '<p> Email: ' . $email . '</p>';
                            $profile = $profile . '<p> First Name: ' . $first_name . '</p>';
                            $profile = $profile . '<p> Last Name: ' . $last_name . '</p>';
                            $profile = $profile . '<img height=100 width=100 src="' . $profile_image_path . '">';
                        }

                    } else if ($account_type == 'restaurant') {

                    }

                }
            }

            return $profile;
        }
    }
?>