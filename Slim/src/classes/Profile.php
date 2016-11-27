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
                            echo '<br>';
                            var_dump($personal_menu_item_ids);
                            echo '<br>';
                            $profile = $profile . '<br><a href="/users/' . htmlentities($user_id) . '/edit"> Edit Profile </a>';
                        }

                    } else if ($account_type == 'restaurant') {
                        $restaurant_handler = new RestaurantHandler($this->db);
                        $restaurant_id = $restaurant_handler->getId($account_id);
                        var_dump($restaurant_id);

                        if ($restaurant_id != -1) {
                            $email = $restaurant_handler->getEmail($restaurant_id);
                            $name = $restaurant_handler->getName($restaurant_id);
                            $street_address = $restaurant_handler->getStreetAddress($restaurant_id);
                            $city = $restaurant_handler->getCity($restaurant_id);
                            $state = $restaurant_handler->getState($restaurant_id);
                            $phone_number = $restaurant_handler->getPhoneNumber($restaurant_id);
                            $website_url = $restaurant_handler->getWebsiteUrl($restaurant_id);
                            $biography = $restaurant_handler->getBiography($restaurant_id);
                            $profile_image_path = $restaurant_handler->getProfileImagePath($restaurant_id);

                            $cuisine_type_id = $restaurant_handler->getCuisineTypeId($restaurant_id);
                            $cuisine_type_handler = new CuisineTypeHandler($this->db);
                            $cuisine_type = $cuisine_type_handler->getType($cuisine_type_id);

                            $profile = $profile . '<p> Email: ' . htmlentities($email) . '</p>';
                            $profile = $profile . '<p> Name: ' . htmlentities($name) . '</p>';
                            $profile = $profile . '<p> Cuisine Type: ' . htmlentities($cuisine_type) . '</p>';
                            $profile = $profile . '<p> Address: ' . htmlentities($street_address) . '</p>';
                            $profile = $profile . '<p> City: ' . htmlentities($city) . '</p>';
                            $profile = $profile . '<p> State: ' . htmlentities($state) . '</p>';
                            $profile = $profile . '<p> Phone Number: ' . htmlentities($phone_number) . '</p>';
                            $profile = $profile . '<p> Website: ' . htmlentities($website_url) . '</p>';
                            $profile = $profile . '<p> Biography: ' . htmlentities($biography) . '</p>';
                            $profile = $profile . '<img height=100 width=100 src="' . htmlentities($profile_image_path) . '">';
                        }
                    }
                }
            }

            return $profile;
        }
    }
?>