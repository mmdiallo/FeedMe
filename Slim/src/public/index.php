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
require '../classes/DatabaseCreation.php';
require '../classes/Form.php';
require '../classes/AuthenticationHandler.php';
require '../classes/AccountHandler.php';


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
$authentication_response = function(Request $request, Response $response, $next) {
    // $response = $next($request, $response);
    return $response;
};

// if authenticated, return error response
// prevents access to login and create account pages for already authenticated users
$authentication_response_2 = function(Request $request, Response $response, $next) {
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
    $accountHandler = new AccountHandler($this->db);
    $valid_username = $accountHandler->validateUsername($username);

    if (!$valid_username) {
        $result['error'] = 'invalid username';
    } else {
        $password_salt = $accountHandler->createPasswordSalt();
        $password_hash = $accountHandler->hashPassword($password, $password_salt);
        $account_type_id = $accountHandler->getAccountTypeId('user');
        $account_creation_success = $accountHandler->createAccount($username, $password_hash, $password_salt, $account_type_id);

        if ($account_creation_success) {
            $account_id = $accountHandler->getAccountId($username);
            $user_id = $accountHandler->getUserId($account_id);
            $result['account_id'] = $account_id;
            $result['account_type'] = 'user';
            $result['user_id'] = $user_id;

            $authenticationHandler = new AuthenticationHandler($this->db);
            $authenticationHandler->authenticateSession($account_id, 'user', $user_id);

        } else {
            $result['error'] = 'account creation unsuccessful';
        }
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
})->add($authentication_response_2);

$app->post('/create_restaurant_account', function(Request $request, Response $response) {
    $result = $request->getAttribute('result');
    $data = $request->getParsedBody();
    $username = $data['username'];
    $password = $data['password'];
    $accountHandler = new AccountHandler($this->db);
    $valid_username = $accountHandler->validateUsername($username);

    if (!$valid_username) {
        $result['error'] = 'invalid username';
    } else {
        $password_salt = $accountHandler->createPasswordSalt();
        $password_hash = $accountHandler->hashPassword($password, $password_salt);
        $account_type_id = $accountHandler->getAccountTypeId('user');
        $account_creation_success = $accountHandler->createAccount($username, $password_hash, $password_salt, $account_type_id);

        if ($account_creation_success) {
            $account_id = $accountHandler->getAccountId($username);
            // $user_id = $accountHandler->getUserId($account_id);
            // $result['account_id'] = $account_id;
            // $result['account_type'] = 'user';
            // $result['user_id'] = $user_id;

            // $authenticationHandler = new AuthenticationHandler($this->db);
            // $authenticationHandler->authenticateSession($account_id, 'user', $user_id);

        } else {
            $result['error'] = 'account creation unsuccessful';
        }
    }

    $json = json_encode($result, JSON_NUMERIC_CHECK);
    $response->write($json);
    return $response;
})->add($authentication_response_2);

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
    // return $response;
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