<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../functions/database.php';

$config['displayErrorDetails'] = true;
$config['db']['filename'] = '../database/feed_me.sqlite';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

$container['db'] = function($c) {
    $db = $c['settings']['db'];
    $sqlite = new Sqlite3($db['filename']);
    return $sqlite;
};

$https_middleware = function(Request $request, Response $response, $next) {
    if (empty($_SERVER['HTTPS'])) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit;
    } else {
        $response = $next($request, $response);
    }
    return $response;
};

$mw_1 = function(Request $request, Response $response, $next) {
    $response->getBody()->write("1, before ");
    $response = $next($request, $response);
    $response->getBody()->write("1, after");
    return $response;
};

$app->group('/', function() use ($app){
    $app->get('', function(Request $request, Response $response) {
        $response->getBody()->write('<h1>Home</h1>');
        return $response;
    });

    $app->get('help', function (Request $request, Response $response, $args) {
        $response->getBody()->write('Home Page');
        return $response;
    });

})->add($https_middleware);

$app->get('/database_setup/{num: [\d]+}', function(Request $request, Response $response, $args) {
    $script_number = (int)$args['num'];
    $next_script_number = $script_number + 1;
    $next_page = '/database_setup/' . $next_script_number;
    $next_page_link = '<br><a href="' . $next_page . '"> Next </a>';
    $result = createTable($this->db, $script_number);
    $response->getBody()->write($result);
    $response->getBody()->write($next_page_link);

    return $response;
})->add($https_middleware);

$app->run();