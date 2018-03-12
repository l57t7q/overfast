<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/10
 * Time: 15:16
 */

namespace App\Console;


class Base
{
    private static $_stime;
    private static $_etime;

    public $commands = [
        [
            'name' => 'Help',
            'desc' => 'Show all commands',
            'param'=> 'none'
        ],
    ];

    public function __construct()
    {
        $this->_setStartTime();
        self::_welcome();
    }

    private function _setStartTime() {
        self::$_stime = microtime(true);
    }

    private function _runningTime() {
        return round(self::$_etime - self::$_stime, 4);
    }

    private function _setEndTime() {
        self::$_etime = microtime(true);
    }

    private static function _welcome() {
        $str = "=====================================================" . PHP_EOL
             . "=                      Overfast                     =" . PHP_EOL
             . "=                                                   =" . PHP_EOL
             . "=                Frame Version:" . VERSION."\t\t    =" . PHP_EOL
             . "=====================================================" . PHP_EOL;
        echo $str ;
    }

    public function googbye() {
        $this->_setEndTime();
        $str = PHP_EOL
             ."----------------------------------------------------"   . PHP_EOL
             . "             Running Time " . $this->_runningTime()    . PHP_EOL
             . "----------------------------------------------------"  . PHP_EOL;
        echo $str;
    }

    public function showCommand() {
        array_walk($this->commands, function ($a) {
            echo PHP_EOL;
            echo "[Command]: php run " . $a['name'] . ' [Desc]:' . $a['desc'] ." [Param]: ".$a['param'] .PHP_EOL;
        });
    }
}