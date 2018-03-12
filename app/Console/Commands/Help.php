<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/12
 * Time: 11:12
 */

namespace App\Console\Commands;
use App\Console\Base;

class Help extends Base
{
    private $_param;

    public function __construct(...$param)
    {
        $this->_param = $param;
        parent::__construct();
    }

    public function start() {
        $this->showCommand();
        $this->googbye();
    }
}