<?php
    require_once 'AccountHandler.php';
    require_once 'AccountTypeHandler.php';
    require_once 'UserHandler.php';
    require_once 'PersonalMenuHandler.php';
    require_once 'PersonalMenuItemHandler.php';
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
                    $profile = $profile . '<h1>' . htmlentities($username) . '</h1>';
                    $profile = $profile . '<h2>' . htmlentities($account_type) . '</h2>';

                    if ($account_type == 'user') {
                        $user_handler = new UserHandler($this->db);
                        $user_id = $user_handler->getId($account_id);

                        if ($user_id != -1) {
                            $email = $user_handler->getEmail($user_id);
                            $first_name = $user_handler->getFirstName($user_id);
                            $last_name = $user_handler->getLastName($user_id);
                            $profile_image_path = $user_handler->getProfileImagePath($user_id);
                            
                            $profile = $profile . '<p> Email: ' . htmlentities($email) . '</p>';
                            $profile = $profile . '<p> First Name: ' . htmlentities($first_name) . '</p>';
                            $profile = $profile . '<p> Last Name: ' . htmlentities($last_name) . '</p>';
                            $profile = $profile . '<img height=100 width=100 src="' . htmlentities($profile_image_path) . '">';

                            $personal_menu_handler = new PersonalMenuHandler($this->db);
                            $personal_menu_id = $personal_menu_handler->getId($user_id);

                            $personal_menu_item_handler = new PersonalMenuItemHandler($this->db);

                            $personal_menu_item_ids = $personal_menu_item_handler->getAllIds($personal_menu_id);

                            var_dump($personal_menu_item_ids);

                        }

                    } else if ($account_type == 'restaurant') {

                    }

                }
            }

            return $profile;
        }
    }
?>