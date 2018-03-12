<?php
session_start();
$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();
date_default_timezone_set('Asia/Shanghai');

$tmp = isCli();
isCli() ? \Boot\CLI::run() : \Boot\FPM::run();