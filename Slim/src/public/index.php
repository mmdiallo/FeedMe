<?php
// START SESSION
session_set_cookie_params(0, '/', '', true, true);
session_name('by_PHPSESSID');
session_start();
session_regenerate_id(true);

// SET UP SLIM APPLICATION
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

foreach (glob('../classes/*.php') as $filename) {
    require_once $filename;
}

$config['displayErrorDetails'] = true;
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

// check session authentication, send authentication and session to route
$session_mw = function(Request $request, Response $response, $next) {
    $authenticationHandler = new AuthenticationHandler($this->db);
    $current_auth = $authenticationHandler->checkAuthentication();
    $request = $request->withAttribute('session', $_SESSION);
    $request = $request->withAttribute('auth', $current_auth);
    $response = $next($request, $response);
    return $response;
};

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

    if ($auth) {
        $authentication->endSession();
        $current_auth = $authentication->checkAuthentication();

        if (!$current_auth) {
            $result['status'] = 'logout successful';
        } else {
            $result['error'] = 'logout failed';
        }
    } else {
        $result['error'] = 'user not logged in';
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
    $session_info['error'] = $result['error'];
    $json = json_encode($session_info, JSON_NUMERIC_CHECK);
    $response->getBody()->write($json);
})->add($access_mw);

// Users -----------------------------------------------------------------

$app->post('/users/{uid}/edit', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $data = $request->getParsedBody();
    $email = $data['email'];
    $f_name = $data['first_name'];
    $l_name = $data['last_name'];
    $pic_path = $data['image_path'];
    $user = new Users($this->db, $uid);
    $response = $user->edit($email, $f_name, $l_name, $pic_path);
    return $response;
});

$app->get('/users/{uid}/email', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("email");
    return $response;
})->add($access_mw);

$app->get('/users/{uid}/first_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("first_name");
    return $response;
})->add($access_mw);

$app->get('/users/{uid}/last_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("last_name");
    return $response;
})->add($access_mw);

$app->get('/users/{uid}/personal_menu_id', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("personal_menu_id");
    return $response;
})->add($access_mw);

// Personal Menus --------------------------------------------------------

$app->get('/personalMenus/{pmenu_id}/all_pmenu_items_id', function(Request $request, Response $response, $args) {
    $pmenu_id = $request->getAttribute('pmenu_id');
    $pmenu = new PersonalMenus($this->db, $pmenu_id);
    $response = $pmenu->selectAll();
    return $response;
})->add($access_mw);

$app->post('/personalMenus/{pmenu_id}/add', function(Request $request, Response $response, $args) {
    $pmenu_id = $request->getAttribute('pmenu_id');
    $data = $request->getParsedBody();
    $menu_item_id = $data['menu_item_id'];
    $pmenu = new PersonalMenus($this->db, $pmenu_id);
    $response = $pmenu->addItem($menu_item_id);
    return $response;
})->add($access_mw);

// Personal Menu Items ---------------------------------------------------

$app->get('/personalMenuItems/{personal_menu_items_id}/menu_items_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('personal_menu_items_id');
    $item = new PersonalMenuItems($this->db, $item_id);
    $response = $item->select("menu_items_id");
    return $response;
})->add($access_mw);

$app->get('/personalMenuItems/{personal_menu_items_id}/user_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('personal_menu_items_id');
    $item = new PersonalMenuItems($this->db, $item_id);
    $response = $item->select("user_id");
    return $response;
})->add($access_mw);

// Restaurants -----------------------------------------------------------

$app->get('/restaurants/{rest_id}/account_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("account_id");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/email', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("email");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/name', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("name");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/street_address', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("street_address");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/city', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("city");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/state', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("state");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/phone_number', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("phone_number");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/hours_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("hours_id");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/menu_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("menu_id");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("cuisine_type_id");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/price_rating_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("price_rating_id");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/website_url', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("website_url");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/biography', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("biography");
    return $response;
})->add($access_mw);

$app->get('/restaurants/{rest_id}/profile_image_path', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("profile_image_path");
    return $response;
})->add($access_mw);

// Menus -----------------------------------------------------------------

$app->get('/menus/{menu_id}/all_menu_items_id', function(Request $request, Response $response, $args) {
    $menu_id = $request->getAttribute('menu_id');
    $menu = new Menus($this->db, $menu_id);
    $response = $menu->selectAll();
    return $response;
})->add($access_mw);

// Menu Items ------------------------------------------------------------

$app->get('/menuItems/{menu_items_id}/name', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("name");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/menu_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("menu_id");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("cuisine_type_id");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/meal_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("meal_type_id");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/image_path', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("image_path");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/price', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("price");
    return $response;
})->add($access_mw);

$app->get('/menuItems/{menu_items_id}/description', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("description");
    return $response;
})->add($access_mw);

// Meal Types ------------------------------------------------------------

$app->get('/mealtypes/{mtype_id}/type', function(Request $request, Response $response, $args) {
    $mtype_id = $request->getAttribute('mtype_id');
    $m_type = new MealTypes($this->db, $mtype_id);
    $response = $m_type->select("type");
    return $response;
})->add($access_mw);

// Cuisine Types ---------------------------------------------------------

$app->get('/cuisinetypes/{ctype_id}/type', function(Request $request, Response $response, $args) {
    $ctype_id = $request->getAttribute('ctype_id');
    $cuis_type = new CuisineTypes($this->db, $ctype_id);
    $response = $cuis_type->select("type");
    return $response;
})->add($access_mw);

