<?php
// START SESSION
session_set_cookie_params(0, '/', '', true, true);
session_name('by_PHPSESSID');
session_start();

// SET UP SLIM APPLICATION
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

foreach (glob('../classes/*.php') as $filename) {
    require_once $filename;
}

$config['displayErrorDetails'] = false;
$config['db']['filename'] = '../database/feed_me.sqlite';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['db'] = function($c) {
    $db = $c['settings']['db'];
    $sqlite = new Sqlite3($db['filename']);
    return $sqlite;
};

// MIDDLEWARE =====================================================================================

// if request not https, redirect
$https_mw = function(Request $request, Response $response, $next) {
    if (empty($_SERVER['HTTPS'])) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit;
    } else {
        $response = $next($request, $response);
    }
    return $response;
};

$app->add($https_mw);

// if not authenticated, return error response
$access_mw = function(Request $request, Response $response, $next) {
    $result = array('error' => null);
    $authenticationHandler = new AuthenticationHandler($this->db);
    $current_auth = $authenticationHandler->checkAuthentication();

    if ($current_auth) {
        $request = $request->withAttribute('result', $result);
        $response = $next($request, $response);
    } else {
        $result['error'] = 'user not logged in';
        $json = json_encode($result, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    }

    return $response;
};

// if authenticated, return error response
// prevents access to login and create account pages for already authenticated users
$login_mw = function(Request $request, Response $response, $next) {
    $result = array('error' => null);
    $authentication = new AuthenticationHandler($this->db);
    $current_auth = $authentication->checkAuthentication();
    if ($current_auth) {
        $result['error'] = 'user already logged in';
        $json = json_encode($result, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    } else {
        $request = $request->withAttribute('result', $result);
        $response = $next($request, $response);
    }

    return $response;
};

// ROUTES =========================================================================================

// API ROUTES -------------------------------------------------------------------------------------

// Account Creation ------------------------------------------------------

$app->post('/create_user_account', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];
    $this->db->exec('BEGIN TRANSACTION');
    $account = new AccountHandler($this->db);
    $account_creation_success = $account->createUserAccount($username, $password);

    if ($account_creation_success) {
        $account_information = $account->getAccountInformation($username);
        if (!empty($account_information['user_id'])) {
            $authenticationHandler = new AuthenticationHandler($this->db);
            $authenticationHandler->authenticateSession($account_information['account_id'], $account_information['account_type'], $account_information['user_id']);
            $auth_check = $authenticationHandler->checkAuthentication();

            if ($auth_check) {
                $result['account_id'] = $account_information['account_id'];
                $result['account_type'] = $account_information['account_type'];
                $result['user_id'] = $account_information['user_id'];
            } else {
                $result['error'] = 'account creation failed';
            }
        } else {
             $result['error'] = 'account creation failed';
        }

    } else {
        $result['error'] = 'account creation failed';
    }

    if ($result['error'] == NULL) {
        $this->db->exec('COMMIT');
    } else {
        $this->db->exec('ROLLBACK');
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
})->add($login_mw);

$app->post('/create_restaurant_account', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];
    $this->db->exec('BEGIN TRANSACTION');
    $account = new AccountHandler($this->db);
    $account_creation_success = $account->createRestaurantAccount($username, $password);
    
    if ($account_creation_success) {
        $account_information = $account->getAccountInformation($username);

        if (!empty($account_information['restaurant_id'])) {
            $authenticationHandler = new AuthenticationHandler($this->db);
            $authenticationHandler->authenticateSession($account_information['account_id'], $account_information['account_type'], $account_information['restaurant_id']);
            $auth_check = $authenticationHandler->checkAuthentication();

            if ($auth_check) {
                $result['account_id'] = $account_information['account_id'];
                $result['account_type'] = $account_information['account_type'];
                $result['restaurant_id'] = $account_information['restaurant_id'];
            } else {
                $result['error'] = 'account creation failed';
            }

        } else {
             $result['error'] = 'account creation failed';
        }

    } else {
        $result['error'] = 'account creation failed';
    }

    if ($result['error'] == NULL) {
        $this->db->exec('COMMIT');
    } else {
        $this->db->exec('ROLLBACK');
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
})->add($login_mw);

