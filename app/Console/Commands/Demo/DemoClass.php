<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/12
 * Time: 11:09
 */

namespace App\Console\Commands\Demo;
use App\Console\Base;

class DemoClass extends Base
{
    public function start(...$param) {
        var_dump($param);
        echo "Hello World";
        $this->googbye();
    }
}