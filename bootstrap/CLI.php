<?php
namespace Boot;

class CLI
{

    public static function run() {
        $param = array();
        $argv = $_SERVER['argv'];
        foreach ($argv as $k => $v) {
            if (preg_match('/run/', $v)) unset($argv[$k]);
        }
        $argv = array_shift($argv);
        $argv = explode(':', $argv);
        if (isset($argv[1])) $argv[1] = explode(',', $argv[1]);
        $command = empty($argv[0]) ? 'Help' : array_shift($argv);
        if (isset($argv[0])) $param = $argv[0];
        $command = explode('/', $command);
        $method = 'start';

        $entryClass = '\App\Console\Commands';
        foreach ($command as $value) {
            $entryClass = $entryClass . '\\' . $value;
        }
        $entryClass = new $entryClass;
        try {
            call_user_func_array(array($entryClass,$method), $param);
        } catch (\Throwable $e) {
            \App\Log::error($e);
        }
    }
}