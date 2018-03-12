<?php
namespace Boot;
use App\Controllers\Response;
use FastRoute;
class FPM
{

    private static $_entryClass;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private static function _getEntryClass($handler) {
        if (is_null(self::$_entryClass)) {
            $_entryClass = "\App\Controllers";
            for ($i = 0; $i < count($handler) - 1; $i++) {
                $_entryClass = $_entryClass. '\\'. $handler[$i];
            }
            return new $_entryClass;

        }
        return self::$_entryClass;
    }

    public static function run() {

        $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
            require __DIR__.'/../routes/routes.php';
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

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
                $class = self::_getEntryClass($handler);
                try {
                    call_user_func_array(array($class,$handler[2]), $routeInfo[2]);
                } catch (\Throwable $e) {
                    \App\Log::error($e);
                }
        }
    }
}