$app->post('/login', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];
    $account = new AccountHandler($this->db);
    $login_success = $account->login($username, $password);

    if ($login_success) {
        $account_information = $account->getAccountInformation($username);
        $result['account_id'] = $account_information['account_id'];
        $result['account_type'] = $account_information['account_type'];

        $authenticationHandler = new AuthenticationHandler($this->db);

        if ($result['account_type'] == 'user') {
            $result['user_id'] = $account_information['user_id'];
            $authenticationHandler->authenticateSession($result['account_id'], $result['account_type'], $result['user_id']);
        } else if ($result['account_type'] == 'restaurant') {
            $result['restaurant_id'] = $account_information['restaurant_id'];
            $authenticationHandler->authenticateSession($result['account_id'], $result['account_type'], $result['restaurant_id']);
        }
        
    } else {
        $result['error'] = 'login failed';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
})->add($login_mw);

$app->get('/logout', function(Request $request, Response $response) {
    $result = array('error' => null);
    $authentication = new AuthenticationHandler($this->db);
    $auth = $authentication->checkAuthentication();

    $authentication->endSession();
    $current_auth = $authentication->checkAuthentication();

    if (!$current_auth) {
        $result['status'] = 'logout successful';
    } else {
        $result['error'] = 'logout failed';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
    return $response;
});

// Accounts --------------------------------------------------------------

$app->get('/current_account', function (Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $authentication = new AuthenticationHandler($this->db);
    $session_info = $authentication->getCurrentSession();
    $json = json_encode($session_info, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
})->add($access_mw);

// Users -----------------------------------------------------------------

$app->get('/users/all_user_ids', function(Request $request, Response $response) {
    $user = new Users($this->db);
    $response = $user->selectAllIds();
    return $response;
})->add($access_mw);

$app->post('/users/{user_id: [\d]+}/edit', function(Request $request, Response $response, $args) {
    $result = array('error' => NULL);
    $authentication = new AuthenticationHandler($this->db);
    $user_id = $request->getAttribute('user_id');
    $auth = $authentication->checkAuthentication();

    if ($auth) {
        $session_info = $authentication->getCurrentSession();
        if ($session_info['user_id'] == $user_id) {
            $data = $request->getParsedBody();

            if ($_FILES['profile_image_path']['name'] == '') {
                $result['file_upload'] = NULL;
                $user_handler = new UserHandler($this->db);
                $this->db->exec('BEGIN TRANSACTION');
                $email_success = $user_handler->updateEmail($user_id, $data['email']);
                $first_name_success = $user_handler->updateFirstName($user_id, $data['first_name'])  && preg_match('/^[A-Za-z]+$/', $data['first_name']);
                $last_name_success = $user_handler->updateLastName($user_id, $data['last_name']) && preg_match('/^[A-Za-z]+$/', $data['last_name']);

                if ($email_success && $first_name_success && $last_name_success) {
                    $this->db->exec('COMMIT');
                    $result['status'] = 'update successful';
                } else {
                    $this->db->exec('ROLLBACK');
                    $result['error'] = 'update failed';
                }
            } else {
                //Source: http://www.w3schools.com/php/php_file_upload.asp
                $file_to_upload = $_FILES['profile_image_path']['name'];
                $image_file_type = pathinfo($file_to_upload, PATHINFO_EXTENSION);
                $target_file = '../images/users/' . $user_id . '_' . date('Ymdhis') . '.' . $image_file_type;
                $image_check = getimagesize($_FILES['profile_image_path']['tmp_name']);

                if ($image_check) {
                    if (move_uploaded_file($_FILES['profile_image_path']['tmp_name'], $target_file)) {
                        $result['file_upload'] = 'success';

                        $user_handler = new UserHandler($this->db);
                        $this->db->exec('BEGIN TRANSACTION');
                        $email_success = $user_handler->updateEmail($user_id, $data['email']);
                        $first_name_success = $user_handler->updateFirstName($user_id, $data['first_name'])  && preg_match('/^[A-Za-z]+$/', $data['first_name']);
                        $last_name_success = $user_handler->updateLastName($user_id, $data['last_name']) && preg_match('/^[A-Za-z]+$/', $data['last_name']);
                        $image_path_success = $user_handler->updateProfileImagePath($user_id, $target_file);

                        if ($email_success && $first_name_success && $last_name_success && $image_path_success) {
                            $this->db->exec('COMMIT');
                            $result['status'] = 'update successful';
                        } else {
                            $this->db->exec('ROLLBACK');
                            $result['error'] = 'update failed';
                        }
                    } else {
                        $result['error'] = 'file upload failed';
                    }
                } else {
                    $result['error'] = 'file upload failed';
                }
            }
        } else {
            $result['error'] = 'not authorized to edit user';
        }
    } else {
        $result['error'] = 'user not logged in';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/email', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db);
    $response = $user->select("email", $uid);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/account_id', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db);
    $response = $user->select("account_id", $uid);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/first_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db);
    $response = $user->select("first_name", $uid);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/last_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db);
    $response = $user->select("last_name", $uid);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/profile_image_path', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db);
    $response = $user->select("profile_image_path", $uid);
    return $response;
})->add($access_mw);

$app->get('/users/{uid: [\d]+}/personal_menu_id', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $personal_menu_handler = new PersonalMenuHandler($this->db);
    $result = array('personal_menu_id' => $personal_menu_handler->getId($uid));

    if ($result['personal_menu_id'] == NULL) {
        $result = array('error' => 'failed to get personal menu id');
    }

    $response->getBody()->write(json_encode($result));
    return $response;
})->add($access_mw);

