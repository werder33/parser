<?php
require 'vendor/autoload.php';

$proxy = new \app\Controller\ProxyController();

$proxy_model = new \app\Models\Proxy();


$server = $proxy_model->getProxyLimit(0,1000);

$proxy -> getMultiProxy($server);