// Price Ratings ---------------------------------------------------------

$app->get('/priceratings/{pr_id}/rating', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db, $pr_id);
    $response = $pr->select("rating");
    return $response;
})->add($access_mw);

$app->get('/priceratings/{pr_id}/high', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db, $pr_id);
    $response = $pr->select("highest_price");
    return $response;
})->add($access_mw);

$app->get('/priceratings/{pr_id}/low', function(Request $request, Response $response, $args) {
    $pr_id = $request->getAttribute('pr_id');
    $pr = new PriceRatings($this->db, $pr_id);
    $response = $pr->select("lowest_price");
    return $response;
})->add($access_mw);

// Hours -----------------------------------------------------------------

// TESTING ROUTES =================================================================================

// Home ------------------------------------------------------------------
$app->get('/', function(Request $request, Response $response) {
    $response->getBody()->write('<h1>Home</h1>');
    $auth = $request->getAttribute('auth');
    $session = $request->getAttribute('session');
    $begin_div = '<div style="margin: 8;">';
    $end_div = '</div>';
    $response->getBody()->write($begin_div);
    if (!$auth) {
        $login_link = '<a style="padding: 8;" href="/login"> Login </a>';
        $create_user_account_link = '<a style="padding: 8;" href="/create_user_account"> Create User Account </a>';
        $create_restaurant_account_link = '<a style="padding: 8;" href="/create_restaurant_account"> Create Restaurant Account </a>';
        $response->getBody()->write($login_link);
        $response->getBody()->write($create_user_account_link);
        $response->getBody()->write($create_restaurant_account_link);
    } else {
        $account_id = $session['account_id'];
        $statement = 'SELECT username FROM Accounts WHERE id=:id';
        $prepared_statement = $this->db->prepare($statement);
        $prepared_statement->bindValue(':id', $account_id, SQLITE3_INTEGER);
        if ($query_result = $prepared_statement->execute()) {
            $row = $query_result->fetchArray();
            $username = $row['username'];
            $response->getBody()->write('<p> Hello, ' . $username . '</p>');
            $logout_link = '<a style="padding: 8;" href="/logout"> Logout </a>';
            $response->getBody()->write($begin_div);
            $response->getBody()->write($logout_link);
            $response->getBody()->write($end_div);
        }
    }
    $response->getBody()->write($end_div);
    return $response;
})->add($session_mw);

// Account Creation ------------------------------------------------------

// Login
$app->get('/login', function(Request $request, Response $response) {
    $form = new Form;
    $form_string = $form->loginForm('/login');
    $response->getBody()->write($form_string);
    return $response;
});

// Create User Account Page
$app->get('/create_user_account', function(Request $request, Response $response) {
    $form = new Form;
    $form_string = $form->loginForm('/create_user_account');
    $response->getBody()->write($form_string);
    return $response;
});

// Create Restaurant Account Page
$app->get('/create_restaurant_account', function(Request $request, Response $response) {
    $form = new Form;
    $form_string = $form->loginForm('/create_restaurant_account');
    $response->getBody()->write($form_string);
    return $response;
});

// Profile --------------------------------------------------------------

$app->get('/profile', function(Request $request, Response $response) {
    $authentication = new AuthenticationHandler($this->db);
    $auth = $authentication->checkAuthentication();
    if ($auth) {
        $session_info = $authentication->getCurrentSession();
        $profile = new Profile($this->db);
        $profile_string = $profile->createProfile($session_info['account_id']);
        $response->getBody()->write($profile_string);
    } else {
        $response->getBody()->write('user not logged in');
    }
    return $response;
});

$app->get('/images/users/{image_path}', function(Request $request, Response $response, $args) {
    $image_path = $request->getAttribute('image_path');
    $image = file_get_contents('../images/users/' . $image_path);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $response = $response->withHeader('Content-Type', $finfo->buffer($image));
    $response->getBody()->write($image);
    return $response;
});

// Editing ---------------------------------------------------------------

// Edit User
$app->get('/users/{user_id}/edit', function (Request $request, Response $response, $args) {
    $authentication = new AuthenticationHandler($this->db);
    $user_id = $request->getAttribute('user_id');
    $auth = $authentication->checkAuthentication();

    if ($auth) {
        $session_info = $authentication->getCurrentSession();
        if ($session_info['user_id'] == $user_id) {
            $form = new Form;
            $form_string = $form->editUser($user);
        } else {
            $response->getBody()->write('not authorized to edit user');
        }
    } else {
        $response->getBody()->write('not authorized to edit user');
    }
});

// Edit Restaurant

// Database Creation -----------------------------------------------------

$app->get('/database_setup', function (Request $request, Response $response) {
    return $response->withStatus(301)->withHeader('Location', '/database_setup/0');
});
$app->get('/database_setup/{num: [\d]+}', function(Request $request, Response $response, $args) {
    $script_number = (int)$args['num'];
    $database_creation = new DatabaseCreation($this->db);
    $result = $database_creation->createTable($script_number);
    $response->getBody()->write($result);
    if ($result != 'invalid request') {
        $next_script_number = $script_number + 1;
        $next_page = '/database_setup/' . $next_script_number;
        $next_page_link = '<br><a href="' . $next_page . '"> Next </a>';
        $response->getBody()->write($next_page_link);
    }
    $response->getBody()->write('<br><br><a href="/"> Home </a>');
    return $response;
});

// RUN THE APPLICATION
$app->run();