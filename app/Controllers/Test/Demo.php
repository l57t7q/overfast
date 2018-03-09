<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/9
 * Time: 14:15
 */

namespace App\Controllers\Test;


class Demo
{
    public function echoTest() {
        echo "Hello World";
        $res = requeset('getId');
        echo $res->getId;
    }
}