<?php
require 'vendor/autoload.php';

$proxy = new \app\Controller\ProxyController();

$proxy_model = new \app\Models\Proxy();


$server = $proxy_model->getProxyLimit(3000,2640);

$proxy -> getMultiProxy($server);


