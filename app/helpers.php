<?php

if (!function_exists('env')) {

    /**
     * Get ENV variable
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    function env($name, $default = null)
    {
        return $_ENV[$name] ? : $default;
    }
}

if (!function_exists('request')) {
    /**
     * Get request parameter
     *
     * @return mixed|object
     */
    function requeset() {
        $result = json_decode(file_get_contents("php://input"));
        if (!$result) {
            $result = (object)$_GET;
        }
        return $result;
    }
}