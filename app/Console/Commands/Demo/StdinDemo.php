<?php
/**
 * Created by PhpStorm.
 * User: say
 * Date: 2018/3/12
 * Time: 14:42
 */

namespace App\Console\Commands\Demo;


use App\Console\Base;

class StdinDemo extends Base
{
    private $_param;

    public function __construct(...$param)
    {
        $this->_param = $param;
        parent::__construct();
    }

    public function start() {
        fwrite(STDOUT, 'Do you want to clear all files in logs folder?(Y/N)');
        $input = strtoupper(trim(fgets(STDIN)));
        if ($input == "Y") {
            echo "Now clear the logs folder!!";
            system("rm -rf ". RPATH . "/storage/logs/2*");
            echo "Done!!";
            $this->googbye();
        } else {
            echo "Canceled!!";
        }
    }
}