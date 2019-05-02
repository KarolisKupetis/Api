<?php

namespace View;

class RouteGenerator
{
    public static $validRoutes = array();

    public static function set($route, $function)
    {
        $url = $_GET['url'];
        $keys = parse_url($url);
        $path = explode("/", $keys['path']);

        $lastUrlElement = end($path);
        $urlParamCount = count($path);

        if(is_numeric($path[$urlParamCount-1]))
        {
            $lastUrlElement=$path[$urlParamCount-2];
        }

        self::$validRoutes[] = $route;

        if ($lastUrlElement===$route)
        {
            $function->__invoke();
        }

        else http_response_code(404);
    }
}