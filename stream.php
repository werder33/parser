<?php

require 'vendor/autoload.php';


$proxy = new \app\Controller\ProxyController();
$proxy -> proxyAPI(5000);

