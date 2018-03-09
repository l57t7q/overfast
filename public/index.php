<?php
use App\Controllers\Response;
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../bootstrap/bootstrap.php';
//require __DIR__.'/config/database.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    require __DIR__.'/../routes/routes.php';
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
       	Response::json(array(),404,'NOT_FOUND');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        Response::json(array(),405,'METHOD_NOT_ALLOWED');
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = explode('/', $routeInfo[1]);
        $handler[0] = "App\Controllers\\" . $handler[0] . "\\". $handler[1];
        $obj = new $handler[0];
        $method = $handler[2];
        $vars = $routeInfo[2];
        try {
//            call_user_func_array(array($obj,$method),$vars);
            call_user_func_array(array($obj,$method), $vars);
        } catch (Throwable $e) {
            $logger->error($e);
        }
        break;
}