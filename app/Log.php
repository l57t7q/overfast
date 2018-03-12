<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/10
 * Time: 14:45
 */

namespace App;


class Log
{
    public static $logger;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance() {
        if (is_null(self::$logger)) {
            self::$logger = new \Katzgrau\KLogger\Logger(__DIR__.'/../storage/logs', \Psr\Log\LogLevel::ERROR, ["extension"=>"log","filename"=>date("Y-m-d")]);
        }
        return self::$logger;
    }

    public static function error($e) {
        $logger = self::getInstance();
        $logger->error($e);
        exit(0);
    }

}