<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 01.04.2016
 * Time: 14:21
 */

namespace core;


class View
{
    static function render($fileName, $args = array())
    {
        extract($args);
        $path = "app/View/" . $fileName . ".php";
        ob_start();
        require_once($path);
        $page = ob_get_clean();

        require_once("app/View/templates/layout.php");

    }

    static function redirect($path)
    {
        header("Location: $path");

    }
}