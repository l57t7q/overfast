# OverFast
=======================================

The super-lightweight PHP framework is based on FastRoute and Medoo.

Install
-------

To install with composer:

```sh
composer require l57t7q/overfast
```

#Usage
-----

It's very easy to use this framework and here's a basic usage example:

### Database operations
First you should define database configuration in `.env` and register database in `database.php`:
```sh
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password
``` 

```php
<?php
return [
    'default' => [
        'driver'   => 'mysql',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', 'demo'),
        'username' => env('DB_USERNAME', 'root'),
        'password' => env('DB_PASSWORD', 'password'),
        'charset'  => 'utf8',
        ],
];
````
Second create database object:
```php
$db = DB::getConnection('default');
```

Now you can write your own sql, here's some basic example:
```php
$db->select('demo', '*', ['Id[<]' => 77]);
```

For more guide please view `Medoo` official document(https://medoo.in/doc)


### Defining routes

You can register route in `routes.php`.The routes are added by calling `addroute()` on the collector instance:
```php
$r->addRoute($method, $routePattern, $handler);
```
The `$method` is an uppercase HTTP method string for which a certain route should match. It
is possible to specify multiple valid methods using an array:

```php
// These two calls
$r->addRoute('GET', '/test', 'handler');
$r->addRoute('POST', '/test', 'handler');
// Are equivalent to this one call
$r->addRoute(['GET', 'POST'], '/test', 'handler');
```
By default the `$routePattern` uses a syntax where `{foo}` specifies a placeholder with name `foo`
and matching the regex `[^/]+`. To adjust the pattern the placeholder matches, you can specify
a custom pattern by writing `{bar:[0-9]+}`. Some examples:

```php
// Matches /user/42, but not /user/xyz
$r->addRoute('GET', '/user/{id:\d+}', 'handler');

// Matches /user/foobar, but not /user/foo/bar
$r->addRoute('GET', '/user/{name}', 'handler');

// Matches /user/foo/bar as well
$r->addRoute('GET', '/user/{name:.+}', 'handler');
```

Custom patterns for route placeholders cannot use capturing groups. For example `{lang:(en|de)}`
is not a valid placeholder, because `()` is a capturing group. Instead you can use either
`{lang:en|de}` or `{lang:(?:en|de)}`.

Furthermore parts of the route enclosed in `[...]` are considered optional, so that `/foo[bar]`
will match both `/foo` and `/foobar`. Optional parts are only supported in a trailing position,
not in the middle of a route.


```php
// This route
$r->addRoute('GET', '/user/{id:\d+}[/{name}]', 'handler');
// Is equivalent to these two routes
$r->addRoute('GET', '/user/{id:\d+}', 'handler');
$r->addRoute('GET', '/user/{id:\d+}/{name}', 'handler');

// Multiple nested optional parts are possible as well
$r->addRoute('GET', '/user[/{id:\d+}[/{name}]]', 'handler');

// This route is NOT valid, because optional parts can only occur at the end
$r->addRoute('GET', '/user[/{id:\d+}]/{name}', 'handler');
```

The `$handler` parameter does not necessarily have to be a callback, it could also be a controller
class name or any other kind of data you wish to associate with the route. FastRoute only tells you
which handler corresponds to your URI, how you interpret it is up to you.

#### Shorcut methods for common request methods

For the `GET`, `POST`, `PUT`, `PATCH`, `DELETE` and `HEAD` request methods shortcut methods are available. For example:

```php
$r->get('/get-route', 'get_handler');
$r->post('/post-route', 'post_handler');
```

Is equivalent to:

```php
$r->addRoute('GET', '/get-route', 'get_handler');
$r->addRoute('POST', '/post-route', 'post_handler');
```

#### Route Groups

Additionally, you can specify routes inside of a group. All routes defined inside a group will have a common prefix.

For example, defining your routes as:

```php
$r->addGroup('/admin', function (RouteCollector $r) {
    $r->addRoute('GET', '/do-something', 'handler');
    $r->addRoute('GET', '/do-another-thing', 'handler');
    $r->addRoute('GET', '/do-something-else', 'handler');
});
```

Will have the same result as:

 ```php
$r->addRoute('GET', '/admin/do-something', 'handler');
$r->addRoute('GET', '/admin/do-another-thing', 'handler');
$r->addRoute('GET', '/admin/do-something-else', 'handler');
 ```

Nested groups are also supported, in which case the prefixes of all the nested groups are combined.

### Caching

The reason `simpleDispatcher` accepts a callback for defining the routes is to allow seamless
caching. By using `cachedDispatcher` instead of `simpleDispatcher` you can cache the generated
routing data and construct the dispatcher from the cached information:

```php
<?php

$dispatcher = FastRoute\cachedDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/user/{name}/{id:[0-9]+}', 'handler0');
    $r->addRoute('GET', '/user/{id:[0-9]+}', 'handler1');
    $r->addRoute('GET', '/user/{name}', 'handler2');
}, [
    'cacheFile' => __DIR__ . '/route.cache', /* required */
    'cacheDisabled' => IS_DEBUG_ENABLED,     /* optional, enabled by default */
]);
```

The second parameter to the function is an options array, which can be used to specify the cache
file location, among other things.
