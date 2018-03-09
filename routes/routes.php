<?php
$route->addGroup('/overfast', function (\FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/test', 'Test/Demo/echoTest');
});

