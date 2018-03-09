<?php
$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$logger = new \Katzgrau\KLogger\Logger(__DIR__.'/../storage/logs', \Psr\Log\LogLevel::ERROR, ["extension"=>"log","filename"=>date("Y-m-d")]);

$timezone = env('APP_TIMEZONE', 'Asia/Shanghai');
date_default_timezone_set($timezone);