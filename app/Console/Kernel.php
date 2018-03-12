<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/10
 * Time: 11:23
 */

namespace App\Console;


class Kernel
{
    public static function run() {
        $argv = $_SERVER['argv'];
        unset($argv[0]);
        $command = array_shift($argv);
        $command = empty($command) ? 'help' : $command;

        $file = 'App\Console\Commands';
        $command = explode('/', $command);
        foreach ($command as $value) {
            $file = $file . '\\' . $value;
        }
        echo $file;
        exit();
        $obj = new $command[$argv];
        $obj->start();
    }
}