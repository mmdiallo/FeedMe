<?php
// START SESSION
session_set_cookie_params(0, '/', '', true, true);
session_name('by_PHPSESSID');
session_start();
session_regenerate_id(true);

// SET UP SLIM APPLICATION
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once  '../vendor/autoload.php';
require_once '../classes/DatabaseCreation.php';
require_once '../classes/Form.php';
require_once '../classes/AuthenticationHandler.php';
require_once '../classes/AccountHandler.php';


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
    $account = new AccountHandler($this->db);
    $account_creation_success = $account->createUserAccount($username, $password);

    if ($account_creation_success) {
        $account_information = $account->getAccountInformation($username);

        if (!empty($account_information['user_id'])) {
            $result['account_id'] = $account_information['account_id'];
            $result['account_type'] = $account_information['account_type'];
            $result['user_id'] = $account_information['user_id'];

            $authenticationHandler = new AuthenticationHandler($this->db);
            $authenticationHandler->authenticateSession($result['account_id'], $result['account_type'], $result['user_id']);
        } else {
             $result['error'] = 'account creation failed';
        }

    } else {
        $result['error'] = 'account creation failed';
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
    $account = new AccountHandler($this->db);
    $account_creation_success = $account->createRestaurantAccount($username, $password);
    
    if ($account_creation_success) {
        $account_information = $account->getAccountInformation($username);

        if (!empty($account_information['restaurant_id'])) {
            $result['account_id'] = $account_information['account_id'];
            $result['account_type'] = $account_information['account_type'];
            $result['restaurant_id'] = $account_information['restaurant_id'];

            $authenticationHandler = new AuthenticationHandler($this->db);
            $authenticationHandler->authenticateSession($result['account_id'], $result['account_type'], $result['restaurant_id']);
        } else {
             $result['error'] = 'account creation failed';
        }

    } else {
        $result['error'] = 'account creation failed';
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
    $authentication->endSession();
    $current_auth = $authentication->checkAuthentication();

    if (!$current_auth) {
        $result['status'] = 'logout successful';
    } else {
        $result['error'] = 'logout failed';
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
});

// Accounts --------------------------------------------------------------

// Users -----------------------------------------------------------------

// Personal Menus --------------------------------------------------------

// Personal Menu Items ---------------------------------------------------

// Restaurants -----------------------------------------------------------

// Menus -----------------------------------------------------------------

// Menu Items ------------------------------------------------------------

// Meal Types ------------------------------------------------------------

// Cuisine Types ---------------------------------------------------------

// Price Ratings ---------------------------------------------------------

// Hours -----------------------------------------------------------------

// TESTING ROUTES ---------------------------------------------------------------------------------

// Home ------------------------------------------------------------------

// Home Page
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
        }
    }

    $response->getBody()->write($end_div);
    return $response;
})->add($session_mw);

// Account Creation and Login --------------------------------------------

// Login Page
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

// Database Creation -----------------------------------------------------

// Database Creation Pages
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