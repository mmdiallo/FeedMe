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
foreach (glob('../classes/*.php') as $filename)
{
    require $filename;
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

// MIDDLEWARE

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
    $authentication = new AuthenticationHandler;
    $current_auth = $authentication->checkAuthentication();
    $request->withAttribute('session', $_SESSION);
    $request->withAttribute('auth', $current_auth);
    $response = $next($request, $response);
    return $response;
};

// if not authenticated, redirect to home
$authentication_redirect = function(Request $request, Response $response, $next) {
    $response = $next($request, $response);
    return $response;
};

// if authenticated, redirect to home
// prevents access to login and create account pages for already authenticated users
$authentication_redirect_2 = function(Request $request, Response $response, $next) {
    $response = $next($request, $response);
    return $response;
};

// if not authenticated, return error response
$authentication_response = function(Request $request, Response $response, $next) {
    $response = $next($request, $response);
    return $response;
};

// if authenticated, return error response
// prevents access to login and create account pages for already authenticated users
$authentication_response_2 = function(Request $request, Response $response, $next) {
    $result = array('error' => null);
    $response = $next($request, $response);
    $authentication = new AuthenticationHandler;
    $current_auth = $authentication->checkAuthentication();
    if ($current_auth) {
        $result['error'] = 'user already logged in';
        $json = json_encode($result);
        $response->getBody()->write($json);
    } else {
        $request->withAttribute('result', $result);
        $next($request, $response);
    }
    return $response;
};

// ROUTES

// Home Page
$app->get('/', function(Request $request, Response $response) {
    $response->getBody()->write('<h1>Home</h1>');
    $auth = $request->getAttribute('auth');

    if (!$auth) {
        $begin_div = '<div style="margin: 8;">';
        $login_link = '<a style="padding: 8;" href="/login"> Login </a>';
        $create_user_account_link = '<a style="padding: 8;" href="/create_user_account"> Create User Account </a>';
        $create_restaurant_account_link = '<a style="padding: 8;" href="/create_restaurant_account"> Create Restaurant Account </a>';
        $users_link = '<a style="padding: 8;" href="/users"> Users </a>';
        $menus_link = '<a style="padding: 8;" href="/menus"> Menus </a>';
        $end_div = '</div>';
        $response->getBody()->write($begin_div);
        $response->getBody()->write($login_link);
        $response->getBody()->write($create_user_account_link);
        $response->getBody()->write($create_restaurant_account_link);
        $response->getBody()->write($users_link);
        $response->getBody()->write($menus_link);
        $response->getBody()->write($end_div);
    }

    $response->getBody()->write('<div style="margin: 8;"><a style="padding: 8;" href="/database_setup/0"> Database Setup </a></div>');
    return $response;
})->add($session_mw);

// Login Page
$app->get('/login', function(Request $request, Response $response) {   
    return $response;
});

// Create User Account Page
$app->get('/create_user_account', function(Request $request, Response $response) {
    $form = new Form;
    $form_string = $form->registerForm('/create_user_account');
    $response->getBody()->write($form_string);
    return $response;
});

$app->post('/create_user_account', function(Request $request, Response $response) {
    $data = $request->getParsedBody();
    $username = $data['username'];
    $result = $request->getAttribute('result');
    $valid_username = preg_match('/^[a-zA-z][\w]*$/', $username);
    if (!$valid_username) {
        $result['error'] = 'invalid username';
    } else {
        $random_string = uniqid();
        $password_salt = hash('sha256', $random_string);
        $password = $data['username'];
        $initial_password_hash = hash('sha256', $password);
        $password_hash_with_salt = $password_salt . $initial_password_hash . $password_salt;
        $final_password_hash = password_hash($password_hash_with_salt, PASSWORD_BCRYPT);
    }
    return $response;
})->add($authentication_response_2);

// Create Restaurant Account Page
$app->get('/create_restaurant_account', function(Request $request, Response $response) {
    $form = new Form;
    $form_string = $form->registerRestaurantForm('/create_restaurant_account');
    $response->getBody()->write($form_string);
    return $response;
});

