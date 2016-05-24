<?php
require 'vendor/autoload.php';

$proxy = new \app\Controller\ProxyController();
echo "PROXY LOADING... \n";

$proxy->searchProxy();
$proxy->searchProxy2();
$proxy->searchProxy5();    // парсинг списков прокси
$proxy->searchProxy4();
$proxy->searchProxy6();
$proxy->searchProxy7();

$proxy->getProxy(); //проверка прокси