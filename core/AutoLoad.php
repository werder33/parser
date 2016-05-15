<?php


class AutoLoad
{
    public function Load($className)
    {
        $arr = explode('\\', $className);

        $name = implode('/', $arr);
        $file = $name . ".php";
        if (file_exists($file)) {
            require_once $file;
        } else {
            echo "Error: Autoload";
        }
    }
}