$app->post('/create_restaurant_account', function(Request $request, Response $response) {
    $data = $request->getParsedBody();
    //$email = $data['Email'];
    //$result = $request->getAttribute('result');
    //echo $email;
    echo $data;
    return $response;
});



// Database Creation Pages
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

// Users routes
$app->get('/users', function(Request $request, Response $response, $args) {
    $response->getBody()->write('<h1>Please add a user ID</h1>');
    return $response;
});

$app->get('/users/{uid}/email', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("email");
    return $response;
});

$app->get('/users/{uid}/first_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("first_name");
    return $response;
});

$app->get('/users/{uid}/last_name', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("last_name");
    return $response;
});

$app->get('/users/{uid}/personal_menu_id', function(Request $request, Response $response, $args) {
    $uid = $request->getAttribute('uid');
    $user = new Users($this->db, $uid);
    $response = $user->select("personal_menu_id");
    return $response;
});


// Restaurants routes
$app->get('/restaurants/{rest_id}/account_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("account_id");
    return $response;
});

$app->get('/restaurants/{rest_id}/email', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("email");
    return $response;
});

$app->get('/restaurants/{rest_id}/name', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("name");
    return $response;
});

$app->get('/restaurants/{rest_id}/street_address', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("street_address");
    return $response;
});

$app->get('/restaurants/{rest_id}/city', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("city");
    return $response;
});

$app->get('/restaurants/{rest_id}/state', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("state");
    return $response;
});

$app->get('/restaurants/{rest_id}/phone_number', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("phone_number");
    return $response;
});

$app->get('/restaurants/{rest_id}/hours_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("hours_id");
    return $response;
});

$app->get('/restaurants/{rest_id}/menu_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("menu_id");
    return $response;
});

$app->get('/restaurants/{rest_id}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("cuisine_type_id");
    return $response;
});

$app->get('/restaurants/{rest_id}/price_rating_id', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("price_rating_id");
    return $response;
});

$app->get('/restaurants/{rest_id}/website_url', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("website_url");
    return $response;
});

$app->get('/restaurants/{rest_id}/biography', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("biography");
    return $response;
});

$app->get('/restaurants/{rest_id}/profile_image_path', function(Request $request, Response $response, $args) {
    $rest_id = $request->getAttribute('rest_id');
    $restaurant = new Restaurants($this->db, $rest_id);
    $response = $restaurant->select("profile_image_path");
    return $response;
});


// Menu routes
$app->get('/menus/{menu_id}/all_menu_items_id', function(Request $request, Response $response, $args) {
    $menu_id = $request->getAttribute('menu_id');
    $menu = new Menus($this->db, $menu_id);
    $response = $menu->selectAll();
    return $response;
});


// MenuItems routes
$app->get('/menuItems/{menu_items_id}/name', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("name");
    return $response;
});

$app->get('/menuItems/{menu_items_id}/menu_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("menu_id");
    return $response;

});

$app->get('/menuItems/{menu_items_id}/cuisine_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("cuisine_type_id");
    return $response;

});

$app->get('/menuItems/{menu_items_id}/meal_type_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("meal_type_id");
    return $response;

});

$app->get('/menuItems/{menu_items_id}/image_path', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("image_path");
    return $response;
});

$app->get('/menuItems/{menu_items_id}/price', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("price");
    return $response;
});

$app->get('/menuItems/{menu_items_id}/description', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('menu_items_id');
    $item = new MenuItems($this->db, $item_id);
    $response = $item->select("description");
    return $response;
});


$app->get('/personalMenuItems/{personal_menu_items_id}/menu_items_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('personal_menu_items_id');
    $item = new PersonalMenuItems($this->db, $item_id);
    $response = $item->select("menu_items_id");
    return $response;
});

$app->get('/personalMenuItems/{personal_menu_items_id}/user_id', function(Request $request, Response $response, $args) {
    $item_id = $request->getAttribute('personal_menu_items_id');
    $item = new PersonalMenuItems($this->db, $item_id);
    $response = $item->select("user_id");
    return $response;
});


// RUN THE APPLICATION
$app->run();