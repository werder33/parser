<?php

require 'core' . DIRECTORY_SEPARATOR . 'AutoLoad.php';
use core\Router;

//автозагрузка
$autoLoad = new AutoLoad();
spl_autoload_register([$autoLoad, 'Load']);

//маршрутизатор
define('ROOT', dirname(__FILE__));

//require_once(ROOT.'\vendor\Router.php');
$router = new Router();
$router->Start();




/*E:\OpenServer\modules\php\PHP-5.6\php E:\OpenServer\domains\parser\src\index.php*/
/*
192.168.56.101*/