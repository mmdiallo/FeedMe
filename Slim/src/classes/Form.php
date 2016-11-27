<?php
    require_once 'UserHandler.php';

    class Form {
    	
        public function loginForm($action_url) {
            $form = '';
            $form = $form . '<form method="post" action="' . htmlentities($action_url) . '">';
            $form = $form . 'username: <input type="text" name="username" required>';
            $form = $form . '<br>';
            $form = $form . 'password: <input type="password" name="password" required>';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }

        public function editUser($user_id, $db) {
            //Source: http://www.w3schools.com/php/php_file_upload.asp
            $user_handler = new UserHandler($db);
            $email = $user_handler->getEmail($user_id);
            $first_name = $user_handler->getFirstName($user_id);
            $last_name = $user_handler->getLastName($user_id);
            $form = '';
            $form = $form . '<form enctype="multipart/form-data" method="post" action="' . '/users/' . htmlentities($user_id) . '/edit' . '">';
            $form = $form . 'Email: <input type="email" name="email" value="'. htmlentities($email) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'First Name: <input type="text" name="first_name" value="'. htmlentities($first_name) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Last Name: <input type="text" name="last_name" value="'. htmlentities($last_name) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Profile Image: <input type="file" accept="image/*" name="profile_image_path">';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';
            return $form;
        }

        public function editRestaurant($restaurant_id, $db) {
            $restaurant_handler = new RestaurantHandler($db);
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

            $cuisine_type_id = $restaurant_handler->getCuisineTypeId($restaurant_id);
            $cuisine_type_handler = new CuisineTypeHandler($db);
            $cuisine_type = $cuisine_type_handler->getType($cuisine_type_id);

            $price_rating_id = $restaurant_handler->getPriceRatingId($restaurant_id);
            $price_rating_handler = new PriceRatingHandler($db);
            $price_rating = $price_rating_handler->getRating($price_rating_id);

            $all_price_ratings = $price_rating_handler->getAllPriceRatings();

            $form = '';
            $form = $form . '<form enctype="multipart/form-data" method="post" action="' . '/restaurants/' . htmlentities($restaurant_id) . '/edit' . '">';
            $form = $form . 'Email: <input type="email" name="email" value="'. htmlentities($email) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Name: <input type="text" name="name" value="'. htmlentities($name) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Cuisine Type: <input type="text" name="cuisine_type" value="'. htmlentities($cuisine_type) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Street Address: <input type="text" name="street_address" value="'. htmlentities($street_address) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'City: <input type="text" name="city" value="'. htmlentities($city) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'State: <input type="text" name="state" value="'. htmlentities($state) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Phone Number: <input type="tel" name="phone_number" value="'. htmlentities($phone_number) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Time Open: <input type="time" name="time_open" value="'. htmlentities($time_open) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Time Close: <input type="time" name="time_close" value="'. htmlentities($time_close) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Website: <input type="text" name="website_url" value="'. htmlentities($website_url) . '" required>';
            $form = $form . '<br>';
            $form = $form . 'Biography: <textarea name="biography" required>' . htmlentities($biography) . '</textarea>';
            $form = $form . '<br>';

            $form = $form . 'Price Rating: <select name="price_rating" required>';

            foreach ($all_price_ratings as $rating => $values) {
                if ($rating == $price_rating) {
                    $form = $form . '<option value="' . $rating . '" selected> ' . $rating . ': $' . $values['lowest_price'] . '-$' . $values['highest_price'] . '</option>'; 
                }
                $form = $form . '<option value="' . $rating . '"> ' . $rating . ': $' . $values['lowest_price'] . '-$' . $values['highest_price'] . '</option>'; 
            }

            $form = $form . '</select>';
            $form = $form . '<br>';

            $form = $form . 'Profile Image: <input type="file" accept="image/*" name="profile_image_path">';
            $form = $form . '<br>';
            $form = $form . '<input type="submit">';
            $form = $form . '</form>';

            return $form;
        }
    }
?>