<?php

namespace core;


class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/app/route.php';
        $this->routes = include($routesPath);

    }

    //возващает строку (url)
    private function getUrl()
    {
        $url = urldecode(trim(($_SERVER['REQUEST_URI'])));
        return $url;
    }


    public function Start()
    {

        $url = $this->getUrl(); // url строка
        $arr = $this->routes;   // роуты из массива app\route.php


        if (isset($arr[$url])) {
            $controller = $arr[$url];
            $controllerArray = explode('@', $controller);
            $controllerName = array_shift($controllerArray);
            $actionName = array_shift($controllerArray);
            $controllerFile = 'app\\Controller\\' . $controllerName;
            $controllerObj = new $controllerFile;
            $controllerObj->$actionName();


        } else {
            View::render('404');
        }
    }


}
