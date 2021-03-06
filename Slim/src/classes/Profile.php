<?php
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

            if ($account_type_id != -1 && $account_type_id != NULL) {
                $account_type_handler = new AccountTypeHandler($this->db);
                $account_type = $account_type_handler->getType($account_type_id);

                if ($account_type != NULL) {
                    $profile = $profile . '<h1>' . htmlentities($username) . '</h1>';
                    $profile = $profile . '<h2>' . htmlentities($account_type) . '</h2>';

                    if ($account_type == 'user') {
                        $user_handler = new UserHandler($this->db);
                        $user_id = $user_handler->getId($account_id);

                        if ($user_id != -1 && $user_id != NULL) {
                            $profile = $profile . $this->buildUserProfile($user_id);
                        }

                    } else if ($account_type == 'restaurant') {
                        $restaurant_handler = new RestaurantHandler($this->db);
                        $restaurant_id = $restaurant_handler->getId($account_id);

                        if ($restaurant_id != -1 && $restaurant_id != NULL) {
                            $profile = $profile . $this->buildRestaurantProfile($restaurant_id);
                        }
                    }
                }
            }

            return $profile;
        }

        private function buildUserProfile($user_id) {
            $profile = '';
            $user_handler = new UserHandler($this->db);
            $email = $user_handler->getEmail($user_id);
            $first_name = $user_handler->getFirstName($user_id);
            $last_name = $user_handler->getLastName($user_id);
            $profile_image_path = $user_handler->getProfileImagePath($user_id);

            $personal_menu_handler = new PersonalMenuHandler($this->db);
            $personal_menu_id = $personal_menu_handler->getId($user_id);

            $personal_menu_item_handler = new PersonalMenuItemHandler($this->db);
            $personal_menu_item_ids = $personal_menu_item_handler->getAllIds($personal_menu_id);

            $profile = $profile . '<p> Email: ' . htmlentities($email) . '</p>';
            $profile = $profile . '<p> First Name: ' . htmlentities($first_name) . '</p>';
            $profile = $profile . '<p> Last Name: ' . htmlentities($last_name) . '</p>';
            $profile = $profile . '<img height=100 width=100 src="' . htmlentities($profile_image_path) . '">';
            $profile = $profile . '<br><a href="/users/' . htmlentities($user_id) . '/edit"> Edit Profile </a>';
            //$profile = $profile . '<br><a href="/logout"> Logout </a>';

            $profile = $profile . '<h2> Personal Menu Items </h2>';

            foreach ($personal_menu_item_ids as $p_menu_item_id) {
                $menu_item_id = $personal_menu_item_handler->getMenuItemId($p_menu_item_id);
                $profile = $profile . $this->displayMenuItem($menu_item_id);
            }

            return $profile;
        }

        private function buildRestaurantProfile($restaurant_id) {
            $profile = '';
            $restaurant_handler = new RestaurantHandler($this->db);
            $email = $restaurant_handler->getEmail($restaurant_id);
            $name = $restaurant_handler->getName($restaurant_id);
            $street_address = $restaurant_handler->getStreetAddress($restaurant_id);
            $city = $restaurant_handler->getCity($restaurant_id);
            $state = $restaurant_handler->getState($restaurant_id);
            $phone_number = $restaurant_handler->getPhoneNumber($restaurant_id);
            $time_open = $restaurant_handler->getTimeOpen($restaurant_id);
            $time_close = $restaurant_handler->getTimeClose($restaurant_id);
            $website_url = $restaurant_handler->getWebsiteUrl($restaurant_id);
            $biography = $restaurant_handler->getBiography($restaurant_id);
            $profile_image_path = $restaurant_handler->getProfileImagePath($restaurant_id);

            $cuisine_type_id = $restaurant_handler->getCuisineTypeId($restaurant_id);
            $cuisine_type_handler = new CuisineTypeHandler($this->db);
            $cuisine_type = $cuisine_type_handler->getType($cuisine_type_id);

            $price_rating_id = $restaurant_handler->getPriceRatingId($restaurant_id);
            $price_rating_handler = new PriceRatingHandler($this->db);
            $price_rating = $price_rating_handler->getRating($price_rating_id);
            $price_rating_low = -1;
            $price_rating_high = -1;

            if ($price_rating != -1 && $price_rating != NULL) {
                $price_rating_low = $price_rating_handler->getLowestPrice($price_rating_id);
                $price_rating_high = $price_rating_handler->getHighestPrice($price_rating_id);
            } else {
                $price_rating = NULL;
                $price_rating_low = NULL;
                $price_rating_high = NULL;
            }

            $profile = $profile . '<p> Email: ' . htmlentities($email) . '</p>';
            $profile = $profile . '<p> Name: ' . htmlentities($name) . '</p>';
            $profile = $profile . '<p> Cuisine Type: ' . htmlentities($cuisine_type) . '</p>';
            $profile = $profile . '<p> Price Rating: ' . htmlentities($price_rating) . ' (Lowest Price: ' . htmlentities($price_rating_low) . ', Highest Price: ' . htmlentities($price_rating_high) . ') </p>';
            $profile = $profile . '<p> Address: ' . htmlentities($street_address) . '</p>';
            $profile = $profile . '<p> City: ' . htmlentities($city) . '</p>';
            $profile = $profile . '<p> State: ' . htmlentities($state) . '</p>';
            $profile = $profile . '<p> Phone Number: ' . htmlentities($phone_number) . '</p>';
            $profile = $profile . '<p> Open At: ' . htmlentities($time_open) . '</p>';
            $profile = $profile . '<p> Close At: ' . htmlentities($time_close) . '</p>';
            $profile = $profile . '<p> Website: ' . htmlentities($website_url) . '</p>';
            $profile = $profile . '<p> Biography: ' . htmlentities($biography) . '</p>';
            $profile = $profile . '<img height=100 width=100 src="' . htmlentities($profile_image_path) . '">';
            $profile = $profile . '<br><a href="/restaurants/' . htmlentities($restaurant_id) . '/edit"> Edit Profile </a>';
            //$profile = $profile . '<br><a href="/logout"> Logout </a>';

            $menu_handler = new MenuHandler($this->db);
            $menu_id = $menu_handler->getId($restaurant_id);

            if ($menu_id != -1 && $menu_id != NULL) {

                $profile = $profile . '<br><br><a href="/menus/' . htmlentities($menu_id) . '/add"> Add Menu Item </a>';

                $menu_item_handler = new MenuItemHandler($this->db);
                $menu_item_ids = $menu_item_handler->getAllIds($menu_id);

                $profile = $profile . '<h2> Menu Items </h2>';

                foreach ($menu_item_ids as $menu_item_id) {
                    $profile = $profile . $this->displayMenuItem($menu_item_id);
                }
            }

            return $profile;
        }

        private function displayMenuItem($menu_item_id) {
            $profile = '';
            $menu_item_handler = new MenuItemHandler($this->db);
            $mi_name = $menu_item_handler->getName($menu_item_id);
            $mi_price = $menu_item_handler->getPrice($menu_item_id);
            $mi_description = $menu_item_handler->getDescription($menu_item_id);
            $mi_image_path = $menu_item_handler->getImagePath($menu_item_id);
                
            $cuisine_type_handler = new CuisineTypeHandler($this->db);
            $mi_cuisine_type_id = $menu_item_handler->getCuisineTypeId($menu_item_id);
            $mi_cuisine_type = $cuisine_type_handler->getType($mi_cuisine_type_id);

            $meal_type_handler = new MealTypeHandler($this->db);
            $mi_meal_type_id = $menu_item_handler->getMealTypeId($menu_item_id);
            $mi_meal_type = $meal_type_handler->getType($mi_meal_type_id);

            $profile = $profile . '<div style="margin: 8;">';
            $profile = $profile . '<h3> Menu Item </h3>';
            $profile = $profile . '<img height=100 width=100 src="' . htmlentities($mi_image_path) . '">';
            $profile = $profile . '<p> Name: ' . htmlentities($mi_name) . ' </p>';
            $profile = $profile . '<p> Price: $' . htmlentities($mi_price) . ' </p>';
            $profile = $profile . '<p> Cuisine Type: ' . htmlentities($mi_cuisine_type) . ' </p>';
            $profile = $profile . '<p> Meal Type: ' . htmlentities($mi_meal_type) . ' </p>';
            $profile = $profile . '<p> Description: ' . htmlentities($mi_description) . ' </p>';

            $authentication = new AuthenticationHandler($this->db);
            $current_session = $authentication->getCurrentSession();

            if (!empty($current_session['user_id'])) {
                $personal_menu_handler = new PersonalMenuHandler($this->db);
                $personal_menu_id = $personal_menu_handler->getId($current_session['user_id']);
                $profile = $profile . '<a href="/personalMenus/' . htmlentities($personal_menu_id) . '/add?menu_item_id=' . htmlentities($menu_item_id) . '"> Add to Personal Menu </a>';
            }

            $profile = $profile . '</div>';
            return $profile;
        }
    }
?>