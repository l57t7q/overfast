<?php
define('RPATH', realpath(__DIR__.'/../'));
define('APATH', RPATH . '/app/');
define('BPATH', RPATH . '/bootstrap/');
define('VERSION', '1.0');

include RPATH . '/vendor/autoload.php';