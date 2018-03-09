<?php
/**
 * Created by PhpStorm.
 * User: TianQi
 * Date: 2018/3/8
 * Time: 11:27
 */

namespace App;


use Medoo\Medoo;

/**
 * Class DB
 * @package App
 * @author TianQi
 */
class DB
{

    private static $_connections;

    private static $_activeConnections = array();

    private function __construct() {
    }

    public function __clone() {
    }

    /**
     * @author TianQi
     * @param string $database
     * @return mixed
     * @throws \Exception
     */
    public static function getConnection($database='default') {
        if (!self::$_connections && empty(self::$_connections)) {
            self::$_connections = require_once __DIR__."/../config/database.php";
        }
        if (!isset(self::$_activeConnections[$database])) {
            if (!isset(self::$_connections[$database])) {
                throw new \Exception('Connection "' . $database . '" is not configured.');
            }
            $config = [
                'database_type' => self::$_connections[$database]['driver'],
                'database_name' => self::$_connections[$database]['database'],
                'server' => self::$_connections[$database]['host'],
                'username' => self::$_connections[$database]['username'],
                'password' => self::$_connections[$database]['password']
            ];
            self::$_activeConnections[$database] = new Medoo($config);
        }
        return self::$_activeConnections[$database];
    }
}