// Personal Menus --------------------------------------------------------
$app->get('/personalMenus/all_personal_menu_ids', function(Request $request, Response $response) {
    $personalMenu = new PersonalMenus($this->db);
    $response = $personalMenu->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/personalMenus/{pmenu_id: [\d]+}/all_menu_item_ids', function(Request $request, Response $response) {
    $personal_menu_id = $request->getAttribute('pmenu_id');
    $personal_menu_item_handler = new PersonalMenuItemHandler($this->db);
    $personal_menu_item_ids = $personal_menu_item_handler->getAllIds($personal_menu_id);
    $menu_item_ids = array();

    foreach ($personal_menu_item_ids as $p_menu_item_id) {
        $menu_item_ids[] = array('menu_item_id' => $personal_menu_item_handler->getMenuItemId($p_menu_item_id));
    }

    if (empty($menu_item_ids)) {
        $result = array('error' => 'failed to get personal menu item ids');
        $json = json_encode($result, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    } else {
        $json = json_encode($menu_item_ids, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    }
})->add($access_mw);

$app->get('/personalMenus/{pmenu_id: [\d]+}/user_id', function(Request $request, Response $response, $args) {
    $pmenu_id = $request->getAttribute('pmenu_id');
    $personal_menu = new PersonalMenus($this->db);
    $response = $personal_menu->select('user_id', $pmenu_id);
    return $response;
})->add($access_mw);

$app->get('/personalMenus/{pmenu_id: [\d]+}/add', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $data = $request->getQueryParams();
    
    if (isset($data['menu_item_id'])) {
        $authentication = new AuthenticationHandler($this->db);
        $session_info = $authentication->getCurrentSession();
        $personal_menu_id = $request->getAttribute('pmenu_id');

        if (isset($session_info['user_id'])) {
            $personal_menu_handler = new PersonalMenuHandler($this->db);
            $auth_personal_menu_id = $personal_menu_handler->getId($session_info['user_id']);

            if ($auth_personal_menu_id == $personal_menu_id) {
                $personal_menu_item_handler = new PersonalMenuItemHandler($this->db);
                $add_item_success = $personal_menu_item_handler->addItem($personal_menu_id, $data['menu_item_id']);
                
                if ($add_item_success) {
                    $result['status'] = 'addition to personal menu successful';
                } else {
                    $result['error'] = 'addition to personal menu failed';
                }

            } else {
                $result['error'] = 'not authorized to edit personal menu';
            }

        } else {
            $result['error'] = 'not authorized to edit personal menu';
        }

    } else {
        $result['error'] = 'expecting parameter menu_item_id';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
    return $response;
})->add($access_mw);

// Restaurants -----------------------------------------------------------

$app->get('/restaurants/all_restaurant_ids', function(Request $request, Response $response) {
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->selectAllIds();
    return $response;
})->add($access_mw);

$app->post('/restaurants/{restaurant_id: [\d]+}/edit', function(Request $request, Response $response) {
    $result = array('error' => NULL);
    $authentication = new AuthenticationHandler($this->db);
    $restaurant_id = $request->getAttribute('restaurant_id');
    $auth = $authentication->checkAuthentication();

    if ($auth) {
        $session_info = $authentication->getCurrentSession();
        if ($session_info['restaurant_id'] == $restaurant_id) {
            $data = $request->getParsedBody();

            if ($_FILES['profile_image_path']['name'] == '') {
                $result['file_upload'] = NULL;
                $restaurant_handler = new RestaurantHandler($this->db);
                $this->db->exec('BEGIN TRANSACTION');
                $email_success = $restaurant_handler->updateEmail($restaurant_id, $data['email']);
                $name_success = $restaurant_handler->updateName($restaurant_id, $data['name']);
                $street_address_success = $restaurant_handler->updateStreetAddress($restaurant_id, $data['street_address']);
                //$city_success = $restaurant_handler->updateCity($restaurant_id, $data['city']);
                //$state_success = $restaurant_handler->updateState($restaurant_id, $data['state']);
                $phone_number_success = $restaurant_handler->updatePhoneNumber($restaurant_id, $data['phone_number']);
                $website_url_success = $restaurant_handler->updateWebsiteUrl($restaurant_id, $data['website_url']);
                $biography_success = $restaurant_handler->updateBiography($restaurant_id, $data['biography']);
                $time_open_sucess = $restaurant_handler->updateTimeOpen($restaurant_id, $data['time_open']);
                $time_close_success = $restaurant_handler->updateTimeClose($restaurant_id, $data['time_close']);
                $price_rating_success = $restaurant_handler->updatePriceRating($restaurant_id, $data['price_rating']);
                $cuisine_type_success = $restaurant_handler->updateCuisineType($restaurant_id, $data['cuisine_type']);

                if ($email_success && $name_success && $street_address_success && $phone_number_success && $website_url_success && $biography_success && $time_open_sucess && $time_close_success && $price_rating_success && $cuisine_type_success) {
                    $this->db->exec('COMMIT');
                    $result['status'] = 'update successful';
                } else {
                    $this->db->exec('ROLLBACK');
                    $result['error'] = 'update failed';
                }

            } else {
                //Source: http://www.w3schools.com/php/php_file_upload.asp
                $file_to_upload = $_FILES['profile_image_path']['name'];
                $image_file_type = pathinfo($file_to_upload, PATHINFO_EXTENSION);
                $target_file = '../images/restaurants/' . $restaurant_id . '_' . date('Ymdhis') . '.' . $image_file_type;
                $image_check = getimagesize($_FILES['profile_image_path']['tmp_name']);

                if ($image_check) {
                    if (move_uploaded_file($_FILES['profile_image_path']['tmp_name'], $target_file)) {
                        $result['file_upload'] = 'success';

                        $restaurant_handler = new RestaurantHandler($this->db);
                        $this->db->exec('BEGIN TRANSACTION');
                        $email_success = $restaurant_handler->updateEmail($restaurant_id, $data['email']);
                        $name_success = $restaurant_handler->updateName($restaurant_id, $data['name']);
                        $street_address_success = $restaurant_handler->updateStreetAddress($restaurant_id, $data['street_address']);
                        $city_success = $restaurant_handler->updateCity($restaurant_id, $data['city']);
                        $state_success = $restaurant_handler->updateState($restaurant_id, $data['state']);
                        $phone_number_success = $restaurant_handler->updatePhoneNumber($restaurant_id, $data['phone_number']);
                        $website_url_success = $restaurant_handler->updateWebsiteUrl($restaurant_id, $data['website_url']);
                        $biography_success = $restaurant_handler->updateBiography($restaurant_id, $data['biography']);
                        $time_open_sucess = $restaurant_handler->updateTimeOpen($restaurant_id, $data['time_open']);
                        $time_close_success = $restaurant_handler->updateTimeClose($restaurant_id, $data['time_close']);
                        $price_rating_success = $restaurant_handler->updatePriceRating($restaurant_id, $data['price_rating']);
                        $cuisine_type_success = $restaurant_handler->updateCuisineType($restaurant_id, $data['cuisine_type']);
                        $image_path_success = $restaurant_handler->updateProfileImagePath($restaurant_id, $target_file);

                        if ($email_success && $name_success && $street_address_success && $city_success && $state_success && $phone_number_success && $website_url_success && $biography_success && $time_open_sucess && $time_close_success && $price_rating_success && $cuisine_type_success && $image_path_success) {
                            $this->db->exec('COMMIT');
                            $result['status'] = 'update successful';
                        } else {
                            $this->db->exec('ROLLBACK');
                            $result['error'] = 'update failed';
                        }
                    } else {
                        $result['error'] = 'file upload failed';
                    }
                } else {
                    $result['error'] = 'file upload failed';
                }
            }
        } else {
            $result['error'] = 'not authorized to edit user';
        }
    } else {
        $result['error'] = 'user not logged in';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/account_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("account_id", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/email', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("email", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/name', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("name", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/street_address', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("street_address", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/city', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("city", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/state', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("state", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/phone_number', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("phone_number", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/menu_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $menu_handler = new MenuHandler($this->db);
    $result = array('menu_id' => $menu_handler->getId($rest_id));

    if ($result['smenu_id'] == NULL) {
        $result = array('error' => 'failed to get menu id');
    }

    $response->getBody()->write(json_encode($result));
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("cuisine_type_id", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/price_rating_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("price_rating_id", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/website_url', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("website_url", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/biography', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("biography", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/profile_image_path', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("profile_image_path", $rest_id);
    return $response;
})->add($access_mw);


$app->get('/restaurants/{rest_id: [\d]+}/time_open', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("time_open", $rest_id);
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id: [\d]+}/time_close', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db);
    $response = $restaurant->select("time_close", $rest_id);
    return $response;
})->add($access_mw);

// Menus -----------------------------------------------------------------

$app->get('/menus/all_menu_ids', function(Request $request, Response $response) {
    $menu = new Menus($this->db);
    $response = $menu->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/menus/{menu_id: [\d]+}/all_menu_item_ids', function(Request $request, Response $response, $args) {
    $menu_id = $request->getAttribute('menu_id');
    $menu_item_handler = new MenuItemHandler($this->db);
    $menu_item_ids = $menu_item_handler->getAllIds($menu_id);

    if (empty($menu_item_ids)) {
        $result = array('error' => 'failed to get menu item ids');
        $json = json_encode($result, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    } else {
        $result = array();
        foreach ($menu_item_ids as $menu_item_id) {
            $result[] = array('menu_item_id' => $menu_item_id); 
        }
        $json = json_encode($result, JSON_NUMERIC_CHECK);
        $response->getBody()->write($json);
    }

    return $response;
})->add($access_mw);

$app->get('/menus/{menu_id: [\d]+}/restaurant_id', function(Request $request, Response $response) {
    $menu_id = $request->getAttribute('menu_id');
    $menu = new Menus($this->db);
    $response = $menu->select('restaurant_id', $menu_id);
    return $response;
})->add($access_mw);

$app->post('/menus/{menu_id: [\d]+}/add', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $authentication = new AuthenticationHandler($this->db);
    $menu_id = $request->getAttribute('menu_id');
    $auth = $authentication->checkAuthentication();

    if ($auth) {
        $session_info = $authentication->getCurrentSession();
        $auth_restaurant_id = $session_info['restaurant_id'];
        $menu_handler = new MenuHandler($this->db);
        $auth_menu_id = $menu_handler->getId($auth_restaurant_id);

        if ($auth_menu_id == $menu_id) {
            $data = $request->getParsedBody();
            if ($_FILES['image_path']['name'] == '') {
                $result['file_upload'] = NULL;
                $this->db->exec('BEGIN TRANSACTION');
                $menu_item_handler = new MenuItemHandler($this->db);
                $menu_item_add_success = $menu_item_handler->addMenuItem($menu_id, $data['name'], $data['cuisine_type'], $data['meal_type'], $data['price'], $data['description'], '../images/menu_items/default-menu-item-image.jpg');

                if ($menu_item_add_success) {
                    $this->db->exec('COMMIT');
                    $result['status'] = 'update successful';
                } else {
                    $this->db->exec('ROLLBACK');
                    $result['error'] = 'update failed';
                }
            } else {
                //Source: http://www.w3schools.com/php/php_file_upload.asp
                $file_to_upload = $_FILES['image_path']['name'];
                $image_file_type = pathinfo($file_to_upload, PATHINFO_EXTENSION);
                $target_file = '../images/menu_items/' . $menu_id . '_' . date('Ymdhis') . '.' . $image_file_type;
                $image_check = getimagesize($_FILES['image_path']['tmp_name']);

                if ($image_check) {

                    if (move_uploaded_file($_FILES['image_path']['tmp_name'], $target_file)) {
                        $result['file_upload'] = 'success';
                        $this->db->exec('BEGIN TRANSACTION');
                        $menu_item_handler = new MenuItemHandler($this->db);
                        $menu_item_add_success = $menu_item_handler->addMenuItem($menu_id, $data['name'], $data['cuisine_type'], $data['meal_type'], $data['price'], $data['description'], $target_file);

                        if ($menu_item_add_success) {
                            $this->db->exec('COMMIT');
                            $result['status'] = 'addition successful';
                        } else {
                            $this->db->exec('ROLLBACK');
                            $result['error'] = 'addition failed';
                        }

                    } else {
                        $result['error'] = 'file upload failed';
                    }
                } else {
                    $result['error'] = 'file upload failed';
                }
            }
        } else {
            $result['error'] = 'not authorized to edit menu';
        }
    } else {
        $result['error'] = 'not authorized to edit menu';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
    return $response;
})->add($access_mw);

// Menu Items ------------------------------------------------------------

$app->get('/menuItems/all_menu_item_ids', function(Request $request, Response $response) {
    $menuItem = new MenuItems($this->db);
    $response = $menuItem->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/name', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("name", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/menu_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("menu_id", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("cuisine_type_id", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/meal_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("meal_type_id", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/image_path', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("image_path", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/price', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("price", $item_id);
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id: [\d]+}/description', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db);
    $response = $item->select("description", $item_id);
    return $response;
})->add($access_mw);

// Meal Types ------------------------------------------------------------

$app->get('/mealTypes/all_meal_type_ids', function(Request $request, Response $response) {
    $mealType = new MealTypes($this->db);
    $response = $mealType->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/mealTypes/{mtype_id: [\d]+}/type', function(Request $request, Response $response, $args) {
    $mtype_id = $request->getAttribute('mtype_id');
    $m_type = new MealTypes($this->db);
    $response = $m_type->select("type", $mtype_id);
    return $response;
})->add($access_mw);

// Cuisine Types ---------------------------------------------------------

$app->get('/cuisineTypes/all_cuisine_type_ids', function(Request $request, Response $response) {
    $cuisineType = new CuisineTypes($this->db);
    $response = $cuisineType->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/cuisineTypes/{ctype_id: [\d]+}/type', function(Request $request, Response $response, $args) {
    $ctype_id = $request->getAttribute('ctype_id');
    $cuis_type = new CuisineTypes($this->db);
    $response = $cuis_type->select("type", $ctype_id);
    return $response;
})->add($access_mw);

// Price Ratings ---------------------------------------------------------

$app->get('/priceRatings/all_price_rating_ids', function(Request $request, Response $response) {
    $priceRating = new PriceRatings($this->db);
    $response = $priceRating->selectAllIds();
    return $response;
})->add($access_mw);

$app->get('/priceRatings/{pr_id: [\d]+}/rating', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db);
    $response = $pr->select("rating", $pr_id);
    return $response;
})->add($access_mw);

$app->get('/priceRatings/{pr_id: [\d]+}/highest_price', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db);
    $response = $pr->select("highest_price", $pr_id);
    return $response;
})->add($access_mw);

$app->get('/priceRatings/{pr_id: [\d]+}/lowest_price', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db);
    $response = $pr->select("lowest_price", $pr_id);
    return $response;
})->add($access_mw);

// RUN THE APPLICATION
$app->run();